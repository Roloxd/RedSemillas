<?php

namespace App\Controller;

use App\Repository\EnvaseRepository;
use DateTime;
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
    public function index(EnvaseRepository $envase): Response
    {
        $envasesDB = $envase->findAll();
        $yearActual = new DateTime(date('Y-m-d'));

        foreach($envasesDB as $envaseDB){
            $germinacionesDB = $envaseDB->getGerminaciones()->getValues();
            $UnidadesGramos = $envaseDB->getUnidadesGramo();
            $fechaRecoleccion = $envaseDB->getFechaRecoleccion();

            
            if(!empty($fechaRecoleccion)) {
                $diff = $fechaRecoleccion->diff($yearActual);
            } else {
                $fechaEnvasado = $envaseDB->getFechaEnvasado();
                
                if(!empty($fechaEnvasado)) {
                    $diff = $fechaEnvasado->diff($yearActual);
                }
            }

            //Obtener viabilidad de cada Variedad relacionada con el Envase
            $variedadesDB = $envaseDB->getVariedads()->getValues();
            
            foreach($variedadesDB as $variedadDB) {
                $viabilidad = $variedadDB->getViabilidadMin();
                $antiguedad[$variedadDB->getId()] = $diff->y - $viabilidad;


                //Alerta Cantidad *Falta hacer los calculos*
                foreach($germinacionesDB as $germinacionDB) {
                    $porcentajeGerminacion = $germinacionDB->getPorcentajeGerminacionMuestra();

                    
                    dump($porcentajeGerminacion);
                }
            }
        }

        return $this->render('visualizacion/index.html.twig', [
            'envases' => $envasesDB,
            'antiguedad' => $antiguedad,
        ]);
    }
}