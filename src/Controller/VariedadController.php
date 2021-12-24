<?php

namespace App\Controller;

use App\Entity\CicloYSiembra;
use App\Entity\Imagen;
use App\Entity\ImagenSeleccionada;
use App\Entity\Taxon;
use App\Entity\Uso;
use App\Entity\UsoVariedad;
use App\Entity\Variedad;
use App\Form\ImagenSeleccionadaType;
use App\Form\ImagenType;
use App\Form\Variedad1Type;
use App\Repository\VariedadRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/variedades")
 */
class VariedadController extends AbstractController
{
    /**
     * @Route("/", name="variedad_index", methods={"GET"})
     */
    public function index(VariedadRepository $variedadRepository): Response
    {
        $variedadesDB = $this->getDoctrine()
            ->getRepository(Variedad::class)
            ->findAll();

        foreach($variedadesDB as $variedadDB){
            if(!empty($variedadDB->getEspecie())){
                $especies[$variedadDB->getId()] = $variedadDB->getEspecie()->getNombre();

                if(!empty($variedadDB->getEspecie()->getPadre())){
                    $generoObject = $this->getDoctrine()
                        ->getRepository(Taxon::class)
                        ->find($variedadDB->getEspecie()->getPadre());

                    $generos[$variedadDB->getId()] = $generoObject->getNombre();

                    if(!empty($generoObject->getPadre())){
                        $familiaObject = $this->getDoctrine()
                            ->getRepository(Taxon::class)
                            ->find($generoObject->getPadre());
                        
                            $familias[$variedadDB->getId()] = $familiaObject->getNombre();
                    }
                }
            } else {
                $especies[$variedadDB->getId()] = "";
                $generos[$variedadDB->getId()] = "";
                $familias[$variedadDB->getId()] = "";
                $subtaxons[$variedadDB->getId()] = "";
            }
        }

        return $this->render('variedad/index.html.twig', [
            'variedades' => $variedadesDB,
            'especies' => $especies,
            'generos' => $generos,
            'familias' => $familias,
        ]);
    }

