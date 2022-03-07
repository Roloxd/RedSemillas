<?php

namespace App\Controller;

use App\Entity\Entrada;
use App\Entity\Fitosanitario;
use App\Form\FitosanitarioType;
use App\Repository\EntradaRepository;
use App\Repository\FitosanitarioRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/fitosanitario")
 */
class FitosanitarioController extends AbstractController
{
    /**
     * @Route("/", name="fitosanitario_index", methods={"GET"})
     */
    public function index(FitosanitarioRepository $fitosanitarioRepository): Response
    {
        return $this->render('fitosanitario/index.html.twig', [
            'fitosanitarios' => $fitosanitarioRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="fitosanitario_new", methods={"GET", "POST"})
     */
    public function new(Request $request, EntradaRepository $entradaRepository): Response
    {
        $text_form = "Nuevo Fitosanitario";
        $fitosanitario = new Fitosanitario();
        $form = $this->createForm(FitosanitarioType::class, $fitosanitario);
        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            $text = '';
            $datos = $request->request->get('fitosanitario');

            // Campos: Forma de detección de la patología
            if( isset($datos['fordet'])  && !empty($datos['fordet']) ) {
                $values = $datos['fordet'];
                $text = $this->convertArrayinText($values, $text);
                $fitosanitario->setFordet($text);
                $text = '';
            }
            // Campo: Método de detección
            if( isset($datos['metdet']) && !empty($datos['metdet']) ) {
                $values = $datos['metdet'];
                $text = $this->convertArrayinText($values, $text);
                $fitosanitario->setMetdet($text);
                $text = '';
            }
            // Campo: Fitopatología
            if( isset($datos['fitpat']) && !empty($datos['fitpat']) ) {
                $values = $datos['fitpat'];
                $text = $this->convertArrayinText($values, $text);
                $fitosanitario->setFitpat($text);
                $text = '';
            }
            // Campo: Pátogeno detectado
            if( isset($datos['patdet']) && !empty($datos['patdet']) ) {
                $values = $datos['patdet'];
                $text = $this->convertArrayinText($values, $text);
                $fitosanitario->setPatdet($text);
                $text = '';
            }

            // Campo: Entrada
            if( isset($datos['entrada']) && !empty($datos['entrada']) ) {
                if( $datos['entrada'] !== "" ) {
                    $entrada = $this->getEntrada( intval($datos['entrada']) ); 
                    $fitosanitario->setEntrada($entrada);
                }
            }

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($fitosanitario);
            $entityManager->flush();

            return $this->redirectToRoute('fitosanitario_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('fitosanitario/new.html.twig', [
            'text_form' => $text_form,
            'fitosanitario' => $fitosanitario,
            'form' => $form,
            'entradas' => $entradaRepository->findAll(),
        ]);
    }

    /**
     * @Route("/{id}", name="fitosanitario_show", methods={"GET"})
     */
    public function show(Fitosanitario $fitosanitario): Response
    {
        return $this->render('fitosanitario/show.html.twig', [
            'fitosanitario' => $fitosanitario,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="fitosanitario_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Fitosanitario $fitosanitario, EntradaRepository $entradaRepository): Response
    {
        $text_form = "Editar Fitosanitario";
        $form = $this->createForm(FitosanitarioType::class, $fitosanitario);
        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            $text = '';
            $datos = $request->request->get('fitosanitario');
            
            // Campos: Forma de detección de la patología
            if( isset($datos['fordet'])  && !empty($datos['fordet']) ) {
                $values = $datos['fordet'];
                $text = $this->convertArrayinText($values, $text);
                $fitosanitario->setFordet($text);
                $text = '';
            } else {
                $fitosanitario->setFordet(null); 
            }
            // Campo: Método de detección
            if( isset($datos['metdet']) && !empty($datos['metdet']) ) {
                $values = $datos['metdet'];
                $text = $this->convertArrayinText($values, $text);
                $fitosanitario->setMetdet($text);
                $text = '';
            } else {
                $fitosanitario->setMetdet(null);
            }
            // Campo: Fitopatología
            if( isset($datos['fitpat']) && !empty($datos['fitpat']) ) {
                $values = $datos['fitpat'];
                $text = $this->convertArrayinText($values, $text);
                $fitosanitario->setFitpat($text);
                $text = '';
            } else {
                $fitosanitario->setFitpat(null);
            }
            // Campo: Pátogeno detectado
            if( isset($datos['patdet']) && !empty($datos['patdet']) ) {
                $values = $datos['patdet'];
                $text = $this->convertArrayinText($values, $text);
                $fitosanitario->setPatdet($text);
                $text = '';
            } else {
                $fitosanitario->setPatdet(null);
            }

            // Campo: Entrada
            if( isset($datos['entrada']) && !empty($datos['entrada']) ) {
                if( $datos['entrada'] !== "" ) { // Añadir entrada
                    $entrada = $this->getEntrada( intval($datos['entrada']) );
                    $fitosanitario->setEntrada($entrada);
                }
            }

            $this->getDoctrine()->getManager()->flush();
            return $this->redirectToRoute('fitosanitario_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('fitosanitario/edit.html.twig', [
            'text_form' => $text_form,
            'fitosanitario' => $fitosanitario,
            'form' => $form,
            'entradas' => $entradaRepository->findAll(),
        ]);
    }

    /**
     * @Route("/{id}", name="fitosanitario_delete", methods={"POST"})
     */
    public function delete(Request $request, Fitosanitario $fitosanitario): Response
    {
        if ($this->isCsrfTokenValid('delete'.$fitosanitario->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($fitosanitario);
            $entityManager->flush();
        }

        return $this->redirectToRoute('fitosanitario_index', [], Response::HTTP_SEE_OTHER);
    }

    public function convertArrayinText($values = [], $text = '') : string
    {
        foreach( $values as $key => $value ) {
            $text .= $value;

            if( isset($values[$key+1]) ) {
                $text .= ", ";
            }
        }
        return $text;
    }

    public function getEntrada(int $idEntrada): object
    {
        $entrada = $this->getDoctrine()
            ->getRepository(Entrada::class)
            ->find($idEntrada);

        return $entrada;
    }
}
