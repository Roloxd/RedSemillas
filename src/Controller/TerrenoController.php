<?php

namespace App\Controller;

use App\Entity\Terreno;
use App\Form\TerrenoType;
use App\Repository\TerrenoRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/terreno')]
class TerrenoController extends AbstractController
{
    #[Route('/', name: 'terreno_index', methods: ['GET'])]
    public function index(TerrenoRepository $terrenoRepository): Response
    {
        return $this->render('terreno/index.html.twig', [
            'terrenos' => $terrenoRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'terreno_new', methods: ['GET','POST'])]
    public function new(Request $request): Response
    {
        $terreno = new Terreno();
        $form = $this->createForm(TerrenoType::class, $terreno);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($terreno);
            $entityManager->flush();

            return $this->redirectToRoute('terreno_index', [], Response::HTTP_SEE_OTHER);
        }

        $text = 'Nuevo Terreno';

        return $this->renderForm('terreno/new.html.twig', [
            'terreno' => $terreno,
            'form' => $form,
            'text_form' => $text,
        ]);
    }

    #[Route('/{id}', name: 'terreno_show', methods: ['GET'])]
    public function show(Terreno $terreno): Response
    {
        return $this->render('terreno/show.html.twig', [
            'terreno' => $terreno,
        ]);
    }

    #[Route('/{id}/edit', name: 'terreno_edit', methods: ['GET','POST'])]
    public function edit(Request $request, Terreno $terreno): Response
    {
        $form = $this->createForm(TerrenoType::class, $terreno);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('terreno_index', [], Response::HTTP_SEE_OTHER);
        }

        $text = 'Editar Terreno';

        return $this->renderForm('terreno/edit.html.twig', [
            'terreno' => $terreno,
            'form' => $form,
            'text_form' => $text,
        ]);
    }

    #[Route('/{id}', name: 'terreno_delete', methods: ['POST'])]
    public function delete(Request $request, Terreno $terreno): Response
    {
        if ($this->isCsrfTokenValid('delete'.$terreno->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($terreno);
            $entityManager->flush();
        }

        return $this->redirectToRoute('terreno_index', [], Response::HTTP_SEE_OTHER);
    }
}
