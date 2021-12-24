<?php

namespace App\Controller;

use App\Entity\Imagen;
use App\Entity\ImagenSeleccionada;
use App\Entity\Variedad;
use App\Form\ImagenSeleccionadaType;
use App\Repository\ImagenSeleccionadaRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/img/seleccion")
 */
class ImagenSeleccionadaController extends AbstractController
{
    /**
     * @Route("/", name="imagen_seleccionada_index", methods={"GET"})
     */
    public function index(ImagenSeleccionadaRepository $imagenSeleccionadaRepository): Response
    {
        return $this->render('imagen_seleccionada/index.html.twig', [
            'imagen_seleccionadas' => $imagenSeleccionadaRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="imagen_seleccionada_new", methods={"GET", "POST"})
     */
    public function new(Request $request): Response
    {
        $ImagenSeleccionada = new ImagenSeleccionada();
        $form = $this->createForm(ImagenSeleccionadaType::class, $ImagenSeleccionada);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($ImagenSeleccionada);
            $entityManager->flush();

            return $this->redirectToRoute('imagen_seleccionada_index', [], Response::HTTP_SEE_OTHER);
        }

        $text = 'Nueva Selección de Imagen';

        return $this->renderForm('imagen_seleccionada/new.html.twig', [
            'imagen_seleccionada' => $ImagenSeleccionada,
            'form' => $form,
            'text_form' => $text,
        ]);
    }

    /**
     * @Route("/add", name="imagen_seleccionada_add", methods={"POST"})
     */
    public function peticion(Request $request): Response
    {
        //if($request->isXmlHttpRequest()){

        $ImagenSeleccionada = new ImagenSeleccionada();

        $tipo = $request->request->get('tipo');
        $idVariedad = $request->request->get('idVariedad');
        $idImagen = $request->request->get('idImagen');

        $Variedad = $this->getDoctrine()
            ->getRepository(Variedad::class)
            ->find($idVariedad);

        $Imagen = $this->getDoctrine()
        ->getRepository(Imagen::class)
        ->find($idImagen);
        
        $ImagenSeleccionada->setTipo($tipo);
        $ImagenSeleccionada->setVariedad($Variedad);
        $ImagenSeleccionada->setImagen($Imagen);
        
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($ImagenSeleccionada);
        $entityManager->flush();

        //}
        
        $response = new Response();
        $response->setContent(json_encode([
            'Content',
            Response::HTTP_OK,
            ['content-type' => 'text/html']
        ]));

        return $response;     
    }

    /**
     * @Route("/relation", name="imagen_seleccionada_relation", methods={"POST"})
     */
    public function relation(Request $request): Response
    {
        //if($request->isXmlHttpRequest()){

        $tipo = $request->request->get('tipo');
        $idVariedad = $request->request->get('idVariedad');
        $idImagen = $request->request->get('idImagen');

        dump($idImagen);

        $Variedad = $this->getDoctrine()
            ->getRepository(Variedad::class)
            ->find($idVariedad);

        $Imagen = $this->getDoctrine()
            ->getRepository(Imagen::class)
            ->find($idImagen);

        if($Variedad->getImagenSeleccionada() == null){
            $ImagenSeleccionada = new ImagenSeleccionada;

            $ImagenSeleccionada->setTipo($tipo);
            $ImagenSeleccionada->setVariedad($Variedad);
            $ImagenSeleccionada->addImagen($Imagen);

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($ImagenSeleccionada);
            $entityManager->flush();
        } else {

        }

        //dump($Variedad->getImagenSeleccionada());

        //}
        
        $response = new Response();
        $response->setContent(json_encode([
            'Content',
            Response::HTTP_OK,
            ['content-type' => 'text/html']
        ]));

        return $response;     
    }

    /**
     * @Route("/{id}", name="imagen_seleccionada_show", methods={"GET"})
     */
    public function show(ImagenSeleccionada $imagenSeleccionada): Response
    {
        return $this->render('imagen_seleccionada/show.html.twig', [
            'imagen_seleccionada' => $imagenSeleccionada,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="imagen_seleccionada_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, ImagenSeleccionada $imagenSeleccionada): Response
    {
        $form = $this->createForm(ImagenSeleccionadaType::class, $imagenSeleccionada);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('imagen_seleccionada_index', [], Response::HTTP_SEE_OTHER);
        }

        $text = 'Editar Selección Imagen';

        return $this->renderForm('imagen_seleccionada/edit.html.twig', [
            'imagen_seleccionada' => $imagenSeleccionada,
            'form' => $form,
            'text_form' => $text,
        ]);
    }

    /**
     * @Route("/{id}", name="imagen_seleccionada_delete", methods={"POST"})
     */
    public function delete(Request $request, ImagenSeleccionada $imagenSeleccionada): Response
    {
        if ($this->isCsrfTokenValid('delete'.$imagenSeleccionada->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($imagenSeleccionada);
            $entityManager->flush();
        }

        return $this->redirectToRoute('imagen_seleccionada_index', [], Response::HTTP_SEE_OTHER);
    }
}
