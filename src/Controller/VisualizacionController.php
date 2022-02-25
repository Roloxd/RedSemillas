<?php

namespace App\Controller;

use App\Entity\Entrada;
use App\Entity\Envase;
use App\Repository\EntradaRepository;
use App\Repository\EnvaseRepository;
use App\Repository\VariedadRepository;
use DateTime;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/vista")
 */
class VisualizacionController extends AbstractController {
    /**
     * @Route("/alarmas", name="vista_alarmas", methods={"GET"})
     */
    public function alarmas(EnvaseRepository $envase): Response
    {
        $envasesDB = $envase->findAll();
        $yearActual = new DateTime(date('Y-m-d'));

        foreach($envasesDB as $envaseDB){
            $germinacionesDB = $envaseDB->getGerminaciones()->getValues();
            $unidadesGramos = $envaseDB->getUnidadesGramo();
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
            }

            //Alerta Cantidad *Falta hacer los calculos*
            if(!empty($germinacionesDB)) {
                foreach($germinacionesDB as $germinacionDB) {
                    $variedadDB = $germinacionDB->getVariedad();
                    $codigoVariedad = 'VAR-' . $variedadDB->getCodigo();

                    $porcentajeGerminacion = $germinacionDB->getPorcentajeGerminacionMuestra();
                    $ud = ($unidadesGramos * $porcentajeGerminacion) / 100;
                    
                    if($variedadDB->getPolinizacion() === 'Autógama') {
                        if($ud < 50) {
                            $arrayCantidades[$envaseDB->getId()][$codigoVariedad]['blue'] = 'Insuficiente';
                        }
                        if($ud >= 50 && $ud <= 300) {
                            $arrayCantidades[$envaseDB->getId()][$codigoVariedad]['red'] = 'Crítica';
                        }
                        if($ud >= 300 && $ud <= 5200) {
                            $arrayCantidades[$envaseDB->getId()][$codigoVariedad]['orange'] = 'Multiplicar/Custodiar';
                        }
                        if($ud >= 5201 && $ud <= 6000) {
                            $arrayCantidades[$envaseDB->getId()][$codigoVariedad]['yellow'] = 'Conservar';
                        }
                        if($ud > 6000) {
                            $arrayCantidades[$envaseDB->getId()][$codigoVariedad]['green'] = 'Distribuir';
                        }
                    } else {
                        if($ud < 300) {
                            $arrayCantidades[$envaseDB->getId()][$codigoVariedad]['blue'] = 'Insuficiente';
                        }
                        if($ud >= 300 && $ud <= 2400) {
                            $arrayCantidades[$envaseDB->getId()][$codigoVariedad]['red'] = 'Crítica';
                        }
                        if($ud >= 2401 && $ud <= 12400) {
                            $arrayCantidades[$envaseDB->getId()][$codigoVariedad]['orange'] = 'Multiplicar/Custodiar';
                        }
                        if($ud >= 12401 && $ud <= 13000) {
                            $arrayCantidades[$envaseDB->getId()][$codigoVariedad]['yellow'] = 'Conservar';
                        }
                        if($ud > 13000) {
                            $arrayCantidades[$envaseDB->getId()][$codigoVariedad]['green'] = 'Distribuir';
                        }
                    }
                }
            } else {
                $arrayCantidades[$envaseDB->getId()]['sinGerminacion'] = 'Sin germinaciones';
            }
        }

        return $this->render('visualizacion/alarmas.html.twig', [
            'envases' => $envasesDB,
            'antiguedad' => $antiguedad,
            'arrayCantidades' => $arrayCantidades,
        ]);
    }

    /**
     * @Route("/megatabla", name="vista_megatabla", methods={"GET"})
     */
    public function megatabla(VariedadRepository $variedadRepository): Response
    {
        dump($variedadRepository->findAllMegaTabla());
        return $this->render('visualizacion/megaTabla.html.twig', [
            'variedades' => $variedadRepository->findAll(),
        ]);
    }
}