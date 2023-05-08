<?php

namespace App\Controller;

use App\Form\NewPasswordType;
use App\Form\ResetPasswordType;
use App\Repository\UserRepository;
use App\Services\Mailer;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Csrf\TokenGenerator\TokenGeneratorInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends AbstractController
{
    #[Route(path: '/login', name: 'app_login')]
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        // if ($this->getUser()) {
        //     return $this->redirectToRoute('target_path');
        // }

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/login.html.twig', ['last_username' => $lastUsername, 'error' => $error]);
    }

    #[Route(path: '/logout', name: 'app_logout')]
    public function logout(): void
    {
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }

    #[Route(path: '/passwordrecovery', name: 'forgotten_password')]
    public function forgotten(
        MailerInterface $mailer,
        Request $request,
        UserRepository $repo,
        TokenGeneratorInterface $tokenGenerator,
        EntityManagerInterface $entityManager,
    ): Response {
        $form = $this->createForm(ResetPasswordType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $email = $form->get('email')->getData();
            $user = $repo->findOneByEmail($email);
            // On vérifie si on a un utilisateur
            if ($user) {
                // On génère un token de réinitialisation
                $token = $tokenGenerator->generateToken();
                $user->setResetToken($token);
                $entityManager->persist($user);
                $entityManager->flush();

                // On génère un lien de réinitialisation du mot de passe
                $url = $this->generateUrl('passwordrecovery', ['token' => $token], UrlGeneratorInterface::ABSOLUTE_URL);

                // On crée les données du mail

                //    Envoi du mail
                $email = (new Email())
                    ->from('osmjom@gmail.com')
                    ->to($email)
                    ->subject('Reset Password')

                    ->html("<p>Hello</p>
                            <p>Pour votre demande de réinitialisation de mot de passe, veuillez cliquer sur le lien suivant $url</p>
                            <p>Thanks</p>");
                $mailer->send($email);


                $this->addFlash('success', 'Email sent successfully. Verify your adress mail please!');
                return $this->redirectToRoute('app_login');
                //    dd($url);
            }
            $this->addFlash('danger', 'A problem has occurred');
            return $this->redirectToRoute('app_login');
        }



        return $this->render('security/reset_password_request.html.twig', [
            'form' => $form->createView()
        ]);
    }

    #[Route('/passwordrecovery/{token}', name: 'reset_pass')]
    public function resetPass(
        string $token,
        Request $request,
        UserRepository $repo,
        EntityManagerInterface $entityManager,
        UserPasswordHasherInterface $passwordHasher
    ): Response {
        // On vérifie si on a ce token dans la base
        $user = $repo->findOneByResetToken($token);

        // On vérifie si l'utilisateur existe
        if ($user) {
            $form = $this->createForm(NewPasswordType::class);

            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                // On efface le token
                $user->setResetToken('');

                // On enregistre le nouveau mot de passe en le hashant
                $user->setPassword(
                    $passwordHasher->hashPassword(
                        $user,
                        $form->get('password')->getData()
                    )
                );
                $entityManager->persist($user);
                $entityManager->flush();

                $this->addFlash('success', 'Password changed successfully');
                return $this->redirectToRoute('app_login');
            }

            return $this->render('security/reset_password.html.twig', [
                'form' => $form->createView()
            ]);
        }

        // Si le token est invalide on redirige vers le login
        $this->addFlash('danger', 'Invalid token');
        return $this->redirectToRoute('app_login');
    }
}
