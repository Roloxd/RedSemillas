<?php

namespace App\Controller;

use App\Entity\Entrada;
use App\Form\Entrada1Type;
use App\Repository\EntradaRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/entrada')]
class EntradaController extends AbstractController
{
    #[Route('/', name: 'entrada_index', methods: ['GET'])]
    public function index(EntradaRepository $entradaRepository): Response
    {
        return $this->render('entrada/index.html.twig', [
            'entradas' => $entradaRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'entrada_new', methods: ['GET','POST'])]
    public function new(Request $request): Response
    {
        $entrada = new Entrada();
        $form = $this->createForm(Entrada1Type::class, $entrada);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($entrada);
            $entityManager->flush();

            return $this->redirectToRoute('entrada_index', [], Response::HTTP_SEE_OTHER);
        }

        $text = 'Nueva Entrada';

        return $this->renderForm('entrada/new.html.twig', [
            'entrada' => $entrada,
            'form' => $form,
            'text_form' => $text,
        ]);
    }

    #[Route('/{id}', name: 'entrada_show', methods: ['GET'])]
    public function show(Entrada $entrada): Response
    {
        return $this->render('entrada/show.html.twig', [
            'entrada' => $entrada,
        ]);
    }

    #[Route('/{id}/edit', name: 'entrada_edit', methods: ['GET','POST'])]
    public function edit(Request $request, Entrada $entrada): Response
    {
        $form = $this->createForm(Entrada1Type::class, $entrada);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('entrada_index', [], Response::HTTP_SEE_OTHER);
        }

        $text = 'Editar Entrada';

        return $this->renderForm('entrada/edit.html.twig', [
            'entrada' => $entrada,
            'form' => $form,
            'text_form' => $text,
        ]);
    }

    #[Route('/{id}', name: 'entrada_delete', methods: ['POST'])]
    public function delete(Request $request, Entrada $entrada): Response
    {
        if ($this->isCsrfTokenValid('delete'.$entrada->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($entrada);
            $entityManager->flush();
        }

        return $this->redirectToRoute('entrada_index', [], Response::HTTP_SEE_OTHER);
    }
}
