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
use Symfony\Component\Validator\Constraints\Date;

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

            $this->newRevisiones($revisionesDatos, $germinacion); // Registra las revisiones en la DB, los relaciona con la Germinación actual y calcula los datos de Temperatura y Humedad

            dump($germinacion);
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

            // Semillas no germinadas
            $revision->setSemillasNoGerminadas( intval($revisionDatos['semillas_no_germinadas']) );

            // Semillas anómalas
            $revision->setSemillasAnomalas( intval($revisionDatos['semillas_anomalas']) );

            // Semillas enfermas
            $revision->setSemillasEnfermas( intval($revisionDatos['semillas_enfermas']) );

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

        // Actulaiza los datos en Germinación
        $this->actualizarTemperaturas($germinacion, $actualizar);

    }

    public function actualizarTemperaturas(Object $germinacion, Array $actualizar): void {
        // Si Germinacion tiene una Fecha final
        if( !empty($germinacion->getFechaFinal()) ) {
            // Calcular datos (Temperatura y Humedad)
            $germinacion->setTemperaturaMax( max($actualizar['temperaturas_max']) );
            $germinacion->setTemperaturaMin( min($actualizar['temperaturas_min']) );

            //Continuar...
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
