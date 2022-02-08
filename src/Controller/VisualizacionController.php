<?php

namespace App\Controller;

use App\Repository\VariedadRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/visualizacion")
 */
class VisualizacionController extends AbstractController {
    /**
     * @Route("/", name="visualizacion_index", methods={"GET"})
     */
    public function index(VariedadRepository $variedad): Response
    {
        return $this->render('visualizacion/index.html.twig', [
            'variedades' => $variedad->findAll(),
        ]);
    }
}