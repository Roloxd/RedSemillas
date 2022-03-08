<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/mapa")
 */
class MejorasController extends AbstractController
{
    /**
     * @Route("/", name="mapa_index", methods={"GET"})
     */
    public function index(): Response
    {
        return $this->render('mapa/index.html.twig');
    }
}