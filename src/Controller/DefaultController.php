<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends AbstractController
{
    #[Route('/default', name: 'default')]
    public function index(): Response
    {
        return $this->render('default/index.html.twig', [
            'controller_name' => 'DefaultController',
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
