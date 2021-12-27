<?php

namespace App\Controller;

use App\Entity\Uso;
use App\Form\UsoType;
use App\Repository\UsoRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/uso')]
/**
 * @Route("/admin/uso")
 */
class UsoController extends AbstractController
{
    /**
     * @Route("/", name="uso_index", methods={"GET"})
     */
    public function index(UsoRepository $usoRepository): Response
    {
        return $this->render('uso/index.html.twig', [
            'usos' => $usoRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="uso_new", methods={"GET", "POST"})
     */
    public function new(Request $request): Response
    {
        $uso = new Uso();
        $form = $this->createForm(UsoType::class, $uso);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($uso);
            $entityManager->flush();

            return $this->redirectToRoute('uso_index', [], Response::HTTP_SEE_OTHER);
        }

        $text = 'Nuevo Uso';

        return $this->renderForm('uso/new.html.twig', [
            'uso' => $uso,
            'form' => $form,
            'text_form' => $text,
        ]);
    }

    /**
     * @Route("/findAll", name="uso_findAll", methods={"POST"})
     */
    public function findAll(Request $request): Response
    {
        $usos = $this->getDoctrine()
            ->getRepository(Uso::class)
            ->findAll();

        $arrayUsos = [];
        foreach($usos as $uso){
            $arrayUsos[$uso->getUso()][$uso->getId()] = $uso->getTipo();
        }

        $response = new Response();
            $response->setContent(json_encode([
                'usos' => $arrayUsos,
            ]));
            $response->headers->set('Content-Type', 'application/json');

            return $response;
    }

    /**
     * @Route("/{id}", name="uso_show", methods={"GET"})
     */
    public function show(Uso $uso): Response
    {
        return $this->render('uso/show.html.twig', [
            'uso' => $uso,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="uso_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Uso $uso): Response
    {
        $form = $this->createForm(UsoType::class, $uso);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('uso_index', [], Response::HTTP_SEE_OTHER);
        }

        $text = 'Editar Uso';

        return $this->renderForm('uso/edit.html.twig', [
            'uso' => $uso,
            'form' => $form,
            'text_form' => $text,
        ]);
    }

    /**
     * @Route("/{id}", name="uso_delete", methods={"POST"})
     */
    public function delete(Request $request, Uso $uso): Response
    {
        if ($this->isCsrfTokenValid('delete'.$uso->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($uso);
            $entityManager->flush();
        }

        return $this->redirectToRoute('uso_index', [], Response::HTTP_SEE_OTHER);
    }
}
