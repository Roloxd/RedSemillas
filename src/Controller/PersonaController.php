<?php

namespace App\Controller;

use App\Entity\Donante;
use App\Entity\Persona;
use App\Form\Persona2Type;
use App\Repository\PersonaRepository;
use DateTime;
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
        $form = $this->createForm(Persona2Type::class, $persona, [
            'attr' => ['class' => 'formPersona' ]
        ]);
        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            $datos = $request->request->get('persona2');

            $fechaIncripcionRgcs = new DateTime($datos['fecha_inscripcion_rgcs']);
            $fechaCuota = new DateTime($datos['fecha_cuota']);
            $fechaInformacion = new DateTime($datos['fecha_informacion']);

            $persona->setFechaInscripcionRgcs($fechaIncripcionRgcs);
            $persona->setFechaCuota($fechaCuota);
            $persona->setFechaInformacion($fechaInformacion);

            if(!empty($datos['num_socio'])){
                $persona->setNumSocio($datos['num_socio']);
            }

            $persona->setNif($datos['nif']);
            $persona->setNombre($datos['nombre']);
            $persona->setApellidos($datos['apellidos']);

            if(!empty($datos['telefono'])){
                $persona->setTelefono($datos['telefono']);
            }

            if(!empty($datos['telefono2'])){
                $persona->setTelefono($datos['telefono2']);
            }

            if(!empty($datos['correo'])){
                $persona->setCorreo($datos['correo']);
            }

            if(!empty($datos['tipo_socio'])){
                $persona->setTipoSocio($datos['tipo_socio']);
            }

            if(isset($datos['acepta_condiciones'])){
                $persona->setAceptaCondiciones($datos['acepta_condiciones']);
            } else {
                $persona->setAceptaCondiciones(0);
            }

            if(isset($datos['terreno_cultivo'])){
                $persona->setTerrenoCultivo($datos['terreno_cultivo']);
            } else {
                $persona->setTerrenoCultivo(0);
            }

            if(isset($datos['inscripcion_rope'])){
                $persona->setInscripcionRope($datos['inscripcion_rope']);
            } else {
                $persona->setInscripcionRope(0);
            }

            if(isset($datos['ampliacion_cuota'])){
                $persona->setAmpliacionCuota($datos['ampliacion_cuota']);
            } else {
                $persona->setAmpliacionCuota(0);
            }

            if(isset($datos['recibir_informacion'])){
                $persona->setRecibirInformacion($datos['recibir_informacion']);
            } else {
                $persona->setRecibirInformacion(0);
            }

            if(!empty($datos['otras_cuestiones'])){
                $persona->setOtrasCuestiones($datos['otras_cuestiones']);
            }

            if(!empty($datos['observaciones'])){
                $persona->setObservaciones($datos['observaciones']);
            }

            if(!empty($datos['donante'])){
                $donante = $this->getDoctrine()
                    ->getRepository(Donante::class)
                    ->find($datos['donante']);

                $persona->setDonante($donante);
            }

            if(!empty($datos['direccion'])){
                $persona->setDireccion($datos['direccion']);
            }

            if(!empty($datos['localidad'])){
                $persona->setLocalidad($datos['localidad']);
            }

            if(!empty($datos['municipio'])){
                $persona->setMunicipio($datos['municipio']);
            }

            if(!empty($datos['provincia'])){
                $persona->setProvincia($datos['provincia']);
            }

            if(!empty($datos['region'])){
                $persona->setRegion($datos['region']);
            }

            if(!empty($datos['pais_origen'])){
                $persona->setPaisOrigen($datos['pais_origen']);
            }

            if(!empty($datos['relacion_agricultura'])){
                $persona->setRelacionAgricultura($datos['relacion_agricultura']);
            }

            if(!empty($datos['relacion_agricultura'])){
                $persona->setRelacionAgricultura($datos['relacion_agricultura']);
            }

            if(!empty($datos['codigo_rope'])){
                $persona->setCodigoRope($datos['codigo_rope']);
            }
            
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
        ]);
        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            $datos = $request->request->get('persona2');

            $fechaIncripcionRgcs = new DateTime($datos['fecha_inscripcion_rgcs']);
            $fechaCuota = new DateTime($datos['fecha_cuota']);
            $fechaInformacion = new DateTime($datos['fecha_informacion']);

            $persona->setFechaInscripcionRgcs($fechaIncripcionRgcs);
            $persona->setFechaCuota($fechaCuota);
            $persona->setFechaInformacion($fechaInformacion);

            if(!empty($datos['num_socio'])){
                $persona->setNumSocio($datos['num_socio']);
            }

            $persona->setNif($datos['nif']);
            $persona->setNombre($datos['nombre']);
            $persona->setApellidos($datos['apellidos']);

            if(!empty($datos['telefono'])){
                $persona->setTelefono($datos['telefono']);
            }

            if(!empty($datos['telefono2'])){
                $persona->setTelefono($datos['telefono2']);
            }

            if(!empty($datos['correo'])){
                $persona->setCorreo($datos['correo']);
            }

            if(!empty($datos['tipo_socio'])){
                $persona->setTipoSocio($datos['tipo_socio']);
            }

            if(isset($datos['acepta_condiciones'])){
                $persona->setAceptaCondiciones($datos['acepta_condiciones']);
            } else {
                $persona->setAceptaCondiciones(0);
            }

            if(isset($datos['terreno_cultivo'])){
                $persona->setTerrenoCultivo($datos['terreno_cultivo']);
            } else {
                $persona->setTerrenoCultivo(0);
            }

            if(isset($datos['inscripcion_rope'])){
                $persona->setInscripcionRope($datos['inscripcion_rope']);
            } else {
                $persona->setInscripcionRope(0);
            }

            if(isset($datos['ampliacion_cuota'])){
                $persona->setAmpliacionCuota($datos['ampliacion_cuota']);
            } else {
                $persona->setAmpliacionCuota(0);
            }

            if(isset($datos['recibir_informacion'])){
                $persona->setRecibirInformacion($datos['recibir_informacion']);
            } else {
                $persona->setRecibirInformacion(0);
            }

            if(!empty($datos['otras_cuestiones'])){
                $persona->setOtrasCuestiones($datos['otras_cuestiones']);
            }

            if(!empty($datos['observaciones'])){
                $persona->setObservaciones($datos['observaciones']);
            }

            if(!empty($datos['donante'])){
                $donante = $this->getDoctrine()
                    ->getRepository(Donante::class)
                    ->find($datos['donante']);

                $persona->setDonante($donante);
            }

            if(!empty($datos['direccion'])){
                $persona->setDireccion($datos['direccion']);
            }

            if(!empty($datos['localidad'])){
                $persona->setLocalidad($datos['localidad']);
            }

            if(!empty($datos['municipio'])){
                $persona->setMunicipio($datos['municipio']);
            }

            if(!empty($datos['provincia'])){
                $persona->setProvincia($datos['provincia']);
            }

            if(!empty($datos['region'])){
                $persona->setRegion($datos['region']);
            }

            if(!empty($datos['pais_origen'])){
                $persona->setPaisOrigen($datos['pais_origen']);
            }

            if(!empty($datos['relacion_agricultura'])){
                $persona->setRelacionAgricultura($datos['relacion_agricultura']);
            }

            if(!empty($datos['relacion_agricultura'])){
                $persona->setRelacionAgricultura($datos['relacion_agricultura']);
            }

            if(!empty($datos['codigo_rope'])){
                $persona->setCodigoRope($datos['codigo_rope']);
            }

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
