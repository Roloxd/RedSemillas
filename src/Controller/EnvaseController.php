<?php

namespace App\Controller;

use App\Entity\Envase;
use App\Form\EnvaseType;
use App\Repository\EnvaseRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/envase')]
class EnvaseController extends AbstractController
{
    #[Route('/', name: 'envase_index', methods: ['GET'])]
    public function index(EnvaseRepository $envaseRepository): Response
    {
        return $this->render('envase/index.html.twig', [
            'envases' => $envaseRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'envase_new', methods: ['GET','POST'])]
    public function new(Request $request): Response
    {
        $envase = new Envase();
        $form = $this->createForm(EnvaseType::class, $envase);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($envase);
            $entityManager->flush();

            return $this->redirectToRoute('envase_index', [], Response::HTTP_SEE_OTHER);
        }

        $text = 'Nuevo Envase';

        return $this->renderForm('envase/new.html.twig', [
            'envase' => $envase,
            'form' => $form,
            'text_form' => $text,
        ]);
    }

    #[Route('/{id}', name: 'envase_show', methods: ['GET'])]
    public function show(Envase $envase): Response
    {
        return $this->render('envase/show.html.twig', [
            'envase' => $envase,
        ]);
    }

    #[Route('/{id}/edit', name: 'envase_edit', methods: ['GET','POST'])]
    public function edit(Request $request, Envase $envase): Response
    {
        $form = $this->createForm(EnvaseType::class, $envase);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('envase_index', [], Response::HTTP_SEE_OTHER);
        }

        $text = 'Editar Envase';

        return $this->renderForm('envase/edit.html.twig', [
            'envase' => $envase,
            'form' => $form,
            'text_form' => $text,
        ]);
    }

    #[Route('/{id}', name: 'envase_delete', methods: ['POST'])]
    public function delete(Request $request, Envase $envase): Response
    {
        if ($this->isCsrfTokenValid('delete'.$envase->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($envase);
            $entityManager->flush();
        }

        return $this->redirectToRoute('envase_index', [], Response::HTTP_SEE_OTHER);
    }
}
