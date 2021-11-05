<?php

namespace App\Controller;

use App\Entity\Imagen;
use App\Entity\ImagenSeleccionada;
use App\Entity\Variedad;
use App\Form\ImagenSeleccionadaType;
use App\Form\ImagenType;
use App\Form\Variedad1Type;
use App\Repository\VariedadRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/variedades')]
class VariedadController extends AbstractController
{
    #[Route('/', name: 'variedad_index', methods: ['GET'])]
    public function index(VariedadRepository $variedadRepository): Response
    {
        return $this->render('variedad/index.html.twig', [
            'variedades' => $variedadRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'variedad_new', methods: ['GET','POST'])]
    public function new(Request $request): Response
    {
        $variedad = new Variedad();
        $form = $this->createForm(Variedad1Type::class, $variedad, [
            'attr' => ['class' => 'formVariedad' ]
        ]);
        $form->handleRequest($request);

        $imagen = new Imagen();
        $form2 = $this->createForm(ImagenType::class, $imagen, [
            'attr' => ['class' => 'formImagen' ]
        ]);
        $form2->handleRequest($request);

        $imagenSelect = new ImagenSeleccionada();
        $form3 = $this->createForm(ImagenSeleccionadaType::class, $imagenSelect, [
            'attr' => ['class' => 'formImagenSelect' ]
        ]);
        $form3->handleRequest($request);


        if ($form->isSubmitted() && $form->isValid()) {
            // $entityManager = $this->getDoctrine()->getManager();
            // $entityManager->persist($variedad);
            // $entityManager->flush();

            // return $this->redirectToRoute('variedad_index', [], Response::HTTP_SEE_OTHER);
        }

        $text = 'Nueva Variedad';

        return $this->renderForm('variedad/new.html.twig', [
            'variedad' => $variedad,
            'imagen' => $imagen,
            'imagenSelect' => $imagenSelect,
            'form' => $form,
            'form2' => $form2,
            'form3' => $form3,
            'text_form' => $text,
        ]);
    }

    #[Route('/add', name: 'variedad_add', methods: ['POST'])]
    public function peticion(Request $request): Response
    {
        //if($request->isXmlHttpRequest()){

        $variedad = new Variedad();

        $nombreComun = $request->request->get('nombreComun');
        $tipoSiembra = $request->request->get('tipoSiembra');
        $polinizacion = $request->request->get('polinizacion');
        $observaciones = $request->request->get('observaciones');

        $variedad->setNombreComun($nombreComun);
        $variedad->setTipoSiembra($tipoSiembra);
        $variedad->setPolinizacion($polinizacion);
        $variedad->setObservaciones($observaciones);


        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($variedad);
        $entityManager->flush();

        //}
        
        $idVariedad = $variedad->getId();

        $response = new Response();
        $response->setContent(json_encode([
            'idVariedad' => $idVariedad,
        ]));
        $response->headers->set('Content-Type', 'application/json');

        return $response;     
    }

    #[Route('/{id}', name: 'variedad_show', methods: ['GET'])]
    public function show(Variedad $variedad): Response
    {
        return $this->render('variedad/show.html.twig', [
            'variedad' => $variedad,
        ]);
    }

    #[Route('/{id}/edit', name: 'variedad_edit', methods: ['GET','POST'])]
    public function edit(Request $request, Variedad $variedad): Response
    {
        $form = $this->createForm(Variedad1Type::class, $variedad);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('variedad_index', [], Response::HTTP_SEE_OTHER);
        }

        $text = 'Editar Variedad';

        return $this->renderForm('variedad/edit.html.twig', [
            'variedad' => $variedad,
            'form' => $form,
            'text_form' => $text,
        ]);
    }

    #[Route('/{id}', name: 'variedad_delete', methods: ['POST'])]
    public function delete(Request $request, Variedad $variedad): Response
    {
        if ($this->isCsrfTokenValid('delete'.$variedad->getIdVariedad(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($variedad);
            $entityManager->flush();
        }

        return $this->redirectToRoute('variedad_index', [], Response::HTTP_SEE_OTHER);
    }
}
