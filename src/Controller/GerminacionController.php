<?php

namespace App\Controller;

use App\Entity\Germinacion;
use App\Entity\Revision;
use App\Entity\Variedad;
use App\Form\GerminacionType;
use App\Repository\GerminacionRepository;
use DateTime;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


/**
 * @Route("/admin/germinacion")
 */
class GerminacionController extends AbstractController
{
    /**
     * @Route("/", name="germinacion_index", methods={"GET"})
     */
    public function index(GerminacionRepository $germinacionRepository): Response
    {
        return $this->render('germinacion/index.html.twig', [
            'germinacions' => $germinacionRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="germinacion_new", methods={"GET", "POST"})
     */
    public function new(Request $request): Response
    {
        $germinacion = new Germinacion();
        $form = $this->createForm(GerminacionType::class, $germinacion);
        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            $datos = $request->request->get('germinacion');
            $revisionesDatos = $request->request->get('revision');

            // Fecha finalizacion
            if( isset($datos['prueba_finalizada']) && !empty($datos['prueba_finalizada']) ){
                if($datos['prueba_finalizada'] === "1") {
                    $germinacion->setFechaFinal(new DateTime());
                }

                // Número de días en germinar
                if( isset($datos['fecha_inicio']) && !empty($datos['fecha_inicio']) ){
                    $fechaInicio = new DateTime($datos['fecha_inicio']);
                    $fechaFinal = $germinacion->getFechaFinal();
                    
                    $diff = $fechaInicio->diff($fechaFinal);
                    $germinacion->setNumDiasEnGerminar($diff->days);
                }
            }

            // Variedades
            if( isset($datos['variedad']) && !empty($datos['variedad'])) {
                $variedad = $this->getDoctrine()
                    ->getRepository(Variedad::class)
                    ->find( intval($datos['variedad']) );

                $germinacion->setVariedad($variedad);
            }

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($germinacion);
            $entityManager->flush();

            if(!empty($revisionesDatos)) {
                $this->newRevisiones($revisionesDatos, $germinacion); // Registra las revisiones en la DB, los relaciona con la Germinación actual y calcula los datos de Temperatura y Humedad
            }

            return $this->redirectToRoute('germinacion_index', [], Response::HTTP_SEE_OTHER);
        }

        $text_form = "Nueva Germinación";

        return $this->renderForm('germinacion/new.html.twig', [
            'germinacion' => $germinacion,
            'form' => $form,
            'text_form' => $text_form,
        ]);
    }

    public function newRevisiones(Array $revisionesDatos, Object $germinacion): void {
        $actualizar = [];
            
        // Revisiones relacionadas
        $revisionesDB = $germinacion->getRevisiones()->getValues();
        if(!empty($revisionesDB)) {
            foreach($revisionesDB as $revisionDB) {
                
                // Semillas
                $actualizar['semillas_germinadas'][] = intval($revisionDB->getSemillasGerminadas());
                $actualizar['semillas_no_germinadas'][] = intval($revisionDB->getSemillasNoGerminadas());
                $actualizar['semillas_anomalas'][] = intval($revisionDB->getSemillasAnomalas());
                $actualizar['semillas_enfermas'][] = intval($revisionDB->getSemillasEnfermas());
                
                // Temperaturas y Humedades
                $actualizar['temperaturas_max'][] = floatval($revisionDB->getTemperaturaMax());
                $actualizar['temperaturas_min'][] = floatval($revisionDB->getTemperaturaMin());
                $actualizar['humedades_max'][] = floatval($revisionDB->getHumedadMax());
                $actualizar['humedades_min'][] = floatval($revisionDB->getHumedadMin());

            }
        }

        // Revision
        foreach( $revisionesDatos as $revisionDatos ) {
            $revision = new Revision;

            // Fecha inicio
            $revision->setFechaRevision(new DateTime( $revisionDatos['fecha_revision'] ));

            // Fecha final
            if( isset($revisionDatos['revision_finalizada']) && !empty($revisionDatos['revision_finalizada']) ){
                if($revisionDatos['revision_finalizada'] === "1") {
                    $revision->setFechaRevisionFinalizacion(new DateTime());
                } else {
                    $revision->setFechaRevisionFinalizacion(null);
                }
            }

            // Semillas muertas
            $revision->setSemillasMuertas( intval($revisionDatos['semillas_muertas']) );

            // Semillas germinadas
            $revision->setSemillasGerminadas( intval($revisionDatos['semillas_germinadas']) );
            $actualizar['semillas_germinadas'][] = intval($revisionDatos['semillas_germinadas']);

            // Semillas no germinadas
            $revision->setSemillasNoGerminadas( intval($revisionDatos['semillas_no_germinadas']) );
            $actualizar['semillas_no_germinadas'][] = intval($revisionDatos['semillas_no_germinadas']);

            // Semillas anómalas
            $revision->setSemillasAnomalas( intval($revisionDatos['semillas_anomalas']) );
            $actualizar['semillas_anomalas'][] = intval($revisionDatos['semillas_anomalas']);

            // Semillas enfermas
            $revision->setSemillasEnfermas( intval($revisionDatos['semillas_enfermas']) );
            $actualizar['semillas_enfermas'][] = intval($revisionDatos['semillas_enfermas']);


            // Temperaturas
            $revision->setTemperaturaMax( floatval($revisionDatos['temperatura_max']) );
            $actualizar['temperaturas_max'][] = floatval($revisionDatos['temperatura_max']);

            $revision->setTemperaturaMin( floatval($revisionDatos['temperatura_min']) );
            $actualizar['temperaturas_min'][] = floatval($revisionDatos['temperatura_min']);

            // Humedades
            $revision->setHumedadMax( floatval($revisionDatos['humedad_max']) );
            $actualizar['humedades_max'][] = floatval($revisionDatos['humedad_max']);

            $revision->setHumedadMin( floatval($revisionDatos['humedad_min']) );
            $actualizar['humedades_min'][] = floatval($revisionDatos['humedad_min']);

            $revision->setGerminacion($germinacion);

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($revision);
            $entityManager->flush();
        }

        // Porcentajes (Se suman todas las semillas de cada tipo)
        $germinacion = $this->actualizarPorcentajes($germinacion, $actualizar);

        // Actulaiza los datos en Germinación
        $germinacion = $this->actualizarTemperaturas($germinacion, $actualizar);

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($germinacion);
        $entityManager->flush();

    }

    public static function actualizarPorcentajes(Object $germinacion, array $actualizar): object {
        if( !empty($germinacion->getFechaFinal()) ) {
            $num_semillas = $germinacion->getNumSemillasParaPrueba();

            // Semillas Germinadas
            $totalGerminadas = array_sum($actualizar['semillas_germinadas']);
            $porcentajeSemillasGerminadas = ($totalGerminadas * 100) / $num_semillas;
            $germinacion->setPorcentajeGerminacionMuestra($porcentajeSemillasGerminadas);

            // Semillas No Germinadas
            $totalNoGerminadas = array_sum($actualizar['semillas_no_germinadas']);
            $porcentajeSemillasNoGerminadas = ($totalNoGerminadas * 100) / $num_semillas;
            $germinacion->setPorcentajeSemillasNoGerminadasMuestra($porcentajeSemillasNoGerminadas);

            // Semillas Anomalas
            $totalAnomalas = array_sum($actualizar['semillas_anomalas']);
            $porcentajeSemillasAnomalas = ($totalAnomalas * 100) / $num_semillas;
            $germinacion->setPorcentajeSemillasGerminacionAnomalaMuestra($porcentajeSemillasAnomalas);

            // Semillas Enfermas
            $totalEnfermas = array_sum($actualizar['semillas_enfermas']);
            $porcentajeSemillasEnfermas = ($totalEnfermas * 100) / $num_semillas;
            $germinacion->setPorcentajeSemillasGerminacionEnfermasMuestra($porcentajeSemillasEnfermas);

            // $entityManager = $doctrine->getManager();
            // $entityManager->persist($germinacion);
            // $entityManager->flush();

            return $germinacion;
        }
    }

    public static function actualizarTemperaturas(Object $germinacion, Array $actualizar): object {
        // Si Germinacion tiene una Fecha final
        if( !empty($germinacion->getFechaFinal()) ) {

            // Calcular datos (Temperatura y Humedad)
            $temp_max = max($actualizar['temperaturas_max']);
            $temp_min = min($actualizar['temperaturas_min']);
            $hum_max = max($actualizar['humedades_max']);
            $hum_min = min($actualizar['humedades_min']);

            $germinacion->setTemperaturaPruebaGerminacionMax($temp_max);
            $germinacion->setTemperaturaPruebaGerminacionMin($temp_min);

            $germinacion->setHumedadRelativaPruebaGerminacionMax($hum_max);
            $germinacion->setHumedadRelativaPruebaGerminacionMin($hum_min);

            // $entityManager = $this->getDoctrine()->getManager();
            // $entityManager->persist($germinacion);
            // $entityManager->flush();

            return $germinacion;
        }
    }

    /**
     * @Route("/{id}", name="germinacion_show", methods={"GET"})
     */
    public function show(Germinacion $germinacion): Response
    {
        return $this->render('germinacion/show.html.twig', [
            'germinacion' => $germinacion,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="germinacion_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Germinacion $germinacion): Response
    {
        $form = $this->createForm(GerminacionType::class, $germinacion);
        $form->handleRequest($request);
        

        // Comprobar si existe fecha final, para marcar el checbox
        $fecha_final = $germinacion->getFechaFinal();
        $checkboxMarcado = false;
        if(!empty($fecha_final)) {
            $checkboxMarcado = true;
        }

        if ($form->isSubmitted()) {
            $datos = $request->request->get('germinacion');
            $revisionesDatos = $request->request->get('revision');
            

            // Fecha finalizacion
            if(empty($fecha_final)) {
                if( isset($datos['prueba_finalizada']) && !empty($datos['prueba_finalizada']) ){
                    if($datos['prueba_finalizada'] === "1") {
                        $germinacion->setFechaFinal(new DateTime());
                    }

                    // Número de días en germinar
                    if( isset($datos['fecha_inicio']) && !empty($datos['fecha_inicio']) ){
                        $fechaInicio = new DateTime($datos['fecha_inicio']);
                        $fechaFinal = $germinacion->getFechaFinal();
                        
                        $diff = $fechaInicio->diff($fechaFinal);
                        $germinacion->setNumDiasEnGerminar($diff->days);
                    }
                }
            }

            // Variedades
            if( isset($datos['variedad']) && !empty($datos['variedad'])) {
                $variedad = $this->getDoctrine()
                    ->getRepository(Variedad::class)
                    ->find( intval($datos['variedad']) );

                $germinacion->setVariedad($variedad);
            }

            $this->getDoctrine()->getManager()->flush();

            if(!empty($revisionesDatos)) {
                $this->newRevisiones($revisionesDatos, $germinacion);
            }

            return $this->redirectToRoute('germinacion_index', [], Response::HTTP_SEE_OTHER);
        }

        $text_form = "Editar Germinación";

        return $this->renderForm('germinacion/edit.html.twig', [
            'germinacion' => $germinacion,
            'checkboxMarcado' => $checkboxMarcado,
            'form' => $form,
            'text_form' => $text_form,
        ]);
    }

    /**
     * @Route("/{id}", name="germinacion_delete", methods={"POST"})
     */
    public function delete(Request $request, Germinacion $germinacion): Response
    {
        if ($this->isCsrfTokenValid('delete'.$germinacion->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($germinacion);
            $entityManager->flush();
        }

        return $this->redirectToRoute('germinacion_index', [], Response::HTTP_SEE_OTHER);
    }
}
