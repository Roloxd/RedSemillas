<?php

namespace App\Controller;

use App\Entity\Donante;
use App\Form\DonanteType;
use App\Repository\DonanteRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/donante")
 */
class DonanteController extends AbstractController
{
    /**
     * @Route("/", name="donante_index", methods={"GET"})
     */
    public function index(DonanteRepository $donanteRepository): Response
    {
        return $this->render('donante/index.html.twig', [
            'donantes' => $donanteRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="donante_new", methods={"GET", "POST"})
     */
    public function new(Request $request): Response
    {
        $donante = new Donante();
        $form = $this->createForm(DonanteType::class, $donante);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($donante);
            $entityManager->flush();

            return $this->redirectToRoute('donante_index', [], Response::HTTP_SEE_OTHER);
        }

        $text_form = "Nuevo Donante/Recolector";

        return $this->renderForm('donante/new.html.twig', [
            'donante' => $donante,
            'form' => $form,
            'text_form' => $text_form,
        ]);
    }

    /**
     * @Route("/add", name="donante_add", methods={"POST"})
     */
    public function add(Request $request): Response
    {
        $donante = new Donante();
        $datos = $request->request->get('donante');

        $donante->setTipoDonante($datos['tipo_donante']);
        $donante->setInstcode($datos['instcode']);
        $donante->setProyecto($datos['proyecto']);
        $donante->setNumAccesionDonante($datos['num_accesion_donante']);
        $donante->setObservaciones($datos['observaciones']);

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($donante);
        $entityManager->flush();

        $idDonante = $donante->getId();

        $response = new Response();
        $response->setContent(json_encode([
            'idDonante' => $idDonante,
        ]));
        $response->headers->set('Content-Type', 'application/json');
        return $response; 
    }

    /**
     * @Route("/{id}", name="donante_show", methods={"GET"})
     */
    public function show(Donante $donante): Response
    {
        return $this->render('donante/show.html.twig', [
            'donante' => $donante,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="donante_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Donante $donante): Response
    {
        $form = $this->createForm(DonanteType::class, $donante);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('donante_index', [], Response::HTTP_SEE_OTHER);
        }

        $text_form = 'Editar Donante/Recolector';

        return $this->renderForm('donante/edit.html.twig', [
            'donante' => $donante,
            'form' => $form,
            'text_form' => $text_form,
        ]);
    }

    /**
     * @Route("/{id}", name="donante_delete", methods={"POST"})
     */
    public function delete(Request $request, Donante $donante): Response
    {
        if ($this->isCsrfTokenValid('delete'.$donante->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($donante);
            $entityManager->flush();
        }

        return $this->redirectToRoute('donante_index', [], Response::HTTP_SEE_OTHER);
    }
}
