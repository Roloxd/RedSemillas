<?php

namespace App\Controller;

use App\Entity\Donante;
use App\Entity\Instituciones;
use App\Entity\Pago;
use App\Entity\Persona;
use App\Form\Persona2Type;
use App\Repository\PersonaRepository;
use DateTime;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\VarDumper\Cloner\Data;

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
        $form = $this->createForm(Persona2Type::class, $persona, [
            'attr' => ['class' => 'formPersona' ]
        ])->add('saveAndAdd', SubmitType::class, ['label' => 'Guardar y crear pago']);
        $form->handleRequest($request);
        
        if ($form->isSubmitted()) {
            // $entityManager = $this->getDoctrine()->getManager();
            // $entityManager->persist($persona);
            // $entityManager->flush();

            // Crear Donante o Recolector
            $dataDonante = $request->request->get('donante');

            dump($dataDonante);

            $donante = new Donante;

            if(isset($dataDonante['proyecto']) && !empty($dataDonante['proyecto'])) {
                $donante->setProyecto($dataDonante['proyecto']);
            }
            if(isset($dataDonante['tipoDonante']) && !empty($dataDonante['tipoDonante'])) {
                $donante->setTipoDonante($dataDonante['tipoDonante']);
            }
            if(isset($dataDonante['numAccesion']) && !empty($dataDonante['numAccesion'])) {
                $donante->setNumAccesionDonante($dataDonante['numAccesion']);
            }
            if(isset($dataDonante['observaciones']) && !empty($dataDonante['observaciones'])) {
                $donante->setObservaciones($dataDonante['observaciones']);
            }
            // Terminar parte de Donante /new y /edit
            
            // $donante->setNumeroRecolector($dataDonante['codigoRecolector']);



            // $institucion = $this->getDoctrine()
            //     ->getRepository(Instituciones::class)
            //     ->find($dataDonante['institutoRecolector']);
            // $donante->setCodigoInstitutoRecolector($institucion);

            // $institucion = $this->getDoctrine()
            //     ->getRepository(Instituciones::class)
            //     ->find($dataDonante['institutoMejoramiento']);
            // $donante->setCodigoInstitutoMejoramiento($institucion);

            if($form->get('saveAndAdd')->isClicked()) {
                return $this->redirectToRoute('pago_new', ['persona' => $persona->getId()], Response::HTTP_SEE_OTHER);
            } else {
                return $this->redirectToRoute('persona_index', [], Response::HTTP_SEE_OTHER);
            }
        }

        $text = 'Nueva Persona';
        $pagado = false;

        return $this->renderForm('persona/new.html.twig', [
            'persona' => $persona,
            'pagado' => $pagado,
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
     * @Route("/findAll", name="persona_findAll", methods={"POST"})
     */
    public function findAll(): Response
    {
        $personas = $this->getDoctrine()
                ->getRepository(Persona::class)
                ->findAllNombres();

        $response = new Response();
        $response->setContent(json_encode([
            'personas' => $personas,
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
        $form = $this->createForm(Persona2Type::class, $persona, [
            'attr' => ['class' => 'formEditPersona' ]
        ])->add('saveAndAdd', SubmitType::class, ['label' => 'Actualizar y crear pago']);
        $form->handleRequest($request);

        //Comprobar si pago este año
        $pagado = false;
        $pagos = $persona->getPagos()->getValues();
        if($pagos){
            foreach($pagos as $pago) {
                $yearsPago[] = $pago->getFechaPago()->format('Y');
                $yearsRenovacion[] = $pago->getFechaRenovacion()->format('Y');
            }

            //Si pago año actual, y su renovacion es el año que viene
            if(in_array(date('Y'), $yearsPago) && in_array(date('Y')+1, $yearsRenovacion)){
                $pagado = true;
            }
        }
        
        if ($form->isSubmitted()) {
            $datos = $request->request->get('persona2');

            if(!empty($datos['donante'])){
                $donante = $this->getDoctrine()
                    ->getRepository(Donante::class)
                    ->find($datos['donante']);

                $persona->setDonante($donante);
            }

            $this->getDoctrine()->getManager()->flush();

            if($form->get('saveAndAdd')->isClicked()) {
                return $this->redirectToRoute('pago_new', ['persona' => $persona->getId()], Response::HTTP_SEE_OTHER);
            } else {
                return $this->redirectToRoute('persona_index', [], Response::HTTP_SEE_OTHER);
            }
        }

        $text = 'Editar Persona';

        return $this->renderForm('persona/edit.html.twig', [
            'persona' => $persona,
            'pagado' => $pagado,
            'form' => $form,
            'text_form' => $text,
        ]);
    }

    /**
     * @Route("/{id}/mostrar", name="persona_mostrar", methods={"GET"})
     */
    public function mostrar(Request $request): Response
    {
        $id = $request->attributes->get('id');

        $personas[] = $this->getDoctrine()
            ->getRepository(Persona::class)
            ->find($id);

        return $this->render('persona/index.html.twig', [
            'personas' => $personas,
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
