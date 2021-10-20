<?php


namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin")
 */
class BackendController extends AbstractController
{
    /**
     * @Route("/", name="backend_index", methods={"GET"})
     */
    public function backend_index(): Response
    {
        return $this->render('backend/dashboard.html.twig');
    }
}