    /**
     * @Route("/new", name="variedad_new", methods={"GET", "POST"})
     */
    public function new(Request $request): Response
    {
        $variedad = new Variedad();
        $form = $this->createForm(Variedad1Type::class, $variedad, [
            'attr' => ['class' => 'formVariedad' ]
        ]);
        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            $datos = $request->request->get('variedad1');

            $entero = ['diasSemillero', 'viabilidadMin', 'viabilidadMax', 'cicloCultivo'];
            $decimal = ['marcoA', 'marcoB', 'densidad'];
            $entity = ['especie'];
            $usos = ['usoAlimenHumana', 'usoAlimenAnimal', 'usoMedicinales', 'usoVeterinarios', 'usoToxicNocivo', 'usoCombustible', 'usoConstruccion', 'usoArtesania', 'usoMedioambientales', 'usoOrnamentales', 'usoSociales'];
            $descripcionUsos = ['variedad1_usoAlimenHumana_descripcion', 'variedad1_usoAlimenAnimal_descripcion', 'variedad1_usoMedicinales_descripcion', 'variedad1_usoVeterinarios_descripcion', 'variedad1_usoToxicNocivo_descripcion', 'variedad1_usoCombustible_descripcion', 'variedad1_usoConstruccion_descripcion', 'variedad1_usoArtesania_descripcion', 'variedad1_usoMedioambientales_descripcion', 'variedad1_usoOrnamentales_descripcion', 'variedad1_usoSociales_descripcion'];

            foreach($entero as $value){
                if($datos[$value] == "" || empty($datos[$value])){
                    $datos[$value] = 0;
                }
            }

            foreach($decimal as $value){
                if($datos[$value] == "" || empty($datos[$value])){
                    $datos[$value] = 0.000;
                }
            }

            foreach($entity as $value){
                if(isset($datos[$value]) && !empty($datos[$value])){
                    $idTaxon = $this->getDoctrine()
                        ->getRepository(Taxon::class)
                        ->findId($datos['especie']); //Busca por el nombre de la especie, sin tener encuenta genere ni familia

                    $taxon = $this->getDoctrine()
                        ->getRepository(Taxon::class)
                        ->find($idTaxon[0]['id']);

                    $variedad->setEspecie($taxon);
                }
            }

            $variedad->setNombreComun($datos['nombreComun']);
            $variedad->setNombreLocal($datos['nombreLocal']);
            $variedad->setBreveDescrPlantaCultivo($datos['breveDescrPlantaCultivo']);
            $variedad->setDescripcion($datos['descripcion']);
            $variedad->setTipoSiembra($datos['tipoSiembra']);
            $variedad->setDiasSemillero($datos['diasSemillero']);
            $variedad->setMarcoA($datos['marcoA']);
            $variedad->setMarcoB($datos['marcoB']);
            $variedad->setDensidad($datos['densidad']);
            $variedad->setCicloCultivo($datos['cicloCultivo']);
            $variedad->setPolinizacion($datos['polinizacion']);
            $variedad->setViabilidadMin($datos['viabilidadMin']);
            $variedad->setViabilidadMax($datos['viabilidadMax']);
            $variedad->setConocimientosTradicionales($datos['conocimientosTradicionales']);
            $variedad->setCmPlanta($datos['cmPlanta']);
            $variedad->setCmFlor($datos['cmFlor']);
            $variedad->setCmFruto($datos['cmFruto']);
            $variedad->setCmSemilla($datos['cmSemilla']);
            $variedad->setCArgonomicas($datos['cArgonomicas']);
            $variedad->setCOrganolepticas($datos['cOrganolepticas']);
            $variedad->setPropagacion($datos['propagacion']);
            $variedad->setOtros($datos['otros']);
            $variedad->setObservaciones($datos['observaciones']);

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($variedad);
            $entityManager->flush();

            // Relación UsoVariedad
            foreach ($usos as $value) {
                if(isset($datos[$value]) && !empty($datos[$value])) {
                    foreach($datos[$value] as $id) {

                        $uso = $this->getDoctrine()
                        ->getRepository(Uso::class)
                        ->find($id);

                        $usoVariedad = new UsoVariedad;
                        $usoVariedad->setVariedad($variedad);
                        $usoVariedad->setUso($uso);

                        
                        if(preg_match('/Otro usos/', $uso->getTipo())) { 
                            for($i = 0; $i < count($descripcionUsos); $i++) {
                                if($value == $usos[$i]){
                                    if( isset($datos[$descripcionUsos[$i]]) ) {
                                        $usoVariedad->setDescripcion($datos[$descripcionUsos[$i]]);
                                    }
                                }
                            }
                        }

                        $entityManager = $this->getDoctrine()->getManager();
                        $entityManager->persist($usoVariedad);
                        $entityManager->flush();
                    }
                }
            }
            
            if($variedad->getId()){
                $idVariedad = $variedad->getId();
            } else {
                $idVariedad = null;
            }

            $datosCiclosYSiembras = $request->request->get('ciclo_y_siembra');

            //Ciclo y siembra
            if(isset($datosCiclosYSiembras) && !empty($datosCiclosYSiembras)) {

                foreach($datosCiclosYSiembras as $datosCicloYSiembra){
                    $cicloYSiembra = new CicloYSiembra;
                
                    // anual, bianual y perenne | Multiseleccion
                    if(isset($datosCicloYSiembra["ciclo"]) && !empty($datosCicloYSiembra["ciclo"])) {
                        
                        $text = "";
                        foreach($datosCicloYSiembra["ciclo"] as $key => $value) {
                            
                            switch($key) {
                                case "anual":
                                    $text .= "anual";

                                    if(count($datosCicloYSiembra["ciclo"]) > 1){
                                        $text .= ";";
                                    }

                                    break;
                                case "bianual":
                                    $text .= "bianual";

                                    if(count($datosCicloYSiembra["ciclo"]) > 1){
                                        $text .= ";";
                                    }

                                    break;
                                case "perenne":
                                    $text .= "perenne";
                                    break;
                                default:
                                    break;
                            }
                        }

                        $cicloYSiembra->setCiclo($text);
                    }

                    //meses
                    if(isset($datosCicloYSiembra["meses"]) && !empty($datosCicloYSiembra["meses"])) {
                        foreach($datosCicloYSiembra["meses"] as $key => $value) {
                            switch($key) {
                                case "ene":
                                    $cicloYSiembra->setEnero($value);
                                    break;
                                case "feb":
                                    $cicloYSiembra->setFebrero($value);
                                    break;
                                case "mar":
                                    $cicloYSiembra->setMarzo($value);
                                    break;
                                case "abr":
                                    $cicloYSiembra->setAbril($value);
                                    break;
                                case "may":
                                    $cicloYSiembra->setMayo($value);
                                    break;
                                case "jun":
                                    $cicloYSiembra->setJunio($value);
                                    break;
                                case "jul":
                                    $cicloYSiembra->setJulio($value);
                                    break;
                                case "ago":
                                    $cicloYSiembra->setAgosto($value);
                                    break;
                                case "sep":
                                    $cicloYSiembra->setSeptiembre($value);
                                    break;
                                case "oct":
                                    $cicloYSiembra->setOctubre($value);
                                    break;
                                case "nov":
                                    $cicloYSiembra->setNoviembre($value);
                                    break;
                                case "dic":
                                    $cicloYSiembra->setDiciembre($value);
                                    break;
                                default:
                                    break;
                            }
                        }
                    }

                    if(isset($datosCicloYSiembra["altitud"]) && !empty($datosCicloYSiembra["altitud"])) {
                        $cicloYSiembra->setAltitud($datosCicloYSiembra["altitud"]);
                    }

                    if(isset($datosCicloYSiembra["zona"]) && !empty($datosCicloYSiembra["zona"])) {
                        $cicloYSiembra->setZona($datosCicloYSiembra["zona"]);
                    }

                    $cicloYSiembra->setVariedad($variedad);

                    $entityManager = $this->getDoctrine()->getManager();
                    $entityManager->persist($cicloYSiembra);
                    $entityManager->flush();
                }
            }

            $response = new Response();
            $response->setContent(json_encode([
                'idVariedad' => $idVariedad,
            ]));
            $response->headers->set('Content-Type', 'application/json');

            return $response;
        }

