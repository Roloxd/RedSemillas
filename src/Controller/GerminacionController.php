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

            return $this->redirectToRoute('germinacion_index', [], Response::HTTP_SEE_OTHER);
        }

        $text_form = "Nueva Germinación";

        return $this->renderForm('germinacion/new.html.twig', [
            'germinacion' => $germinacion,
            'form' => $form,
            'text_form' => $text_form,
        ]);
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

    public static function actualizarPorcentajes(Revision $revision) {

        $germinacion = $revision->getGerminacion();
        $numTotalSemillas = $germinacion->getNumSemillasParaPrueba();

        $porcentajeGerminadas = ($revision->getSemillasGerminadas() * 100) / $numTotalSemillas;
        $porcentajeNoGerminadas = ($revision->getSemillasNoGerminadas() * 100) / $numTotalSemillas;
        $porcentajeAnomalas = ($revision->getSemillasAnomalas() * 100) / $numTotalSemillas;
        $porcentajeEnfermas = ($revision->getSemillasEnfermas() * 100) / $numTotalSemillas;

        $germinacion->getPorcentajeGerminacionMuestra($porcentajeGerminadas);
        $germinacion->getPorcentajeSemillasNoGerminadasMuestra($porcentajeNoGerminadas);
        $germinacion->getPorcentajeSemillasGerminacionAnomalaMuestra($porcentajeAnomalas);
        $germinacion->getPorcentajeSemillasGerminacionEnfermasMuestra($porcentajeEnfermas);

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($germinacion);
        $entityManager->flush();
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
