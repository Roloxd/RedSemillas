<?php

namespace App\Controller;



use Intervention\Image\ImageManagerStatic as Image;



use App\Entity\Imagen;
use App\Entity\ImagenSeleccionada;
use App\Entity\Variedad;
use App\Form\ImagenSeleccionada2Type;
use App\Form\ImagenSeleccionadaType;
use App\Form\ImagenType;
use App\Repository\ImagenRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
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
    public function new(Request $request, string $imgDir): Response
    {
        $imagen = new Imagen();
        $form = $this->createForm(ImagenType::class, $imagen);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();

            if($img = $form['url']->getData()){
                $filename = md5(uniqid()) . '.' . $img->guessExtension();
                // $img_reescalada = Image::make($img)->fit(800,600);
                try {
                    $img->move($imgDir, $filename);
                } catch (FileException $e) {
                    
                }

                $img->save($imgDir . $filename);
                $imagen->setUrl($filename);
            }

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

    #[Route('/add', name: 'imagen_add', methods: ['POST'])]
    public function peticion(Request $request, string $imgDir): Response
    {
        //if($request->isXmlHttpRequest()){

        $Imagen = new Imagen();

        $datos = $request->request->get('imagen');
        $titulo = $datos['titulo'];
        $credito = $datos['credito'];
        $idVariedad = $datos['idVariedad'];

        $file = $request->files->get('imagen');
        
        $filename = md5(uniqid()).'.'.$file['url']->guessExtension();
        //$img_reescalada = Image::make($img)->fit(800,600);
        try {
            $file['url']->move($imgDir, $filename);
        } catch (FileException $e) {
            
        }

        $Imagen->setTitulo($titulo);
        $Imagen->setCredito($credito);
        $Imagen->setUrl($filename);

        $Variedad = $this->getDoctrine()
            ->getRepository(Variedad::class)
            ->find($idVariedad);

        if($Variedad->getImagenSeleccionada() === null){
            $neverRelation = true;
        } else {
            $neverRelation = false;

            $idImagenSelect = $Variedad->getImagenSeleccionada()->getId();
            
            $ImagenSeleccionada = $this->getDoctrine()
            ->getRepository(ImagenSeleccionada::class)
            ->find($idImagenSelect);

            $Imagen->addImagenSeleccionada($ImagenSeleccionada);
        }

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($Imagen);
        $entityManager->flush();

        if($neverRelation){
            $idImagen = $Imagen->getId();
        } else {
            $idImagen = '';
        }
        

        //}
    
        $response = new Response();
        $response->setContent(json_encode([
            'idImagen' => $idImagen,
            'neverRelation' => $neverRelation,
        ]));
        $response->headers->set('Content-Type', 'application/json');

        return $response;     
    }

    #[Route('/update', name: 'imagen_update', methods: ['POST'])]
    public function update(Request $request, string $imgDir): Response
    {
        //if($request->isXmlHttpRequest()){
        $Imagen = new Imagen();

        $datos = $request->request->get('imagen');
        $titulo = $datos['titulo'];
        $credito = $datos['credito'];
        $idVariedad = $datos['idVariedad'];
        

        $file = $request->files->get('imagen');
        
        $filename = md5(uniqid()).'.'.$file['url']->guessExtension();
        //$img_reescalada = Image::make($img)->fit(800,600);
        try {
            $file['url']->move($imgDir, $filename);
        } catch (FileException $e) {
            
        }

        $Variedad = $this->getDoctrine()
            ->getRepository(Variedad::class)
            ->find($idVariedad);

        $idImagenSelect = $Variedad->getImagenSeleccionada()->getId();

        $ImagenSelect = $this->getDoctrine()
        ->getRepository(ImagenSeleccionada::class)
        ->find($idImagenSelect);

        $Imagen->setTitulo($titulo);
        $Imagen->setCredito($credito);
        $Imagen->setUrl($filename);
        $Imagen->addImagenSeleccionada($ImagenSelect);

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($Imagen);
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

    #[Route('/{id}', name: 'imagen_show', methods: ['GET'])]
    public function show(Imagen $imagen): Response
    {
        return $this->render('imagen/show.html.twig', [
            'imagen' => $imagen,
        ]);
    }

    #[Route('/{id}/edit', name: 'imagen_edit', methods: ['GET','POST'])]
    public function edit(Request $request, Imagen $imagen, string $imgDir): Response
    {
        

        $form = $this->createForm(ImagenType::class, $imagen);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();

            if($img = $form['url']->getData()){
                $filename = md5(uniqid()).'.'.$img->guessExtension();

                try {
                    unlink($imgDir . $imagen->getUrl());
                    // $img_reescalada = Image::make($img)->fit(800,600);
                    $img->move($imgDir . $filename);
                } catch (FileException $e) {
                    
                }

                $imagen->setUrl($filename);
            }

            $entityManager->flush();

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
    public function delete(Request $request, Imagen $imagen, string $imgDir): Response
    {
        if ($this->isCsrfTokenValid('delete'.$imagen->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();

            unlink($imgDir . $imagen->getUrl());

            $entityManager->remove($imagen);
            $entityManager->flush();
        }

        return $this->redirectToRoute('imagen_index', [], Response::HTTP_SEE_OTHER);
    }
}
