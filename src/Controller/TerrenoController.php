<?php

namespace App\Controller;

use App\Entity\Entrada;
use App\Entity\Persona;
use App\Entity\Terreno;
use App\Form\Persona1Type;
use App\Form\TerrenoType;
use App\Repository\TerrenoRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/terreno")
 */
class TerrenoController extends AbstractController
{
    /**
     * @Route("/", name="terreno_index", methods={"GET"})
     */
    public function index(TerrenoRepository $terrenoRepository): Response
    {
        return $this->render('terreno/index.html.twig', [
            'terrenos' => $terrenoRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="terreno_new", methods={"GET", "POST"})
     */
    public function new(Request $request): Response
    {
        $terreno = new Terreno();
        $form = $this->createForm(TerrenoType::class, $terreno);
        $form->handleRequest($request);

        $persona = new Persona();
        $form2 = $this->createForm(Persona1Type::class, $persona, [
            'attr' => ['class' => 'formPersona' ]
        ]);
        $form2->handleRequest($request);

        if ($form2->isSubmitted() && $form2->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($persona);
            $entityManager->flush();
        }

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($terreno);
            $entityManager->flush();

            return $this->redirectToRoute('terreno_index', [], Response::HTTP_SEE_OTHER);
        }

        $text = 'Nuevo Terreno';

        return $this->renderForm('terreno/new.html.twig', [
            'terreno' => $terreno,
            'persona' => $persona,
            'form' => $form,
            'form2' => $form2,
            'text_form' => $text,
        ]);
    }

    /**
     * @Route("/getTerrenosPersona", name="terreno_TerrenosPersona", methods={"POST"})
     */
    public function getTerrenosPersona(Request $request): Response
    {
        $dni = $request->request->get('dni');
        $idEntrada = $request->request->get('idEntrada');
        
        $idPersona = $this->getDoctrine()
                ->getRepository(Persona::class)
                ->findId($dni);

        if(!empty($idPersona)){
            $terrenos = $this->getDoctrine()
                ->getRepository(Terreno::class)
                ->findTerrenosPersona($idPersona[0]['id']);

            if(empty($terrenos)){
                $terrenos = "";
            }
        } else {
            $terrenos = "";
        }

        if(!empty($idEntrada)){
            $entrada = $this->getDoctrine()
                ->getRepository(Entrada::class)
                ->find($idEntrada);

            foreach($entrada->getIdTerreno()->getValues() as $terreno){
                $arrayIdTerrenos[] = $terreno->getId();
            }
        } else {
            $arrayIdTerrenos = "";
        }

        $response = new Response();
        $response->setContent(json_encode([
            'terrenos' => $terrenos,
            'arrayIdTerrenos' => $arrayIdTerrenos,
        ]));
        $response->headers->set('Content-Type', 'application/json');

        return $response;  
    }

    /**
     * @Route("/{id}", name="terreno_show", methods={"GET"})
     */
    public function show(Terreno $terreno): Response
    {
        return $this->render('terreno/show.html.twig', [
            'terreno' => $terreno,
        ]);
    }

    /**
     * @Route("/{id}/mostrar", name="terreno_mostrar", methods={"GET"})
     */
    public function mostrar(Request $request): Response
    {
        $id = $request->attributes->get('id');

        $terrenos[] = $this->getDoctrine()
            ->getRepository(Terreno::class)
            ->find($id);

        return $this->render('terreno/index.html.twig', [
            'terrenos' => $terrenos,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="terreno_edit", methods={"GET", "POST"})
     */
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
    
    /**
     * @Route("/{id}", name="terreno_delete", methods={"POST"})
     */
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
