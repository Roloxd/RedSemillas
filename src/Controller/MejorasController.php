<?php

namespace App\Controller;

use App\Entity\Mejoras;
use App\Form\MejorasType;
use App\Repository\MejorasRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/mejoras")
 */
class MejorasController extends AbstractController
{
    /**
     * @Route("/", name="mejoras_index", methods={"GET"})
     */
    public function index(MejorasRepository $mejorasRepository): Response
    {
        return $this->render('mejoras/index.html.twig', [
            'mejoras' => $mejorasRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="mejoras_new", methods={"GET", "POST"})
     */
    public function new(Request $request): Response
    {
        $text_form = "Nueva Mejorador";
        $mejora = new Mejoras();
        $form = $this->createForm(MejorasType::class, $mejora);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($mejora);
            $entityManager->flush();

            return $this->redirectToRoute('mejoras_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('mejoras/new.html.twig', [
            'text_form' => $text_form,
            'mejora' => $mejora,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="mejoras_show", methods={"GET"})
     */
    public function show(Mejoras $mejora): Response
    {
        return $this->render('mejoras/show.html.twig', [
            'mejora' => $mejora,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="mejoras_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Mejoras $mejora): Response
    {
        $text_form = "Editar Mejorador";
        $form = $this->createForm(MejorasType::class, $mejora);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('mejoras_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('mejoras/edit.html.twig', [
            'text_form' => $text_form,
            'mejora' => $mejora,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="mejoras_delete", methods={"POST"})
     */
    public function delete(Request $request, Mejoras $mejora): Response
    {
        if ($this->isCsrfTokenValid('delete'.$mejora->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($mejora);
            $entityManager->flush();
        }

        return $this->redirectToRoute('mejoras_index', [], Response::HTTP_SEE_OTHER);
    }
}
