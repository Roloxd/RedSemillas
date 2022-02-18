<?php

namespace App\Controller;

use App\Entity\Instituciones;
use App\Form\InstitucionesType;
use App\Repository\InstitucionesRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/instituciones")
 */
class InstitucionesController extends AbstractController
{
    /**
     * @Route("/", name="instituciones_index", methods={"GET"})
     */
    public function index(InstitucionesRepository $institucionesRepository): Response
    {
        return $this->render('instituciones/index.html.twig', [
            'instituciones' => $institucionesRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="instituciones_new", methods={"GET", "POST"})
     */
    public function new(Request $request): Response
    {
        $institucione = new Instituciones();
        $form = $this->createForm(InstitucionesType::class, $institucione);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($institucione);
            $entityManager->flush();

            return $this->redirectToRoute('instituciones_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('instituciones/new.html.twig', [
            'institucione' => $institucione,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{INSTCODE}", name="instituciones_show", methods={"GET"})
     */
    public function show(Instituciones $institucione): Response
    {
        return $this->render('instituciones/show.html.twig', [
            'institucione' => $institucione,
        ]);
    }

    /**
     * @Route("/{INSTCODE}/edit", name="instituciones_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Instituciones $institucione): Response
    {
        $form = $this->createForm(InstitucionesType::class, $institucione);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('instituciones_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('instituciones/edit.html.twig', [
            'institucione' => $institucione,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{INSTCODE}", name="instituciones_delete", methods={"POST"})
     */
    public function delete(Request $request, Instituciones $institucione): Response
    {
        if ($this->isCsrfTokenValid('delete'.$institucione->getINSTCODE(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($institucione);
            $entityManager->flush();
        }

        return $this->redirectToRoute('instituciones_index', [], Response::HTTP_SEE_OTHER);
    }
}
