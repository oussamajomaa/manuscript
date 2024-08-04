<?php

namespace App\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    // #[IsGranted("ROLE_USER")]
    #[Route('/', name: 'app_root')]
    public function home(): Response
    {
        if ($this->getUser())
            return $this->redirectToRoute('app_catalog');
        else
            return $this->redirectToRoute('app_login');
    }

    // // #[IsGranted("ROLE_USER")]
    // #[Route('/home', name: 'app_home')]
    // public function root(): Response
    // {
        
    //     return $this->render('home/index.html.twig', [
    //         'controller_name' => 'HomeController',
    //     ]);
    // }
}