        $text = 'Nueva Variedad';

        return $this->renderForm('variedad/new.html.twig', [
            'variedad' => $variedad,
            'form' => $form,
            'text_form' => $text,
        ]);
    }

    /**
     * @Route("/getUsos", name="entrada_getUsos", methods={"POST"})
     */
    public function getUsos(Request $request): Response
    {
        $idVariedad = $request->request->get('idVariedad');
        
        $variedad = $this->getDoctrine()
            ->getRepository(Variedad::class)
            ->find($idVariedad);

        $usos = null;
        foreach($variedad->getUsoVariedads()->getValues() as $usoVariedad){
            $usos[$usoVariedad->getUso()->getUso()][] = $usoVariedad->getUso()->getId();
        }

        $response = new Response();
        $response->setContent(json_encode([
            'usos' => $usos,
        ]));
        $response->headers->set('Content-Type', 'application/json');

        return $response;  
    }

    /**
     * @Route("/getCicloYSiembra", name="entrada_getCicloYSiembra", methods={"POST"})
     */
    public function getCicloYSiembra(Request $request): Response
    {
        $idVariedad = $request->request->get('idVariedad');
        
        $variedad = $this->getDoctrine()
            ->getRepository(Variedad::class)
            ->find($idVariedad);

        $arrayCicloYSiembra = null;
        foreach($variedad->getCicloYSiembras()->getValues() as $cicloYSiembra){
            $arrayCicloYSiembra[$cicloYSiembra->getId()]['ciclo'] = $cicloYSiembra->getCiclo();
            $arrayCicloYSiembra[$cicloYSiembra->getId()]['altitud'] = $cicloYSiembra->getAltitud();
            $arrayCicloYSiembra[$cicloYSiembra->getId()]['zona'] = $cicloYSiembra->getZona();

            //meses
            if($cicloYSiembra->getEnero()) {
                $arrayCicloYSiembra[$cicloYSiembra->getId()]['meses'][] = 'ene';
            }
            
            if($cicloYSiembra->getFebrero()) {
                $arrayCicloYSiembra[$cicloYSiembra->getId()]['meses'][] = 'feb';
            }

            if($cicloYSiembra->getMarzo()) {
                $arrayCicloYSiembra[$cicloYSiembra->getId()]['meses'][] = 'mar';
            }

            if($cicloYSiembra->getAbril()) {
                $arrayCicloYSiembra[$cicloYSiembra->getId()]['meses'][] = 'abr';
            }

            if($cicloYSiembra->getMayo()) {
                $arrayCicloYSiembra[$cicloYSiembra->getId()]['meses'][] = 'may';
            }

            if($cicloYSiembra->getJunio()) {
                $arrayCicloYSiembra[$cicloYSiembra->getId()]['meses'][] = 'jun';
            }

            if($cicloYSiembra->getJulio()) {
                $arrayCicloYSiembra[$cicloYSiembra->getId()]['meses'][] = 'jul';
            }

            if($cicloYSiembra->getAgosto()) {
                $arrayCicloYSiembra[$cicloYSiembra->getId()]['meses'][] = 'ago';
            }

            if($cicloYSiembra->getSeptiembre()) {
                $arrayCicloYSiembra[$cicloYSiembra->getId()]['meses'][] = 'sep';
            }

            if($cicloYSiembra->getOctubre()) {
                $arrayCicloYSiembra[$cicloYSiembra->getId()]['meses'][] = 'oct';
            }

            if($cicloYSiembra->getNoviembre()) {
                $arrayCicloYSiembra[$cicloYSiembra->getId()]['meses'][] = 'nov';
            }

            if($cicloYSiembra->getDiciembre()) {
                $arrayCicloYSiembra[$cicloYSiembra->getId()]['meses'][] = 'dic';
            }
        }

        $response = new Response();
        $response->setContent(json_encode([
            'ArrayCicloYSiembra' => $arrayCicloYSiembra,
        ]));
        $response->headers->set('Content-Type', 'application/json');

        return $response;  
    }

    /**
     * @Route("/{id}", name="variedad_show", methods={"GET"})
     */
    public function show(Variedad $variedad): Response
    {

        return $this->render('variedad/show.html.twig', [
            'variedad' => $variedad,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="variedad_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Variedad $variedad): Response
    {
        $form = $this->createForm(Variedad1Type::class, $variedad, [
            'attr' => ['class' => 'formVariedadUpdate' ]
        ]);
        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            $datos = $request->request->get('variedad1');

            $entero = ['diasSemillero', 'viabilidadMin', 'viabilidadMax', 'cicloCultivo'];
            $decimal = ['marcoA', 'marcoB', 'densidad'];
            $entity = ['especie'];
            $usos = ['usoAlimenHumana', 'usoAlimenAnimal', 'usoMedicinales', 'usoVeterinarios', 'usoToxicNocivo', 'usoCombustible', 'usoConstruccion', 'usoArtesania', 'usoMedioambientales', 'usoOrnamentales', 'usoSociales'];
            
            foreach($entero as $value){
                if($datos[$value] == "" || empty($datos[$value])){
                    $datos[$value] = 0;
                }
            }

            foreach($decimal as $value){
                if($datos[$value] == "" || empty($datos[$value])){
                    $datos[$value] = 0.000;
                }
            }

            foreach($entity as $value){
                if(!empty($datos[$value])){
                    $idTaxon = $this->getDoctrine()
                        ->getRepository(Taxon::class)
                        ->findId($datos['especie']); //Busca por el nombre de la especie, sin tener encuenta genere ni familia

                    $taxon = $this->getDoctrine()
                        ->getRepository(Taxon::class)
                        ->find($idTaxon[0]['id']);

                    $variedad->setEspecie($taxon);
                }
            }

            $variedad->setNombreComun($datos['nombreComun']);
            $variedad->setNombreLocal($datos['nombreLocal']);
            $variedad->setBreveDescrPlantaCultivo($datos['breveDescrPlantaCultivo']);
            $variedad->setDescripcion($datos['descripcion']);
            $variedad->setTipoSiembra($datos['tipoSiembra']);
            $variedad->setDiasSemillero($datos['diasSemillero']);
            $variedad->setMarcoA($datos['marcoA']);
            $variedad->setMarcoB($datos['marcoB']);
            $variedad->setDensidad($datos['densidad']);
            $variedad->setCicloCultivo($datos['cicloCultivo']);
            $variedad->setPolinizacion($datos['polinizacion']);
            $variedad->setViabilidadMin($datos['viabilidadMin']);
            $variedad->setViabilidadMax($datos['viabilidadMax']);
            $variedad->setConocimientosTradicionales($datos['conocimientosTradicionales']);
            $variedad->setCmPlanta($datos['cmPlanta']);
            $variedad->setCmFlor($datos['cmFlor']);
            $variedad->setCmFruto($datos['cmFruto']);
            $variedad->setCmSemilla($datos['cmSemilla']);
            $variedad->setCArgonomicas($datos['cArgonomicas']);
            $variedad->setCOrganolepticas($datos['cOrganolepticas']);
            $variedad->setPropagacion($datos['propagacion']);
            $variedad->setOtros($datos['otros']);
            $variedad->setObservaciones($datos['observaciones']);


            // Relación UsoVariedad
            
            $arrayUsoVariedads = $variedad->getUsoVariedads()->getValues();
            $arrayIdUsoVariedades = [];
            $idsUsoVariedadsSinRelacion = [];
            $arrayIdUsos = [];

            //Guardamos los IDs de UsoVariedad relacionadas con esta Variedad
            foreach ($arrayUsoVariedads as $usoVariedad){
                $arrayIdUsoVariedades[] = $usoVariedad->getUso()->getId();
            }
            
            foreach ($usos as $value) {
                if(!empty($datos[$value])){
                    
                    if(!empty($arrayUsoVariedads)){

                        //Comprobar si existe ya una relación
                        foreach ($datos[$value] as $id) {
                            if(!in_array($id, $arrayIdUsoVariedades)) {
                                $idsUsoVariedadsSinRelacion[] = $id;
                            }

                            $arrayIdUsos[] = intval($id);
                        }
                    } else {
                        //Si en la variedad no existen usos relacionados
                        foreach ($datos[$value] as $id) {
                            $idsUsoVariedadsSinRelacion[] = $id;
                        }
                    }
                }
                
            }
            
            //Creamos la relación
            foreach($idsUsoVariedadsSinRelacion as $id){

                $uso = $this->getDoctrine()
                    ->getRepository(Uso::class)
                    ->find($id);

                $usoVariedad = new UsoVariedad;
                $usoVariedad->setVariedad($variedad);
                $usoVariedad->setUso($uso);

                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($usoVariedad);
                $entityManager->flush();

                $arrayIdUsoVariedades[] = $id;
            }

            //Comprobar que IDs se desmarcaron
            foreach ($arrayIdUsoVariedades as $id) {
                if(!in_array($id, $arrayIdUsos)) {

                    $uso = $this->getDoctrine()
                        ->getRepository(Uso::class)
                        ->find($id);

                    $entityManager = $this->getDoctrine()->getManager();
                    $entityManager->remove($uso);
                    $entityManager->flush();
                }
            }

            $this->getDoctrine()->getManager()->flush();

            $datosCiclosYSiembras = $request->request->get('ciclo_y_siembra');
            $meses = ['ene', 'feb', 'mar', 'abr', 'may', 'jun', 'jul', 'ago', 'sep', 'oct', 'nov', 'dic'];
            
            if(isset($datosCiclosYSiembras) && !empty($datosCiclosYSiembras)) {
                foreach($datosCiclosYSiembras as $key => $datosCicloYSiembra){
                    $marcado = [];

                    $registro = $this->getDoctrine()
                        ->getRepository(CicloYSiembra::class)
                        ->find($key);


                    // anual, bianual y perenne | Multiseleccion
                    if(isset($datosCicloYSiembra["ciclo"]) && !empty($datosCicloYSiembra["ciclo"])) {
                        
                        $text = "";
                        foreach($datosCicloYSiembra["ciclo"] as $key => $value) {
                            
                            switch($key) {
                                case "anual":
                                    $text .= "anual";

                                    if(count($datosCicloYSiembra["ciclo"]) > 1){
                                        $text .= ";";
                                    }

                                    break;
                                case "bianual":
                                    $text .= "bianual";

                                    if(count($datosCicloYSiembra["ciclo"]) > 1){
                                        $text .= ";";
                                    }

                                    break;
                                case "perenne":
                                    $text .= "perenne";
                                    break;
                                default:
                                    break;
                            }
                        }
                        $registro->setCiclo($text);
                    }

                    //meses
                    if(isset($datosCicloYSiembra["meses"]) && !empty($datosCicloYSiembra["meses"])) {

                        foreach($datosCicloYSiembra["meses"] as $key => $value) {

                            //marcar
                            switch($key) {
                                case "ene":
                                    $registro->setEnero($value);
                                    $marcado[] = $key;
                                    break;
                                case "feb":
                                    $registro->setFebrero($value);
                                    $marcado[] = $key;
                                    break;
                                case "mar":
                                    $registro->setMarzo($value);
                                    $marcado[] = $key;
                                    break;
                                case "abr":
                                    $registro->setAbril($value);
                                    $marcado[] = $key;
                                    break;
                                case "may":
                                    $registro->setMayo($value);
                                    $marcado[] = $key;
                                    break;
                                case "jun":
                                    $registro->setJunio($value);
                                    $marcado[] = $key;
                                    break;
                                case "jul":
                                    $registro->setJulio($value);
                                    $marcado[] = $key;
                                    break;
                                case "ago":
                                    $registro->setAgosto($value);
                                    $marcado[] = $key;
                                    break;
                                case "sep":
                                    $registro->setSeptiembre($value);
                                    $marcado[] = $key;
                                    break;
                                case "oct":
                                    $registro->setOctubre($value);
                                    $marcado[] = $key;
                                    break;
                                case "nov":
                                    $registro->setNoviembre($value);
                                    $marcado[] = $key;
                                    break;
                                case "dic":
                                    $registro->setDiciembre($value);
                                    $marcado[] = $key;
                                    break;
                                default:
                                    break;
                            }
                            
                            //desmarcar
                            foreach($meses as $mes){
                                if(!in_array($mes, $marcado)){
                                    switch($mes){
                                        case "ene":
                                            $registro->setEnero(null);
                                            break;
                                        case "feb":
                                            $registro->setFebrero(null);
                                            break;
                                        case "mar":
                                            $registro->setMarzo(null);
                                            break;
                                        case "abr":
                                            $registro->setAbril(null);
                                            break;
                                        case "may":
                                            $registro->setMayo(null);
                                            break;
                                        case "jun":
                                            $registro->setJunio(null);
                                            break;
                                        case "jul":
                                            $registro->setJulio(null);
                                            break;
                                        case "ago":
                                            $registro->setAgosto(null);
                                            break;
                                        case "sep":
                                            $registro->setSeptiembre(null);
                                            break;
                                        case "oct":
                                            $registro->setOctubre(null);
                                            break;
                                        case "nov":
                                            $registro->setNoviembre(null);
                                            break;
                                        case "dic":
                                            $registro->setDiciembre(null);
                                            break;
                                        default:
                                            break;
                                    }
                                }
                            }
                        }
                    }

                    //altitud
                    if(isset($datosCicloYSiembra["altitud"]) && !empty($datosCicloYSiembra["altitud"])) {
                        $registro->setAltitud($datosCicloYSiembra["altitud"]);
                    }

                    //zona
                    if(isset($datosCicloYSiembra["zona"]) && !empty($datosCicloYSiembra["zona"])) {
                        $registro->setZona($datosCicloYSiembra["zona"]);
                    }

                    $entityManager = $this->getDoctrine()->getManager();
                    $entityManager->persist($registro);
                    $entityManager->flush();
                }
            }

            return $this->redirectToRoute('variedad_index', [], Response::HTTP_SEE_OTHER);
        }

        $text = 'Editar Variedad';

        $idVariedad = $request->get('id');
        
        $arrayUsos = [];
        $arrayUsosVariedad = $variedad->getUsoVariedads()->getValues();
        foreach ($arrayUsosVariedad as $usoVariedad) {
            $arrayUsos[$usoVariedad->getUso()->getUso()] = $usoVariedad->getUso()->getTipo();
        }

        return $this->renderForm('variedad/edit.html.twig', [
            'idVariedad' => $idVariedad,
            'usos' => $arrayUsos,
            'variedad' => $variedad,
            'form' => $form,
            'text_form' => $text,
        ]);
    }

    /**
     * @Route("/{id}/variedad/img", name="variedad_img", methods={"GET"})
     */
    public function variedadImg(Request $request): Response
    {
        $imagen = new Imagen();
        $form = $this->createForm(ImagenType::class, $imagen, [
            'attr' => ['class' => 'formImagen' ]
        ]);
        $form->handleRequest($request);

        $imagenSelect = new ImagenSeleccionada();
        $form2 = $this->createForm(ImagenSeleccionadaType::class, $imagenSelect, [
            'attr' => ['class' => 'formImagenSelect' ]
        ]);
        $form2->handleRequest($request);

        $idVariedad = $request->get('id');

        $text = 'Nueva Imagen';

        return $this->renderForm('imagen/new.html.twig', [
            'imagen' => $imagen,
            'imagenSelect' => $imagenSelect,
            'form' => $form,
            'form2' => $form2,
            'text_form' => $text,
            'idVariedad' => $idVariedad,
        ]);
    }
    
    /**
     * @Route("/{id}", name="variedad_delete", methods={"POST"})
     */
    public function delete(Request $request, Variedad $variedad): Response
    {
        if ($this->isCsrfTokenValid('delete'.$variedad->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($variedad);
            $entityManager->flush();
        }

        return $this->redirectToRoute('variedad_index', [], Response::HTTP_SEE_OTHER);
    }
}
