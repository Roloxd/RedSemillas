<?php

namespace App\Controller;

use App\Entity\Persona;
use App\Form\Persona2Type;
use App\Repository\PersonaRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/persona")
 */
class PersonaController extends AbstractController
{
    /**
     * @Route("/", name="persona_index", methods={"GET"})
     */
    public function index(PersonaRepository $personaRepository): Response
    {
        return $this->render('persona/index.html.twig', [
            'personas' => $personaRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="persona_new", methods={"GET", "POST"})
     */
    public function new(Request $request): Response
    {
        $persona = new Persona();
        $form = $this->createForm(Persona2Type::class, $persona);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($persona);
            $entityManager->flush();

            return $this->redirectToRoute('persona_index', [], Response::HTTP_SEE_OTHER);
        }

        $text = 'Nueva Persona';

        return $this->renderForm('persona/new.html.twig', [
            'persona' => $persona,
            'form' => $form,
            'text_form' => $text,
        ]);
    }

    /**
     * @Route("/add", name="persona_add", methods={"POST"})
     */
    public function peticion(Request $request): Response
    {
        //if($request->isXmlHttpRequest()){

        $persona = new Persona();

        $dni = $request->request->get('dni');
        $nombre = $request->request->get('nombre');
        $apellidos = $request->request->get('apellidos');

        $persona->setNif($dni);
        $persona->setNombre($nombre);
        $persona->setApellidos($apellidos);

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($persona);
        $entityManager->flush();

        //}
        
        $id = $persona->getId();

        $response = new Response();
        $response->setContent(json_encode([
            'id' => $id,
            'nombre' => $nombre,
        ]));
        $response->headers->set('Content-Type', 'application/json');

        return $response;     
    }

    /**
     * @Route("/{id}", name="persona_show", methods={"GET"})
     */
    public function show(Persona $persona): Response
    {
        return $this->render('persona/show.html.twig', [
            'persona' => $persona,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="persona_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Persona $persona): Response
    {
        $form = $this->createForm(Persona2Type::class, $persona);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('persona_index', [], Response::HTTP_SEE_OTHER);
        }

        $text = 'Editar Persona';

        return $this->renderForm('persona/edit.html.twig', [
            'persona' => $persona,
            'form' => $form,
            'text_form' => $text,
        ]);
    }

    /**
     * @Route("/{id}", name="persona_delete", methods={"POST"})
     */
    public function delete(Request $request, Persona $persona): Response
    {
        if ($this->isCsrfTokenValid('delete'.$persona->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($persona);
            $entityManager->flush();
        }

        return $this->redirectToRoute('persona_index', [], Response::HTTP_SEE_OTHER);
    }
}
