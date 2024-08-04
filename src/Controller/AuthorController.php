<?php

namespace App\Controller;

use App\Entity\PrimaryCreator;
use App\Entity\SecondaryCreator;
use App\Form\AuthorType;
use App\Repository\PrimaryCreatorRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Routing\Annotation\Route;

class AuthorController extends AbstractController
{
    // Display all authors with pagination
    #[IsGranted("ROLE_USER")]
    #[Route('/author/{page<\d+>?1}/{order?}/{column?}', name: 'app_author')]
    public function index(
        $page, $order, $column,
        PrimaryCreatorRepository $repoPrimary,
        PaginatorInterface $paginator,
        Request $request,
        Session $session): Response
    {
        $session->remove('search');
        // Store page number in session
        if ($page) $session->set('page',$page);

        // Get request search ans store it in session
        $search = $request->query->get('search');
        if (!empty($search)) {
            $session->set('search', $request->query->get('search'));
        }

        if ($order) $search = $session->get('search');
        if ($column == 'first_name' or $column == null){
            $authors = $repoPrimary->findByValueOrderFirst($search,$order);
        }
        if ($column == 'last_name'){
            $authors = $repoPrimary->findByValueOrderLast($search,$order);
        }
        $data = $paginator->paginate($authors, $request->query->getInt('page', $page), 10);
        return $this->render('author/authors.html.twig', [
            'authors' => $data,
        ]);
    }

    // Add new author
    #[IsGranted("ROLE_USER")]
    #[Route('/author/new', name: 'app_author_new')]
    public function new(
        Request $request,
        EntityManagerInterface $manager
    ): Response {
        $primaryCreator = new PrimaryCreator();
        $secondaryCreator = new SecondaryCreator();
        $form = $this->createForm(AuthorType::class, $primaryCreator);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $fisrtName = $form->get('first_name')->getData();
            $lastName = $form->get('last_name')->getData();
            $authorityLink = $form->get('authority_link')->getData();
            $secondaryCreator->setFirstName($fisrtName)
                ->setLastName($lastName)
                ->setAuthorityLink($authorityLink);

            $manager->persist($primaryCreator);
            $manager->persist($secondaryCreator);
            $manager->flush();
            $name = $primaryCreator->getFirstName() . ' '. $primaryCreator->getLastName();
            $this->addFlash("success","Author $name was added successfully");
            return $this->redirectToRoute('app_author');
        }
        return $this->render('author/new.html.twig', [
            'form' => $form->createView(),

        ]);
    }

    // Edit an author
    #[IsGranted("ROLE_USER")]
    #[Route('/author/edit/{id}', name: 'app_author_edit')]
    public function edit(
        Request $request,
        PrimaryCreator $primaryCreator,
        SecondaryCreator $secondaryCreator,
        EntityManagerInterface $manager,
        Session $session,
    ): Response {
        $form = $this->createForm(AuthorType::class, $primaryCreator);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $fisrtName = $form->get('first_name')->getData();
            $lastName = $form->get('last_name')->getData();
            $authorityLink = $form->get('authority_link')->getData();
            $secondaryCreator->setFirstName($fisrtName)
                ->setLastName($lastName)
                ->setAuthorityLink($authorityLink);

            $manager->persist($primaryCreator);
            $manager->persist($secondaryCreator);
            $manager->flush();

            $search = $session->get('search');
            $page = $session->get('page');

            $name = $primaryCreator->getFirstName() . ' '. $primaryCreator->getLastName();
            $this->addFlash("success","Author $name was edited successfully");
            return $this->redirectToRoute('app_author', ['search' => $search,'page'=>$page]);
        }
        return $this->render('author/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    // Delete an author
    #[IsGranted("ROLE_USER")]
    #[Route('/author/delete/{id}', name: 'app_author_delete')]
    public function delete(
        PrimaryCreator $primaryCreator,
        SecondaryCreator $secondaryCreator,
        EntityManagerInterface $manager
    ): Response {
        $name = $primaryCreator->getFirstName() . ' '. $primaryCreator->getLastName();
        $manager->remove($primaryCreator);
        $manager->remove($secondaryCreator);
        $manager->flush();

        $this->addFlash("danger","Author $name was deleted successfully");
        return $this->redirectToRoute('app_author');
    }

    // Clear search value
    #[IsGranted("ROLE_USER")]
    #[Route('/author/clear', name: 'app_author_clear')]
    public function clear(Session $session){
        $session->clear('search');
        return $this->redirectToRoute('app_author');
    }
}
