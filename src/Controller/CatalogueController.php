<?php

namespace App\Controller;

use App\Entity\Catalogue;
use App\Form\CatalogueType;
use App\Repository\CatalogueRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Routing\Annotation\Route;


class CatalogueController extends AbstractController
{
    // Display all catalogs
    #[IsGranted("ROLE_USER")]
    #[Route('/catalog/{page<\d+>?1}/{order?}/{column?}', name: 'app_catalog')]
    public function catalogue(
        $page, $order, $column,
        CatalogueRepository $repo,
        PaginatorInterface $paginator,
        Request $request,
        Session $session
    ): Response {

        // Empty search value from session
        $session->remove('search');

        if ($page) $session->set('page',$page);

        // Get search input
        $search = $request->query->get('search');
        if (!empty($search)) {
            $session->set('search', $request->query->get('search'));
        };
        
        if ($order) $search = $session->get('search');

        // Order by title
        if ($column == 'title' or $column == null){
            $catalogues = $repo->findByOrderTitle($search,$order);
        }

        // Order by identifier
        if ($column == 'identifier' or $column == null){
            $catalogues = $repo->findByOrderIdentifier($search,$order);
        }

        // Paginator
        $data = $paginator->paginate($catalogues, $request->query->getInt('page', $page), 10);

        return $this->render('catalogue/catalogues.html.twig', [
            'catalogues' => $data,
        ]);
    }

    // Add new catalog
    #[IsGranted("ROLE_USER")]
    #[Route('/catalog/new', name: 'app_catalog_new')]
    public function new(
        Request $request,
        EntityManagerInterface $manager
    ): Response {
        $catalogue = new Catalogue();
        $form = $this->createForm(CatalogueType::class, $catalogue);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $manager->persist($catalogue);
            $manager->flush();
            $title = $catalogue->getTitle();

            $this->addFlash("success","Catalogue $title was added successfully");
            return $this->redirectToRoute('app_catalog');
        }
        return $this->render('catalogue/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    // Edit a catalog
    #[IsGranted("ROLE_USER")]
    #[Route('/catalog/edit/{id}', name: 'app_catalog_edit')]
    public function edit(
        Request $request,
        Session $session,
        Catalogue $catalogue,
        EntityManagerInterface $manager
    ): Response {
        $form = $this->createForm(CatalogueType::class, $catalogue);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $manager->persist($catalogue);
            $manager->flush();
            $title = $catalogue->getTitle();
            $page = $session->get('page');
            $search = $session->get('search');
            $this->addFlash("success","Catalogue $title was edited successfully");
            return $this->redirectToRoute('app_catalog', ['search' => $search,'page'=>$page]);
        }
        return $this->render('catalogue/edit.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    // Delete a catalog
    #[IsGranted("ROLE_USER")]
    #[Route('/catalog/delete/{id}', name: 'app_catalog_delete')]
    public function delete(
        Catalogue $catalogue,
        EntityManagerInterface $manager,
        Session $session,
    ): Response {
        $title = $catalogue->getTitle();
        $manager->remove($catalogue);
        $manager->flush();
        $search = $session->get('search');

        $this->addFlash('danger',"Catalogue $title was deleted");
        return $this->redirectToRoute('app_catalog', ['search' => $search]);
    }

    // View a catalog
    #[IsGranted("ROLE_USER")]
    #[Route('/catalog/view/{id}', name: 'app_catalog_view')]
    public function view(Catalogue $catalogue): Response {
        $form = $this->createForm(CatalogueType::class, $catalogue);
        return $this->render('catalogue/view.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    // Clear search value
    #[IsGranted("ROLE_USER")]
    #[Route('/catalog/clear', name: 'app_catalog_clear')]
    public function clear(Session $session)
    {
        $session->clear('search');
        return $this->redirectToRoute('app_catalog');
    }

}
