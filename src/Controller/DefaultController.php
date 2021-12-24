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

            if(!empty($variedadDB->getEspecie())){
                $especies[$variedadDB->getId()] = $variedadDB->getEspecie()->getNombre();
                

                if(!empty($variedadDB->getEspecie()->getSubtaxon())){
                    $subtaxons[$variedadDB->getId()] = $variedadDB->getEspecie()->getSubtaxon();
                } else{
                    $subtaxons[$variedadDB->getId()] = "";
                }

                if(!empty($variedadDB->getEspecie()->getPadre())){
                    $generoObject = $this->getDoctrine()
                        ->getRepository(Taxon::class)
                        ->find($variedadDB->getEspecie()->getPadre());

                    $generos[$variedadDB->getId()] = $generoObject->getNombre();

                    if(!empty($generoObject->getPadre())){
                        $familiaObject = $this->getDoctrine()
                            ->getRepository(Taxon::class)
                            ->find($generoObject->getPadre());
                        
                            $familias[$variedadDB->getId()] = $familiaObject->getNombre();
                    }
                }
            } else {
                $especies[$variedadDB->getId()] = "";
                $generos[$variedadDB->getId()] = "";
                $familias[$variedadDB->getId()] = "";
                $subtaxons[$variedadDB->getId()] = "";
            }

            // if(empty($variedadDB->getImagenSeleccionada())){
            //     $imagenes[$variedadDB->getId()] = "/images/home_home_rgcs_impression.png";
            // }else {
            //     // $imagenes[$variedadDB->getId()] = "/uploads/img/" . $variedadDB->getImagenSeleccionada()->getImagen()->getUrl();
            //     $imagenes[$variedadDB->getId()] = "/images/home_home_rgcs_impression.png";
            // }

            
        }

        return $this->render('vista-catalogo.html.twig',[
            'variedades' => $variedadesDB,
            // 'imagenes' => $imagenes,
            'especies' => $especies,
            'generos' => $generos,
            'familias' => $familias,
            'subtaxons' => $subtaxons,
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
