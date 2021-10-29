<?php

namespace App\Controller;

use App\Entity\Imagen;
use App\Entity\ImagenSeleccionada;
use App\Form\ImagenSeleccionadaType;
use App\Form\ImagenType;
use App\Repository\ImagenRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/imagen')]
class ImagenController extends AbstractController
{
    #[Route('/', name: 'imagen_index', methods: ['GET'])]
    public function index(ImagenRepository $imagenRepository): Response
    {
        return $this->render('imagen/index.html.twig', [
            'imagens' => $imagenRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'imagen_new', methods: ['GET','POST'])]
    public function new(Request $request): Response
    {
        $imagen = new Imagen();
        $form = $this->createForm(ImagenType::class, $imagen);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($imagen);
            $entityManager->flush();

            return $this->redirectToRoute('imagen_index', [], Response::HTTP_SEE_OTHER);
        }

        $text = 'Nueva Imagen';

        return $this->renderForm('imagen/new.html.twig', [
            'imagen' => $imagen,
            'form' => $form,
            'text_form' => $text,
        ]);
    }

    #[Route('/{id}', name: 'imagen_show', methods: ['GET'])]
    public function show(Imagen $imagen): Response
    {
        return $this->render('imagen/show.html.twig', [
            'imagen' => $imagen,
        ]);
    }

    #[Route('/{id}/edit', name: 'imagen_edit', methods: ['GET','POST'])]
    public function edit(Request $request, Imagen $imagen): Response
    {
        $form = $this->createForm(ImagenType::class, $imagen);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('imagen_index', [], Response::HTTP_SEE_OTHER);
        }

        $text = 'Editar Imagen';

        return $this->renderForm('imagen/edit.html.twig', [
            'imagen' => $imagen,
            'form' => $form,
            'text_form' => $text,
        ]);
    }

    #[Route('/{id}', name: 'imagen_delete', methods: ['POST'])]
    public function delete(Request $request, Imagen $imagen): Response
    {
        if ($this->isCsrfTokenValid('delete'.$imagen->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($imagen);
            $entityManager->flush();
        }

        return $this->redirectToRoute('imagen_index', [], Response::HTTP_SEE_OTHER);
    }
}
