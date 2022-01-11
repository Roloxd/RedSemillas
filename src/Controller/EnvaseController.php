<?php

namespace App\Controller;

use App\Entity\Envase;
use App\Entity\Entrada;
use App\Entity\Variedad;
use App\Form\EnvaseType;
use App\Repository\EnvaseRepository;
use DateTime;
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
        $tipoAlmacenamiento = null;
        $condicionBiologica = null;
        $fuenteRecoleccion = null;
        $estadoMLS = null;
        $error = null;

        if(empty($idEntrada)){
            $idEntrada = null;
        }
        
        $envase = new Envase();
        $form = $this->createForm(EnvaseType::class, $envase, [
            'attr' => ['class' => 'formEnvase' ]
        ]);
        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            $datos = $request->request->get('envase');

            if(isset($datos["codigo"]) && !empty($datos["codigo"])) {
                
                $envase2 = $this->getDoctrine()
                    ->getRepository(Envase::class)
                    ->findCodigo($datos["codigo"]);

                if($envase2 == null){
                    $envase->setCodigo($datos["codigo"]);
                } else {
                    //Si existe ya una Envase con ese Codigo, mostrar error
                    $envasesDB = $this->getDoctrine()
                    ->getRepository(Envase::class)
                    ->findAll();

                    if(!empty($envasesDB)){
                        foreach($envasesDB as $envaseCodigo){
                            $codigos[] = $envaseCodigo->getCodigo();
                        }
    
                        $codigo = max($codigos) + 1;
                    } else {
                        $codigo = 1;
                    }

                    $envase->setCodigo($codigo);
                }
            } else if (empty($datos["codigo"])) {
                $envasesDB = $this->getDoctrine()
                    ->getRepository(Envase::class)
                    ->findAll();

                $codigos = null;
                if(!empty($envasesDB)){
                    foreach($envasesDB as $envaseCodigo){
                        $codigos[] = $envaseCodigo->getCodigo();
                    }

                    $codigo = max($codigos) + 1;
                } else {
                    $codigo = 1;
                }
                
                $envase->setCodigo($codigo);
            }

            if(!empty($datos['tipo_almacenamiento'])){
                $envase->setTipoAlmacenamiento($datos['tipo_almacenamiento']);
            }
            
            if(!empty($datos['fecha_envasado'])){
                $fecha = new DateTime($datos['fecha_envasado']);
                $envase->setFechaEnvasado($fecha);
            }

            if(!empty($datos['ubicacion_envase'])){
                $envase->setUbicacionEnvase($datos['ubicacion_envase']);
            }

            if(!empty($datos['temperatura_envasado'])){
                $envase->setTemperaturaEnvasado($datos['temperatura_envasado']);
            }

            if(!empty($datos['humedad_relativa_envasar'])){
                $envase->setHumedadRelativaEnvasar($datos['humedad_relativa_envasar']);
            }

            if(!empty($datos['humedad_relativa_semilla'])){
                $envase->setHumedadRelativaSemilla($datos['humedad_relativa_semilla']);
            }

            if(!empty($datos['cantidad_min_seguridad'])){
                $envase->setCantidadMinSeguridad($datos['cantidad_min_seguridad']);
            }

            if(!empty($datos['cantidad_min_unidades'])){
                $envase->setCantidadMinUnidades($datos['cantidad_min_unidades']);
            }

            if(!empty($datos['unidades_gramo'])){
                $envase->setUnidadesGramo($datos['unidades_gramo']);
            }

            if(!empty($datos['disponibilidad_red'])){
                $envase->setDisponibilidadRed($datos['disponibilidad_red']);
            }

            if(!empty($datos['conservacion'])){
                $envase->setConservacion($datos['conservacion']);
            }

            if(!empty($datos['observaciones'])){
                $envase->setObservaciones($datos['observaciones']);
            }

            if(!empty($datos['entrada'])){
                $entrada = $this->getDoctrine()
                    ->getRepository(Entrada::class)
                    ->find($datos['entrada']);

                $envase->setEntrada($entrada);
            }

            if(!empty($datos['cantidad_gramos'])){
                $envase->setCantidadGramos($datos['cantidad_gramos']);
            }

            if(!empty($datos['cantidad_unidades'])){
                $envase->setCantidadUnidades($datos['cantidad_unidades']);
            }

            if(!empty($datos['unidades_viables'])){
                $envase->setUnidadesViables($datos['unidades_viables']);
            }

            if(!empty($datos['condicion_biologica'])){
                $envase->setCondicionBiologica($datos['condicion_biologica']);
            }

            if(!empty($datos['datos_ancestrales'])){
                $envase->setDatosAncestrales($datos['datos_ancestrales']);
            }

            if(!empty($datos['codigo_instituto'])){
                $envase->setCodigoInstituto($datos['codigo_instituto']);
            }

            if(!empty($datos['nombre_instituto'])){
                $envase->setNombreInstituto($datos['nombre_instituto']);
            }

            if(!empty($datos['fuente_recoleccion'])){
                $envase->setFuenteRecoleccion($datos['fuente_recoleccion']);
            }

            if(!empty($datos['estado_accesion_mls'])){
                $envase->setEstadoAccesionMls($datos['estado_accesion_mls']);
            }

            if( isset($datos['variedads']) && !empty($datos['variedads']) ) {
                foreach( $datos['variedads'] as $variedadDB ) {
                    
                    $variedad = $this->getDoctrine()
                        ->getRepository(Variedad::class)
                        ->find( intval($variedadDB) );

                    $envase->addVariedad($variedad);
                    $variedad->addEnvase($envase);
                }
            }

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($envase);
            $entityManager->flush();

            return $this->redirectToRoute('envase_new', [
                'entrada' => $idEntrada,
            ], Response::HTTP_SEE_OTHER);
        }

        $text = 'Nuevo Envase';

        return $this->renderForm('envase/new.html.twig', [
            'idEntrada' => $idEntrada,
            'tipoAlmacenamiento' => $tipoAlmacenamiento,
            'condicionBiologica' => $condicionBiologica,
            'fuenteRecoleccion' => $fuenteRecoleccion,
            'estadoMLS' => $estadoMLS,
            'envase' => $envase,
            'form' => $form,
            'text_form' => $text,
            'error' => $error,
        ]);
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

        $idEntrada = null;
        $tipoAlmacenamiento = null;
        $condicionBiologica = null;
        $fuenteRecoleccion = null;
        $estadoMLS = null;
        $error = null;

        if($envase->getEntrada()){
            $idEntrada = $envase->getEntrada()->getId();
        }

        if($envase->getTipoAlmacenamiento()){
            $tipoAlmacenamiento = $envase->getTipoAlmacenamiento();
        }

        if($envase->getCondicionBiologica()){
            $condicionBiologica = $envase->getCondicionBiologica();
        }

        if($envase->getFuenteRecoleccion()){
            $fuenteRecoleccion = $envase->getFuenteRecoleccion();
        }

        if($envase->getEstadoAccesionMls()){
            $estadoMLS = $envase->getEstadoAccesionMls();
        }

        if ($form->isSubmitted()) {
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
            } else if (isset($datos["codigo"]) && !empty($datos["codigo"])) {

                $qb = $this->getDoctrine()
                    ->getRepository(Envase::class)
                    ->findCodigoID($envase->getId()); //Obtenemos el Codigo, desde la DB

                if( $datos["codigo"] != $qb[0]['codigo'] ) {
                    $qb = $this->getDoctrine()
                        ->getRepository(Envase::class)
                        ->createQueryBuilder('e')
                            ->where('e.codigo LIKE :busqueda')
                            ->setParameter('busqueda', '%'.$datos["codigo"].'%');
                    
                    $envaseDB = $qb->getQuery()->execute();
                    
                    if(count($envaseDB) >= 1) {
                        $error['codigo'] = 'Ya existe un registro con este ID';
                    }
                }
            }
            
            if(!empty($datos['tipo_almacenamiento'])){
                $envase->setTipoAlmacenamiento($datos['tipo_almacenamiento']);
            }
            
            if(!empty($datos['fecha_envasado'])){
                $fecha = new DateTime($datos['fecha_envasado']);
                $envase->setFechaEnvasado($fecha);
            }

            if(!empty($datos['ubicacion_envase'])){
                $envase->setUbicacionEnvase($datos['ubicacion_envase']);
            }

            if(!empty($datos['temperatura_envasado'])){
                $envase->setTemperaturaEnvasado($datos['temperatura_envasado']);
            }

            if(!empty($datos['humedad_relativa_envasar'])){
                $envase->setHumedadRelativaEnvasar($datos['humedad_relativa_envasar']);
            }

            if(!empty($datos['humedad_relativa_semilla'])){
                $envase->setHumedadRelativaSemilla($datos['humedad_relativa_semilla']);
            }

            if(!empty($datos['cantidad_min_seguridad'])){
                $envase->setCantidadMinSeguridad($datos['cantidad_min_seguridad']);
            }

            if(!empty($datos['cantidad_min_unidades'])){
                $envase->setCantidadMinUnidades($datos['cantidad_min_unidades']);
            }

            if(!empty($datos['unidades_gramo'])){
                $envase->setUnidadesGramo($datos['unidades_gramo']);
            }

            if(!empty($datos['disponibilidad_red'])){
                $envase->setDisponibilidadRed($datos['disponibilidad_red']);
            }

            if(!empty($datos['conservacion'])){
                $envase->setConservacion($datos['conservacion']);
            }

            if(!empty($datos['observaciones'])){
                $envase->setObservaciones($datos['observaciones']);
            }

            if(!empty($datos['entrada'])){
                $entrada = $this->getDoctrine()
                    ->getRepository(Entrada::class)
                    ->find($datos['entrada']);

                $envase->setEntrada($entrada);
            }

            if(!empty($datos['cantidad_gramos'])){
                $envase->setCantidadGramos($datos['cantidad_gramos']);
            }

            if(!empty($datos['cantidad_unidades'])){
                $envase->setCantidadUnidades($datos['cantidad_unidades']);
            }

            if(!empty($datos['unidades_viables"'])){
                $envase->setUnidadesViables($datos['unidades_viables']);
            }

            if(!empty($datos['condicion_biologica'])){
                $envase->setCondicionBiologica($datos['condicion_biologica']);
            }

            if(!empty($datos['datos_ancestrales'])){
                $envase->setDatosAncestrales($datos['datos_ancestrales']);
            }

            if(!empty($datos['codigo_instituto'])){
                $envase->setCodigoInstituto($datos['codigo_instituto']);
            }

            if(!empty($datos['nombre_instituto'])){
                $envase->setNombreInstituto($datos['nombre_instituto']);
            }

            if(!empty($datos['fuente_recoleccion'])){
                $envase->setFuenteRecoleccion($datos['fuente_recoleccion']);
            }

            if(!empty($datos['estado_accesion_mls'])){
                $envase->setEstadoAccesionMls($datos['estado_accesion_mls']);
            }

            // Relación Variedad
            if( isset($datos['variedads']) && !empty($datos['variedads']) ) {
                foreach( $datos['variedads'] as $variedadDB ) {
                    
                    $variedad = $this->getDoctrine()
                        ->getRepository(Variedad::class)
                        ->find( intval($variedadDB) );

                    $envase->addVariedad($variedad);
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

            if(empty($error)) {
                $this->getDoctrine()->getManager()->flush();
                return $this->redirectToRoute('envase_index', [], Response::HTTP_SEE_OTHER);
            }
        }

        $text = 'Editar Envase';

        return $this->renderForm('envase/edit.html.twig', [
            'idEntrada' => $idEntrada,
            'tipoAlmacenamiento' => $tipoAlmacenamiento,
            'condicionBiologica' => $condicionBiologica,
            'fuenteRecoleccion' => $fuenteRecoleccion,
            'estadoMLS' => $estadoMLS,
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
