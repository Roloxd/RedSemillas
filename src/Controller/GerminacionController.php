<?php

namespace App\Controller;

use App\Entity\Germinacion;
use App\Form\GerminacionType;
use App\Repository\GerminacionRepository;
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

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($germinacion);
            $entityManager->flush();

            return $this->redirectToRoute('germinacion_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('germinacion/new.html.twig', [
            'germinacion' => $germinacion,
            'form' => $form,
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

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('germinacion_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('germinacion/edit.html.twig', [
            'germinacion' => $germinacion,
            'form' => $form,
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
