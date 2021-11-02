<?php

namespace App\Controller;

use App\Entity\CicloYSiembra;
use App\Form\CicloYSiembraType;
use App\Repository\CicloYSiembraRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/ciclo/y/siembra')]
class CicloYSiembraController extends AbstractController
{
    #[Route('/', name: 'ciclo_y_siembra_index', methods: ['GET'])]
    public function index(CicloYSiembraRepository $cicloYSiembraRepository): Response
    {
        return $this->render('ciclo_y_siembra/index.html.twig', [
            'ciclo_y_siembras' => $cicloYSiembraRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'ciclo_y_siembra_new', methods: ['GET','POST'])]
    public function new(Request $request): Response
    {
        $cicloYSiembra = new CicloYSiembra();
        $form = $this->createForm(CicloYSiembraType::class, $cicloYSiembra);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($cicloYSiembra);
            $entityManager->flush();

            return $this->redirectToRoute('ciclo_y_siembra_index', [], Response::HTTP_SEE_OTHER);
        }

        $text_form = 'Nuevo Ciclo y Siembra';

        return $this->renderForm('ciclo_y_siembra/new.html.twig', [
            'ciclo_y_siembra' => $cicloYSiembra,
            'form' => $form,
            'text_form' => $text_form,
        ]);
    }

    #[Route('/{id}', name: 'ciclo_y_siembra_show', methods: ['GET'])]
    public function show(CicloYSiembra $cicloYSiembra): Response
    {
        return $this->render('ciclo_y_siembra/show.html.twig', [
            'ciclo_y_siembra' => $cicloYSiembra,
        ]);
    }

    #[Route('/{id}/edit', name: 'ciclo_y_siembra_edit', methods: ['GET','POST'])]
    public function edit(Request $request, CicloYSiembra $cicloYSiembra): Response
    {
        $form = $this->createForm(CicloYSiembraType::class, $cicloYSiembra);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('ciclo_y_siembra_index', [], Response::HTTP_SEE_OTHER);
        }

        $text_form = 'Editar Ciclo y Siembra';

        return $this->renderForm('ciclo_y_siembra/edit.html.twig', [
            'ciclo_y_siembra' => $cicloYSiembra,
            'form' => $form,
            'text_form' => $text_form,
        ]);
    }

    #[Route('/{id}', name: 'ciclo_y_siembra_delete', methods: ['POST'])]
    public function delete(Request $request, CicloYSiembra $cicloYSiembra): Response
    {
        if ($this->isCsrfTokenValid('delete'.$cicloYSiembra->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($cicloYSiembra);
            $entityManager->flush();
        }

        return $this->redirectToRoute('ciclo_y_siembra_index', [], Response::HTTP_SEE_OTHER);
    }
}
