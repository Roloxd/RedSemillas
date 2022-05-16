<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/user")
 */

class UserController extends AbstractController
{
     /**
     * @Route("/", name="user_index", methods={"GET"})
     */
    public function user_index(): Response
    {
        return $this->render('backend/user-dashboard.html.twig');
    }
}
