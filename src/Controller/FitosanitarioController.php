<?php

namespace App\Controller;

use App\Entity\Fitosanitario;
use App\Form\FitosanitarioType;
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
    public function new(Request $request): Response
    {
        $text_form = "Nuevo Fitosanitario";
        $fitosanitario = new Fitosanitario();
        $form = $this->createForm(FitosanitarioType::class, $fitosanitario);
        $form->handleRequest($request);

        if ($form->isSubmitted()) {

            $datos = $request->request->get('fitosanitario');
            dump($datos);
            // $entityManager = $this->getDoctrine()->getManager();
            // $entityManager->persist($fitosanitario);
            // $entityManager->flush();

            //return $this->redirectToRoute('fitosanitario_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('fitosanitario/new.html.twig', [
            'text_form' => $text_form,
            'fitosanitario' => $fitosanitario,
            'form' => $form,
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
    public function edit(Request $request, Fitosanitario $fitosanitario): Response
    {
        $text_form = "Editar Fitosanitario";
        $form = $this->createForm(FitosanitarioType::class, $fitosanitario);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('fitosanitario_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('fitosanitario/edit.html.twig', [
            'text_form' => $text_form,
            'fitosanitario' => $fitosanitario,
            'form' => $form,
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
}
