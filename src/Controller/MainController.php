<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class MainController extends AbstractController
{
    #[Route('/cgu', 'cgu', methods: ['GET'])]
    public function cgu(): Response
    {
        return $this->render('cgu.html.twig');
    }



    #[Route('/mentionslegales', 'mentionslegales', methods: ['GET'])]
    public function show(): Response

    {
        return $this->render('mentionslegales.html.twig');
    }
}
