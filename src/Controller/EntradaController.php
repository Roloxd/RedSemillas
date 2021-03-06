<?php

namespace App\Controller;

use App\Entity\Entrada;
use App\Entity\Envase;
use App\Entity\Persona;
use App\Entity\Terreno;
use App\Form\Entrada1Type;
use App\Repository\EntradaRepository;
use DateTime;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;

use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpKernel\KernelInterface;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Runtime\Runner\Symfony\ResponseRunner;

/**
 * @Route("/admin/entrada")
 */
class EntradaController extends AbstractController
{
    /**
     * @Route("/", name="entrada_index", methods={"GET"})
     */
    public function index(EntradaRepository $entradaRepository): Response
    {
        return $this->render('entrada/index.html.twig', [
            'entradas' => $entradaRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="entrada_new", methods={"GET", "POST"})
     */
    public function new(Request $request, string $imgDir): Response
    {
        $entrada = new Entrada();
        $form = $this->createForm(Entrada1Type::class, $entrada, [
            'attr' => ['class' => 'formEntrada' ]
        ]);
        $form->handleRequest($request);



        if ($form->isSubmitted()) {

            if($file = $form['my_file']->getData()){
                $filename = md5(uniqid()) . '.' . $file->guessExtension();
                // try {
                    $file->move($imgDir, $filename);
                // } catch (FileException $e) {
                    
                // }

                // $file->save($imgDir . $filename);
                $entrada->setUrl($filename);
            }
            // $file = $form->get('image')->getData();

            // $file = $request->files->get('post');
            // $uploads_directory = $this -> getParameter('uploads_directory');

            // $filename = md5(uniqid()) . '.' . $file->guessExtension();

            // $file -> move(
            //     $uploads_directory,
            //     $filename
            // );

            $datos = $request->request->get('entrada1');
            
            // Codigo Entrada
            $this->codigoEntrada($entrada, $datos);

            // A??ade la persona
            if(!empty($datos['persona'])) {
                $persona = $this->getDoctrine()
                    ->getRepository(Persona::class)
                    ->find( intval($datos['persona']) );

                $entrada->setPersona($persona);
            }

            // A??ade los terrenos
            if(!empty($datos['terrenos'])){
                foreach ($datos['terrenos'] as $terrenoId){
                    $terreno = $this->getDoctrine()
                        ->getRepository(Terreno::class)
                        ->find( intval($terrenoId) );

                    $entrada->addIdTerreno($terreno);
                }
            }
            
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($entrada);
            $entityManager->flush();

            return $this->redirectToRoute('envase_new', [
                'entrada' => $entrada->getId(),
            ], Response::HTTP_SEE_OTHER);

            // return $this->redirectToRoute('entrada_index', [], Response::HTTP_SEE_OTHER);
        }

        $text = 'Nueva Entrada';
        
        return $this->renderForm('entrada/new.html.twig', [
            'entrada' => $entrada,
            'form' => $form,
            'text_form' => $text,
        ]);
    }

    /**
     * @Route("/getPersona", name="entrada_getpersona", methods={"POST"})
     */
    public function getPersona(Request $request): Response
    {
        $idEntrada = $request->request->get('idEntrada');
        
        $entrada = $this->getDoctrine()
            ->getRepository(Entrada::class)
            ->find($idEntrada);

        $dni = null;
        foreach($entrada->getIdTerreno()->getValues() as $terreno){
            $dni = $terreno->getIdPersona()->getNif();
        }

        $response = new Response();
        $response->setContent(json_encode([
            'dni' => $dni,
        ]));
        $response->headers->set('Content-Type', 'application/json');

        return $response;  
    }

    /**
     * @Route("/findAll", name="entrada_findAll", methods={"POST"})
     */
    public function findAll(): Response
    {
        $entradas = $this->getDoctrine()
                ->getRepository(Entrada::class)
                ->findAll();

        if($entradas){
            foreach($entradas as $entrada){
                $ArrayEntrada[] = $entrada->getId();
            }
        } else {
            $ArrayEntrada = '';
        }
        

        $response = new Response();
        $response->setContent(json_encode([
            'entradas' => $ArrayEntrada,
        ]));
        $response->headers->set('Content-Type', 'application/json');

        return $response;     
    }

    /**
     * @Route("/{id}", name="entrada_show", methods={"GET"})
     */
    public function show(Entrada $entrada): Response
    {
        return $this->render('entrada/show.html.twig', [
            'entrada' => $entrada,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="entrada_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Entrada $entrada, string $imgDir): Response
    {
        $form = $this->createForm(Entrada1Type::class, $entrada, [
            'attr' => ['class' => 'formEditEntrada' ]
        ]);
        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            
            $datos = $request->request->get('entrada1');
            $terrenos = $entrada->getTerrenos()->getValues();
            // Codigo Entrada
            $this->codigoEntrada($entrada, $datos);

            if($file = $form['my_file']->getData()){
                // $filename = md5(uniqid()) . '.' . $file->guessExtension();
                    $filename = $entrada->getUrl();
                    // $filesystem = new Filesystem();
                    // $path="%kernel.project_dir%/public/uploads/img/9af730241d24289f7142f2710810fe81.pdf";
                    // $filesystem->remove($path);
                // try {
                    $file->move($imgDir, $filename);
                // } catch (FileException $e) {
                    
                // }

                // $file->save($imgDir . $filename);
                // $entrada->setUrl($filename);
            }

            if(isset($datos['persona']) && !empty($datos['persona'])) {
                $persona = intval($datos['persona']);
                $entradaPersona = $entrada->getPersona();
                
                // Comproba si es una Persona asignada es distinta a la Persona relacionada
                if( empty($entradaPersona) || $persona != $entradaPersona->getId()) {
                    // A??ade la persona
                    $persona = $this->getDoctrine()
                        ->getRepository(Persona::class)
                        ->find( intval($datos['persona']) );

                    $entrada->setPersona($persona);

                    // Eliminamos los terrenos asociados
                    if(!empty($terrenos)) {
                        foreach($terrenos as $terreno) {
                            $entrada->removeIdTerreno($terreno);
                        }
                    }
                }
            }

            // Obtener Terrenos relacionados con la Entrada
            $idTerreno = [];

            if(isset($datos['terrenos']) && !empty($datos['terrenos'])) {
                $fromTerrenos = $datos['terrenos'];

                foreach($terrenos as $terreno) {
                    $idTerrenos[] = strval( $terreno->getId() );

                    // Elimina el terreno desmarcado
                    if( !in_array( strval( $terreno->getId() ), $fromTerrenos) ){
                        $entrada->removeIdTerreno($terreno);
                    }
                }

                foreach($fromTerrenos as $fromTerreno) {

                    // Comprueba que no exista relacion
                    if( empty($idTerrenos) || !in_array($fromTerreno, $idTerrenos) ) {

                        // A??ade el terreno
                        $terreno = $this->getDoctrine()
                            ->getRepository(Terreno::class)
                            ->find( intval($fromTerreno) );

                        $entrada->addIdTerreno($terreno);
                    }
                }
            } else {
                // Eliminamos los terrenos asociados
                foreach($terrenos as $terreno) {
                    $entrada->removeIdTerreno($terreno);
                }
            }

            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('entrada_index', [], Response::HTTP_SEE_OTHER);
        }

        $text = 'Editar Entrada';

        return $this->renderForm('entrada/edit.html.twig', [
            'entrada' => $entrada,
            'form' => $form,
            'text_form' => $text,
        ]);
    }

    public function codigoEntrada(?Entrada $entrada, ?Array $datos): void
    {
        if( isset($datos['codigoEntrada']) && !empty($datos['codigoEntrada']) ) {
            $length = strlen( (string) $datos['codigoEntrada'] );
            $ceros = "";
            if($length < 5) {
                for ($i = 0; $i < (5-$length); $i++) {
                    $ceros .= "0";
                }
            }
            $arg = "ENT-" . $ceros . $datos['codigoEntrada'];
            $entrada->setCodigoEntrada($arg);
        }
    }

    /**
     * @Route("/{id}/ver", name="entrada_ver", methods={"GET"})
     */
    public function ver(Request $request): Response
    {
        $id = $request->attributes->get('id');

        $envase = $this->getDoctrine()
            ->getRepository(Envase::class)
            ->find($id);

        if(!empty($envase->getEntrada())) {
            $entradas[] = $envase->getEntrada();
        } else {
            $entradas = [];
        }

        return $this->render('entrada/index.html.twig', [
            'entradas' => $entradas,
        ]);
    }

    /**
     * @Route("/{id}", name="entrada_delete", methods={"POST"})
     */
    public function delete(Request $request, Entrada $entrada): Response
    {
        if ($this->isCsrfTokenValid('delete'.$entrada->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($entrada);
            $entityManager->flush();
        }

        return $this->redirectToRoute('entrada_index', [], Response::HTTP_SEE_OTHER);
    }

    /**
     * @Route("/{id}/mostrar", name="entrada_mostrar", methods={"GET"})
     */
    public function mostrar(Request $request): Response
    {
        $id = $request->attributes->get('id');

        $entradas[] = $this->getDoctrine()
            ->getRepository(Entrada::class)
            ->find($id);

        return $this->render('entrada/index.html.twig', [
            'entradas' => $entradas,
        ]);
    }
    /**
    * @Route(name="entrada_descargar",methods={ "GET"})
    */

    public function download(Entrada $entrada)
    {
        // $filename = $entrada -> getUrl();

        // return $this->file($this->kernel->getProjectDir()."/public/uploads/img/64490c66abf6aaa36b25860b3015feaf.pdf");
        
        // return $this->file('/public/uploads/img/27f01d553b59accac0347761f488d265.webp');

        // $file = new File("public/uploads/img/64490c66abf6aaa36b25860b3015feaf.pdf");
        // $response = new BinaryFileResponse($file);
        
        // return $this->file($file);

        // Generate response
        $response = new Response();
        $filename = "public/uploads/img/64490c66abf6aaa36b25860b3015feaf.pdf";
        // Set headers
        $response->headers->set('Cache-Control', 'private');
        $response->headers->set('Content-type', mime_content_type($filename));
        $response->headers->set('Content-Disposition', 'attachment; filename="' . basename($filename) . '";');
        $response->headers->set('Content-length', filesize($filename));

        // Send headers before outputting anything
        $response->sendHeaders();

        $response->setContent(file_get_contents($filename));

        return $response;
        
    }

    
}
