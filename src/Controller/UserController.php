<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends AbstractController
{

    // Display all users
    #[IsGranted("ROLE_USER")]
    #[Route('/user/{page<\d+>?1}', name: 'app_user')]
    public function user(
        $page,
        UserRepository $repo,
        PaginatorInterface $paginator,
        Request $request,
        Session $session
        ): Response
    {
        $session->remove('search');
        if ($page) $session->set('page',$page);
        else $page = 1;
        $users = $repo->findAll();
        
        $data = $paginator->paginate($users, $request->query->getInt('page', $page), 10);
        return $this->render('user/users.html.twig', [
            'users' => $data,
        ]);
    }

    // Edit a role user
    #[IsGranted("ROLE_ADMIN")]
    #[Route('/user/edit/{id}', name: 'app_user_edit')]
    public function edit(
        Request $request,
        Session $session,
        User $user,
        EntityManagerInterface $manager
    ): Response {
        $email = $user->getEmail();
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);
        $role = $user->getRoles()[0];
        if ($form->isSubmitted() && $form->isValid()) {
            $role=$form['roles']->getData();
            $user->setRoles([$role]);
            $manager->persist($user);
            $manager->flush();
            $page = $session->get('page');
            $this->addFlash("success","User $email was edited successfully");
            return $this->redirectToRoute('app_user', ['page'=>$page]);
            
        }
        return $this->render('user/edit.html.twig', [
            'form'  => $form->createView(),
            'role'  => $role
        ]);
    }

    // Delet a user
    #[IsGranted("ROLE_ADMIN")]
    #[Route('/user/delete/{id}', name: 'app_user_delete')]
    public function delete(
        User $user,
        EntityManagerInterface $manager
    ): Response {
        $email = $user->getEmail();
        $manager->remove($user);
        $manager->flush();
        $this->addFlash("danger","User $email was deleted successfully");
        return $this->redirectToRoute('app_user');
    }

   
}
