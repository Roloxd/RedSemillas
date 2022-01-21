<?php

namespace App\Controller;

use App\Entity\Pago;
use App\Entity\Persona;
use App\Form\PagoType;
use App\Repository\PagoRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/pago")
 */
class PagoController extends AbstractController
{
    /**
     * @Route("/", name="pago_index", methods={"GET"})
     */
    public function index(PagoRepository $pagoRepository): Response
    {
        dump($pagoRepository->findAll());
        return $this->render('pago/index.html.twig', [
            'pagos' => $pagoRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="pago_new", methods={"GET", "POST"})
     */
    public function new(Request $request): Response
    {
        $pago = new Pago();
        $form = $this->createForm(PagoType::class, $pago);
        $form->handleRequest($request);

        $text_form = "Nuevo Pago";

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($pago);
            $entityManager->flush();

            return $this->redirectToRoute('pago_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('pago/new.html.twig', [
            'pago' => $pago,
            'form' => $form,
            'text_form' => $text_form,
        ]);
    }

    /**
     * @Route("/{id}", name="pago_show", methods={"GET"})
     */
    public function show(Pago $pago): Response
    {
        return $this->render('pago/show.html.twig', [
            'pago' => $pago,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="pago_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Pago $pago): Response
    {
        $form = $this->createForm(PagoType::class, $pago);
        $form->handleRequest($request);

        $text_form = "Editar Pago";

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('pago_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('pago/edit.html.twig', [
            'pago' => $pago,
            'form' => $form,
            'text_form' => $text_form,
        ]);
    }

    /**
     * @Route("/{id}/ver", name="pago_ver", methods={"GET"})
     */
    public function ver(Request $request): Response
    {
        $id = $request->attributes->get('id');

        $persona = $this->getDoctrine()
            ->getRepository(Persona::class)
            ->find($id);

        $pagos = $persona->getPagos()->getValues();

        return $this->render('pago/index.html.twig', [
            'pagos' => $pagos,
        ]);
    }

    /**
     * @Route("/{id}", name="pago_delete", methods={"POST"})
     */
    public function delete(Request $request, Pago $pago): Response
    {
        if ($this->isCsrfTokenValid('delete'.$pago->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($pago);
            $entityManager->flush();
        }

        return $this->redirectToRoute('pago_index', [], Response::HTTP_SEE_OTHER);
    }
}
