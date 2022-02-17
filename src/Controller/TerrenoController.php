<?php

namespace App\Controller;

use App\Entity\Entrada;
use App\Entity\Persona;
use App\Entity\PersonaTerreno;
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

        if ($form->isSubmitted()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($terreno);
            $entityManager->flush();

            $datos = $request->request->get('terreno');

            // Agrega las Personas al Terreno
            if(isset($datos['personas']) && !empty($datos['personas'])) {
                $personas = $datos['personas'];
                foreach( $personas as $personaSelect) {
                    $persona = $this->getDoctrine()
                        ->getRepository(Persona::class)
                        ->find( intval($personaSelect) );
                    
                    $personaTerreno = new PersonaTerreno;
                    $personaTerreno->setTerreno($terreno);
                    $personaTerreno->setPersona($persona);

                    // Asignamos si la Persona es propietaria
                    if(isset($datos['propietarios']) && !empty($datos['propietarios'])) {
                        $propietarios = $datos['propietarios'];

                        if(in_array($personaSelect, $propietarios)) {
                            $personaTerreno->setPropietario(true);
                        } else {
                            $personaTerreno->setPropietario(false);
                        }
                    }

                    $entityManager = $this->getDoctrine()->getManager();
                    $entityManager->persist($personaTerreno);
                    $entityManager->flush();
                }
            }

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
        $personaId = $request->request->get('personaId');
        // $idEntrada = $request->request->get('idEntrada');
        
        $persona = $this->getDoctrine()
                ->getRepository(Persona::class)
                ->find( intval($personaId) );
        
        dump($persona);
        //$terrenos = $persona->getTerrenos()->getValues();
        
        // Arreglar, no se obtienen los terrenos vinculados a la persona


        $args = [];
        if(!empty($terrenos)) {
            foreach($terrenos as $terreno) {
                $terrenoId = $terreno->getId();
                $nombre = $terreno->getNombre();
                $municipio = $terreno->getMunicipio();
                $direccion = $terreno->getDireccion();

                $args[$terrenoId] = [
                    'nombre' => $nombre,
                    'municipio' => $municipio,
                    'direccion' => $direccion,
                ];
            }
        }

        // if(!empty($idPersona)){
        //     $terrenos = $this->getDoctrine()
        //         ->getRepository(Terreno::class)
        //         ->findTerrenosPersona($idPersona[0]['id']);

        //     if(empty($terrenos)){
        //         $terrenos = "";
        //     }
        // } else {
        //     $terrenos = "";
        // }

        // if(!empty($idEntrada)){
        //     $entrada = $this->getDoctrine()
        //         ->getRepository(Entrada::class)
        //         ->find($idEntrada);

        //     foreach($entrada->getIdTerreno()->getValues() as $terreno){
        //         $arrayIdTerrenos[] = $terreno->getId();
        //     }
        // } else {
        //     $arrayIdTerrenos = "";
        // }

        $response = new Response();
        $response->setContent(json_encode([
            'terrenos' => $args,
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

        if ($form->isSubmitted()) {
            
            $datos = $request->request->get('terreno');
            dump($datos);
            
            // Obtenemos los IDs de las personas relacionados con el Terreno
            $personaTerrenos = $terreno->getPersonaTerrenos()->getValues();

            foreach($personaTerrenos as $personaTerreno) {
                $persona = $personaTerreno->getPersona();
                $idPersona = strval( $persona->getId() );

                if(isset($datos['personas']) && !empty($datos['personas'])) {

                    // Elimina la persona desmarcada
                    if( !in_array($idPersona, $datos['personas']) ) {
                        $entityManager = $this->getDoctrine()->getManager();
                        $entityManager->remove($personaTerreno);
                        $entityManager->flush();
                    } else {
                        
                        // Elimina el propietario desmarcado
                        if(isset($datos['propietarios']) && !empty($datos['propietarios'])) {
                            if( !in_array($idPersona, $datos['propietarios']) )  {
                                $personaTerreno->setPropietario(false);
                            } else {
                                $personaTerreno->setPropietario(true);
                            }

                        } else if(!isset($datos['propietarios'])) {
                            $personaTerreno->setPropietario(false);
                        }

                        $entityManager = $this->getDoctrine()->getManager();
                        $entityManager->persist($personaTerreno);
                        $entityManager->flush();

                    }

                }
            }

            $this->getDoctrine()->getManager()->flush();

            // Obtener Personas relacionadas con el Terreno
            $personaTerrenos = $terreno->getPersonaTerrenos()->getValues();
            $idPersonas = [];
            foreach($personaTerrenos as $personaTerreno) {
                $persona = $personaTerreno->getPersona();
                $idPersonas[] = strval( $persona->getId() );

            }
            
            // Agrega las Personas al Terreno
            if(isset($datos['personas']) && !empty($datos['personas'])) {
                $personas = $datos['personas'];
                foreach( $personas as $personaSelect) {
                    if( !in_array($personaSelect, $idPersonas) ) { // Si no existe relacion, la crea
                        $persona = $this->getDoctrine()
                            ->getRepository(Persona::class)
                            ->find( intval($personaSelect) );
                        
                        $personaTerreno = new PersonaTerreno;
                        $personaTerreno->setTerreno($terreno);
                        $personaTerreno->setPersona($persona);

                        // Asignamos si la Persona es propietaria
                        if(isset($datos['propietarios']) && !empty($datos['propietarios'])) {
                            $propietarios = $datos['propietarios'];

                            if(in_array($personaSelect, $propietarios)) {
                                $personaTerreno->setPropietario(true);
                            } else {
                                $personaTerreno->setPropietario(false);
                            }
                        }

                        $entityManager = $this->getDoctrine()->getManager();
                        $entityManager->persist($personaTerreno);
                        $entityManager->flush();
                    }
                }
            }

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
