<?php

namespace App\Controller;

use App\Entity\Entrada;
use App\Entity\Terreno;
use App\Form\Entrada1Type;
use App\Repository\EntradaRepository;
use DateTime;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

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
    public function new(Request $request): Response
    {
        $entrada = new Entrada();
        $form = $this->createForm(Entrada1Type::class, $entrada, [
            'attr' => ['class' => 'formEntrada' ]
        ]);
        $form->handleRequest($request);

        if ($form->isSubmitted()) {

            $datos = $request->request->get('entrada1');

            if(!empty($datos['cantidad'])){
                $entrada->setCantidad($datos['cantidad'][0]);
            }
            
            if(!empty($datos['fecha_entrada'])){
                $fecha = new DateTime($datos['fecha_entrada']);
                $entrada->setFechaEntrada($fecha);
            }

            if(!empty($datos['tipo_entrada'])){
                $entrada->setTipoEntrada($datos['tipo_entrada']);
            }

            if(!empty($datos['observaciones'])){
                $entrada->setObservaciones($datos['observaciones']);
            }

            if(!empty($datos['id_terreno'])){
                foreach ($datos['id_terreno'] as $numTerreno){
                    $terreno = $this->getDoctrine()
                        ->getRepository(Terreno::class)
                        ->find($numTerreno);

                    $entrada->addIdTerreno($terreno);
                }
            }
            
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($entrada);
            $entityManager->flush();

            return $this->redirectToRoute('envase_new', [
                'entrada' => $entrada->getId(),
            ], Response::HTTP_SEE_OTHER);
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
    public function edit(Request $request, Entrada $entrada): Response
    {
        $form = $this->createForm(Entrada1Type::class, $entrada, [
            'attr' => ['class' => 'formEditEntrada' ]
        ]);
        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            
            $datos = $request->request->get('entrada1');

            if(!empty($datos['cantidad'])){
                $entrada->setCantidad($datos['cantidad'][0]);
            }
            
            if(!empty($datos['fecha_entrada'])){
                $fecha = new DateTime($datos['fecha_entrada']);
                $entrada->setFechaEntrada($fecha);
            }

            if(!empty($datos['tipo_entrada'])){
                $entrada->setTipoEntrada($datos['tipo_entrada']);
            }

            if(!empty($datos['observaciones'])){
                $entrada->setObservaciones($datos['observaciones']);
            }

            if(!empty($datos['id_terreno'])){
                
                foreach($entrada->getIdTerreno()->getValues() as $terreno){
                    $arrayIdTerrenos[] = $terreno->getId();
                }

                $existe = false;
                foreach ($datos['id_terreno'] as $numTerreno){
                    $terrenosSeleccionados[] = $numTerreno;

                    foreach($arrayIdTerrenos as $idTerreno){
                        if($numTerreno == $idTerreno){
                            $existe = true;
                        }
                    }

                    if(!$existe){
                        $terreno = $this->getDoctrine()
                            ->getRepository(Terreno::class)
                            ->find($numTerreno);

                        $entrada->addIdTerreno($terreno);
                    }
                }

                foreach($arrayIdTerrenos as $terrenoID){
                    $terrenoDeseleccionado = array_search($terrenoID, $terrenosSeleccionados);
                    
                    if($terrenoDeseleccionado === false){
                        $terreno = $this->getDoctrine()
                            ->getRepository(Terreno::class)
                            ->find($terrenoID);

                        $entrada->removeIdTerreno($terreno);
                    }
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
}
