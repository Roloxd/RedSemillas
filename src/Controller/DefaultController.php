<?php

namespace App\Controller;

use App\Entity\Taxon;
use App\Entity\Variedad;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends AbstractController
{
    /**
     * @Route("/", name="index")
     */
    public function index(): Response
    {
        return $this->render('home.html.twig');
    }

    /**
     * @Route("/quienes-somos", name="quienes-somos")
     */
    public function quienessomos(): Response
    {
        return $this->render('quienes-somos.html.twig');
    }

    /**
     * @Route("/socios", name="socios")
     */
    public function socios(): Response
    {
        return $this->render('como-funcionamos.html.twig');
    }

    /**
     * @Route("/catalogo", name="catalogo")
     */
    public function catalogo(string $imgDir): Response
    {
        $variedadesDB = $this->getDoctrine()
            ->getRepository(Variedad::class)
            ->findAll();

        foreach($variedadesDB as $variedadDB){
            if(!empty($variedadDB->getimagenSeleccionadas()->getValues())) {
                foreach($variedadDB->getimagenSeleccionadas()->getValues() as $imagenesDB) {
                    //Si la imagen es principal
                    if($imagenesDB->getImagen()->getPrincipal() === true){
                        $imagenes[$variedadDB->getId()]['img'] = "/uploads/img/" . $imagenesDB->getImagen()->getUrl();
                        $imagenes[$variedadDB->getId()]['autor'] = $imagenesDB->getImagen()->getCredito();
                        break;
                    } else {
                        $imagenes[$variedadDB->getId()]['img'] = "/images/home_home_rgcs_impression.png";
                        $imagenes[$variedadDB->getId()]['autor'] = "";
                    }
                }
            } else {
                $imagenes[$variedadDB->getId()]['img'] = "/images/home_home_rgcs_impression.png";
                $imagenes[$variedadDB->getId()]['autor'] = "";
            }
        }

        return $this->render('vista-catalogo.html.twig',[
            'variedades' => $variedadesDB,
            'imagenes' => $imagenes,
            'titulo' => 'Catálogo',
        ]);
    }

    /**
     * @Route("/correo", name="correo")
     */
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
