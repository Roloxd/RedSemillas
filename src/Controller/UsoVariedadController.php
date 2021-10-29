<?php

namespace App\Controller;

use App\Entity\UsoVariedad;
use App\Form\UsoVariedadType;
use App\Repository\UsoVariedadRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/uso/variedad')]
class UsoVariedadController extends AbstractController
{
    #[Route('/', name: 'uso_variedad_index', methods: ['GET'])]
    public function index(UsoVariedadRepository $usoVariedadRepository): Response
    {
        return $this->render('uso_variedad/index.html.twig', [
            'uso_variedads' => $usoVariedadRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'uso_variedad_new', methods: ['GET','POST'])]
    public function new(Request $request): Response
    {
        $usoVariedad = new UsoVariedad();
        $form = $this->createForm(UsoVariedadType::class, $usoVariedad);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($usoVariedad);
            $entityManager->flush();

            return $this->redirectToRoute('uso_variedad_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('uso_variedad/new.html.twig', [
            'uso_variedad' => $usoVariedad,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'uso_variedad_show', methods: ['GET'])]
    public function show(UsoVariedad $usoVariedad): Response
    {
        return $this->render('uso_variedad/show.html.twig', [
            'uso_variedad' => $usoVariedad,
        ]);
    }

    #[Route('/{id}/edit', name: 'uso_variedad_edit', methods: ['GET','POST'])]
    public function edit(Request $request, UsoVariedad $usoVariedad): Response
    {
        $form = $this->createForm(UsoVariedadType::class, $usoVariedad);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('uso_variedad_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('uso_variedad/edit.html.twig', [
            'uso_variedad' => $usoVariedad,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'uso_variedad_delete', methods: ['POST'])]
    public function delete(Request $request, UsoVariedad $usoVariedad): Response
    {
        if ($this->isCsrfTokenValid('delete'.$usoVariedad->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($usoVariedad);
            $entityManager->flush();
        }

        return $this->redirectToRoute('uso_variedad_index', [], Response::HTTP_SEE_OTHER);
    }
}
