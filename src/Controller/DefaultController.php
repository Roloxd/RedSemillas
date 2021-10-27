<?php

namespace App\Controller;

use App\Entity\Variedad;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends AbstractController
{
    #[Route('/', name: 'index', methods: ["GET"] )]
    public function index(): Response
    {
        return $this->render('home.html.twig');
    }

    #[Route('/quienes-somos', name: 'quienes-somos', methods: ["GET"] )]
    public function quienessomos(): Response
    {
        return $this->render('quienes-somos.html.twig');
    }

    #[Route('/socios', name: 'socios', methods: ["GET"] )]
    public function socios(): Response
    {
        return $this->render('como-funcionamos.html.twig');
    }

    #[Route('/catalogo', name: 'catalogo', methods: ["GET"] )]
    public function catalogo(): Response
    {
        $variedades = $this->getDoctrine()
            ->getRepository(Variedad::class)
            ->findAll();
            
        return $this->render('vista-catalogo.html.twig',[
            'variedades' => $variedades,
            'titulo' => 'Catálogo',
        ]);
    }

    #[Route('/correo', name: 'correo')]
    public function email($name = "Cesar", \Swift_Mailer $mailer)
    {
        $message = (new \Swift_Message('Hello Email'))
            ->setFrom('cesar@etnonautas.com')
            ->setTo('estudiantes.etnonautas@gmail.com')
            ->setBody(
                'Hola'
                // $this->renderView(
                //     // templates/emails/registration.html.twig
                //     'emails/email.txt.twig',
                //     ['name' => $name]
                // )
                // 'text/html'
            )

            // // you can remove the following code if you don't define a text version for your emails
            // ->addPart(
            //     $this->renderView(
            //         // templates/emails/registration.txt.twig
            //         'emails/registration.html.twig',
            //         ['name' => $name]
            //     ),
            //     'text/html'
            // )
        ;

        $mailer->send($message);

        return $this->render('emails/registration.html.twig', [
            'controller_name' => 'DefaultController',
            'name' => $name,
        ]);
    }
}
