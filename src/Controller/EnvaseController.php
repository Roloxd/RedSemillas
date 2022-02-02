<?php

namespace App\Controller;

use App\Entity\Envase;
use App\Entity\Entrada;
use App\Entity\Variedad;
use App\Form\EnvaseType;
use App\Repository\EnvaseRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/envase")
 */
class EnvaseController extends AbstractController
{
    /**
     * @Route("/", name="envase_index", methods={"GET"})
     */
    public function index(EnvaseRepository $envaseRepository): Response
    {
        return $this->render('envase/index.html.twig', [
            'envases' => $envaseRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="envase_new", methods={"GET", "POST"})
     */
    public function new(Request $request): Response
    {
        $idEntrada = $request->query->get('entrada');
        $error = null;

        $envase = new Envase();
        $form = $this->createForm(EnvaseType::class, $envase, [
            'attr' => ['class' => 'formEnvase' ]
        ]);
        $form->handleRequest($request);

        if(empty($idEntrada)){
            $idEntrada = null;
        } else {
            $entrada = $this->getDoctrine()
                ->getRepository(Entrada::class)
                ->find( intval($idEntrada) );

            $form->get('entrada')->setData($entrada);
        }
        
        if ($form->isSubmitted() && $form->isValid()) {
            $datos = $request->request->get('envase');

            if(isset($datos["codigo"]) && empty($datos["codigo"])) {
                $envases = $this->getDoctrine()
                    ->getRepository(Envase::class)
                    ->findAll();

                $codigos = null;
                if(!empty($envases)){
                    foreach($envases as $envaseCodigo){
                        $codigos[] = $envaseCodigo->getCodigo();
                    }

                    $codigo = max($codigos) + 1;
                }
                
                $envase->setCodigo($codigo);
            }

            if( isset($datos['variedads']) && !empty($datos['variedads']) ) {
                foreach( $datos['variedads'] as $variedadPOST ) {
                    
                    $variedad = $this->getDoctrine()
                        ->getRepository(Variedad::class)
                        ->find( intval($variedadPOST) );

                    $variedad->addEnvase($envase);
                }
            }

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($envase);

            try {
                $entityManager->flush();
                return $this->redirectToRoute('envase_new', [], Response::HTTP_SEE_OTHER);
            } catch (\Exception $e) {
                if(strpos($e->getMessage(), 'codigo_envase')) {
                    $error['codigo'] = "Existe un envase con este código, prueba con otro código";
                } else {
                    $error['codigo'] = $e->getMessage();
                }
            }
            
            // return $this->redirectToRoute('envase_new', [
            //     'entrada' => $idEntrada,
            // ], Response::HTTP_SEE_OTHER);
        }

        $text = 'Nuevo Envase';

        return $this->renderForm('envase/new.html.twig', [
            'envase' => $envase,
            'form' => $form,
            'text_form' => $text,
            'error' => $error,
        ]);
    }

    /**
     * @Route("/findEnvase", name="envase_find", methods={"POST"})
     */
    public function find(Request $request): Response
    {
        $datos = null;

        $idEnvase = intval($request->request->get('idEnvase'));
        $funcion = $request->request->get('funcion');
        
        $envase = $this->getDoctrine()
            ->getRepository(Envase::class)
            ->find($idEnvase);

        if($funcion === "obtenerVariedades") {
            $datos = $this->obtenerVariedades($envase);
        }

        $response = new Response();
        $response->setContent(json_encode($datos));
        $response->headers->set('Content-Type', 'application/json');

        return $response; 
    }

    // Obtener las Variedades de un Envase, en caso de tener más de 1 variedad, retorna su nombre y id
    public function obtenerVariedades($envase): array
    {
        $variedades = $envase->getVariedads()->getValues();
        $arrayVariedades = [];

        if($variedades) {
            foreach($variedades as $variedad) {
                $arrayVariedades[$variedad->getId()] = $variedad->__toString();
            }
        }

        return $arrayVariedades;
    }

    /**
     * @Route("/{id}", name="envase_show", methods={"GET"})
     */
    public function show(Envase $envase): Response
    {
        return $this->render('envase/show.html.twig', [
            'envase' => $envase,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="envase_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Envase $envase): Response
    {
        
        $form = $this->createForm(EnvaseType::class, $envase, [
            'attr' => ['class' => 'formEditEnvase' ]
        ]);
        $form->handleRequest($request);

        $error = null;

        if ($form->isSubmitted() && $form->isValid()) {
            $datos = $request->request->get('envase');

            if(isset($datos["codigo"]) && empty($datos["codigo"])) {
                $envases = $this->getDoctrine()
                    ->getRepository(Envase::class)
                    ->findAll();

                $codigos = null;
                if(!empty($envases)){
                    foreach($envases as $envaseCodigo){
                        $codigos[] = $envaseCodigo->getCodigo();
                    }

                    $codigo = max($codigos) + 1;
                }
                
                $envase->setCodigo($codigo);
            }

            // Relación Variedad
            if( isset($datos['variedads']) && !empty($datos['variedads']) ) {
                foreach( $datos['variedads'] as $variedadPOST ) {
                    
                    $variedad = $this->getDoctrine()
                        ->getRepository(Variedad::class)
                        ->find( intval($variedadPOST) );

                    $variedad->addEnvase($envase);
                }
            }

            // Elimina los desmarcados
            if(!empty($datos['variedads'])) {
                $qb = $this->getDoctrine()
                    ->getRepository(Variedad::class)
                    ->createQueryBuilder('v')
                    ->innerJoin('v.envases', 'e')
                        ->where('e.id LIKE :busqueda')
                        ->setParameter('busqueda', '%'.$envase->getId().'%');

                $variedadesDB = $qb->getQuery()->execute(); // Obtenemos las variedades relacionadas con el envase
                
                foreach($variedadesDB as $variedadDB) {
                    if(!in_array($variedadDB->getId(), $datos['variedads'])) {
                        $envase->removeVariedad($variedadDB);
                        $variedadDB->removeEnvase($envase);
                    }
                }
            }

            try {
                $this->getDoctrine()->getManager()->flush();
                return $this->redirectToRoute('envase_index', [], Response::HTTP_SEE_OTHER);
            } catch (\Exception $e) {
                if(strpos($e->getMessage(), 'codigo_envase')) {
                    $error['codigo'] = "Existe un envase con este código, prueba con otro código";
                } else {
                    $error['codigo'] = $e->getMessage();
                }
            }
        }

        $text = 'Editar Envase';

        return $this->renderForm('envase/edit.html.twig', [
            'envase' => $envase,
            'form' => $form,
            'text_form' => $text,
            'error' => $error,
        ]);
    }

    /**
     * @Route("/{id}/ver", name="envase_ver", methods={"GET"})
     */
    public function ver(Request $request): Response
    {
        $id = $request->attributes->get('id');

        $entrada = $this->getDoctrine()
            ->getRepository(Entrada::class)
            ->find($id);

        $envases = $entrada->getNumEnvase()->getValues();

        return $this->render('envase/index.html.twig', [
            'envases' => $envases,
        ]);
    }

    /**
     * @Route("/{id}/mostrar", name="envase_mostrar", methods={"GET"})
     */
    public function mostrar(Request $request): Response
    {
        $id = $request->attributes->get('id');

        $envases[] = $this->getDoctrine()
            ->getRepository(Envase::class)
            ->find($id);

        return $this->render('envase/index.html.twig', [
            'envases' => $envases,
        ]);
    }

    /**
     * @Route("/{id}/verEnvases", name="envaseVariedad_ver", methods={"GET"})
     */
    public function verVariedades(Request $request): Response
    {
        $id = $request->attributes->get('id');

        $variedad = $this->getDoctrine()
            ->getRepository(Variedad::class)
            ->find($id);

        $envases = $variedad->getEnvases()->getValues();

        return $this->render('envase/index.html.twig', [
            'envases' => $envases,
        ]);
    }

    /**
     * @Route("/{id}", name="envase_delete", methods={"POST"})
     */
    public function delete(Request $request, Envase $envase): Response
    {
        if ($this->isCsrfTokenValid('delete'.$envase->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($envase);
            $entityManager->flush();
        }

        return $this->redirectToRoute('envase_index', [], Response::HTTP_SEE_OTHER);
    }
}
