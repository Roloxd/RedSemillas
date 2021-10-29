<?php

namespace App\Controller;

use App\Entity\Variedad;
use App\Form\Variedad1Type;
use App\Repository\VariedadRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/variedades')]
class VariedadController extends AbstractController
{
    #[Route('/', name: 'variedad_index', methods: ['GET'])]
    public function index(VariedadRepository $variedadRepository): Response
    {
        return $this->render('variedad/index.html.twig', [
            'variedades' => $variedadRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'variedad_new', methods: ['GET','POST'])]
    public function new(Request $request): Response
    {
        $variedad = new Variedad();
        $form = $this->createForm(Variedad1Type::class, $variedad);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($variedad);
            $entityManager->flush();

            return $this->redirectToRoute('variedad_index', [], Response::HTTP_SEE_OTHER);
        }

        $text = 'Nueva Variedad';

        return $this->renderForm('variedad/new.html.twig', [
            'variedad' => $variedad,
            'form' => $form,
            'text_form' => $text,
        ]);
    }

    #[Route('/{id}', name: 'variedad_show', methods: ['GET'])]
    public function show(Variedad $variedad): Response
    {
        return $this->render('variedad/show.html.twig', [
            'variedad' => $variedad,
        ]);
    }

    #[Route('/{id}/edit', name: 'variedad_edit', methods: ['GET','POST'])]
    public function edit(Request $request, Variedad $variedad): Response
    {
        $form = $this->createForm(Variedad1Type::class, $variedad);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('variedad_index', [], Response::HTTP_SEE_OTHER);
        }

        $text = 'Editar Variedad';

        return $this->renderForm('variedad/edit.html.twig', [
            'variedad' => $variedad,
            'form' => $form,
            'text_form' => $text,
        ]);
    }

    #[Route('/{id}', name: 'variedad_delete', methods: ['POST'])]
    public function delete(Request $request, Variedad $variedad): Response
    {
        if ($this->isCsrfTokenValid('delete'.$variedad->getIdVariedad(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($variedad);
            $entityManager->flush();
        }

        return $this->redirectToRoute('variedad_index', [], Response::HTTP_SEE_OTHER);
    }
}
