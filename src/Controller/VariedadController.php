<?php

namespace App\Controller;

use App\Entity\CicloYSiembra;
use App\Entity\Envase;
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
            
        $cicloysiembra = null;
        $arrayCicloysiembra = null;

        foreach($variedadesDB as $variedadDB){
            //Ciclo y Siembra de la variedad
            if(!empty($variedadDB->getCicloYSiembras()->getValues())){
                foreach($variedadDB->getCicloYSiembras()->getValues() as $cicloysiembra){
                    $arrayCicloysiembra[$variedadDB->getId()][$cicloysiembra->getId()]['altitud'] = $cicloysiembra->getAltitud();
                    $arrayCicloysiembra[$variedadDB->getId()][$cicloysiembra->getId()]['zona'] = $cicloysiembra->getZona();
    
                    if(!empty($cicloysiembra->getCiclo())){
                        $texto = "";
                        $ciclos = explode(";", $cicloysiembra->getCiclo());
    
                        for($i = 0; $i < count($ciclos); $i++){
    
                            if($i > 0 && count($ciclos) > 1 && $ciclos[$i] != ""){
                                $texto .= "-";
                            }
                            $texto .= $ciclos[$i];
                        }
    
                        $arrayCicloysiembra[$variedadDB->getId()][$cicloysiembra->getId()]['ciclo'] = $texto;
                    }
                    
                    $meses = [];
                    if($cicloysiembra->getEnero() != null){
                        $meses[] = "Enero";
                    }
                    if($cicloysiembra->getFebrero() != null){
                        $meses[] = "Febrero";
                    }
                    if($cicloysiembra->getMarzo() != null){
                        $meses[] = "Marzo";
                    }
                    if($cicloysiembra->getAbril() != null){
                        $meses[] = "Abril";
                    }
                    if($cicloysiembra->getMayo() != null){
                        $meses[] = "Mayo";
                    }
                    if($cicloysiembra->getJunio() != null){
                        $meses[] = "Junio";
                    }
                    if($cicloysiembra->getJulio() != null){
                        $meses[] = "Julio";
                    }
                    if($cicloysiembra->getAgosto() != null){
                        $meses[] = "Agosto";
                    }
                    if($cicloysiembra->getSeptiembre() != null){
                        $meses[] = "Septiembre";
                    }
                    if($cicloysiembra->getOctubre() != null){
                        $meses[] = "Octubre";
                    }
                    if($cicloysiembra->getNoviembre() != null){
                        $meses[] = "Noviembre";
                    }
                    if($cicloysiembra->getDiciembre() != null){
                        $meses[] = "Diciembre";
                    }
                    
                    if(!empty($meses)){
                        $texto = "";
    
                        for($i = 0; $i < count($meses); $i++){
    
                            if($i > 0 && count($meses) > 1 && $meses[$i] != ""){
                                $texto .= "-";
                            }
                            $texto .= $meses[$i];
                        }
    
                        $arrayCicloysiembra[$variedadDB->getId()][$cicloysiembra->getId()]['meses'] = $texto;
                    }
                }
            } else {
                $arrayCicloysiembra[$variedadDB->getId()][0]['altitud'] = "";
                $arrayCicloysiembra[$variedadDB->getId()][0]['zona'] = "";
                $arrayCicloysiembra[$variedadDB->getId()][0]['ciclo'] = "";
                $arrayCicloysiembra[$variedadDB->getId()][0]['meses'] = "";
            }
            
        }

        return $this->render('variedad/index.html.twig', [
            'variedades' => $variedadesDB,
            'cicloysiembra' => $arrayCicloysiembra,
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

            if(isset($datos["codigo"]) && !empty($datos["codigo"])) {
                
                $variedad2 = $this->getDoctrine()
                    ->getRepository(Variedad::class)
                    ->findCodigo($datos["codigo"]);

                if($variedad2 == null){
                    $variedad->setCodigo($datos["codigo"]);
                } else {
                    $variedades = $this->getDoctrine()
                    ->getRepository(Variedad::class)
                    ->findAll();

                    $codigos = null;
                    if(!empty($variedades)){
                        foreach($variedades as $variedadCodigo){
                            $codigos[] = $variedadCodigo->getCodigo();
                        }

                        $codigo = max($codigos) + 1;
                    } else {
                        $codigo = 1;
                    }
                    
                    $variedad->setCodigo($codigo);
                }
            } else if (empty($datos["codigo"])) {
                $variedades = $this->getDoctrine()
                    ->getRepository(Variedad::class)
                    ->findAll();

                $codigos = null;
                if(!empty($variedades)){
                    foreach($variedades as $variedadCodigo){
                        $codigos[] = $variedadCodigo->getCodigo();
                    }

                    $codigo = max($codigos) + 1;
                } else {
                    $codigo = 1;
                }
                
                $variedad->setCodigo($codigo);
            }

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

                        if(preg_match('/Otro uso/', $uso->getTipo())) { 
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
            $usos[$usoVariedad->getUso()->getUso()]['id'][] = $usoVariedad->getUso()->getId();
            
            if(!empty($usoVariedad->getDescripcion())) {
                $usos[$usoVariedad->getUso()->getUso()]['descripcion'] = $usoVariedad->getDescripcion();
            }
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

        $cicloysiembra = $this->getDoctrine()
            ->getRepository(CicloYSiembra::class)
            ->findAll();

        $ultimoId = null;
        if(!empty($cicloysiembra)){
            $ultimoId = $cicloysiembra[count($cicloysiembra)-1]->getId();
        }
        
        $response = new Response();
        $response->setContent(json_encode([
            'ArrayCicloYSiembra' => $arrayCicloYSiembra,
            'ultimoId'  =>  $ultimoId,
        ]));
        $response->headers->set('Content-Type', 'application/json');

        return $response;  
    }

    /**
     * @Route("/findCodigo", name="variedad_codigo", methods={"POST"})
     */
    public function alertaCodigo(Request $request): Response
    {
        $error = null;
        $codigo = $request->request->get('codigo');
        $idVariedad = $request->request->get('variedadID')[0];

        if(!empty($codigo)) {
            if($codigo != $idVariedad) {
                $qb = $this->getDoctrine()
                    ->getRepository(Variedad::class)
                    ->createQueryBuilder('v')
                        ->where('v.codigo LIKE :busqueda')
                        ->setParameter('busqueda', '%'.$codigo.'%');
                
                $variedadDB = $qb->getQuery()->execute();

                if(count($variedadDB) >= 1) {
                    $error = 'Existe una variedad con este código, prueba con otro código';
                }
            }
        }

        $response = new Response();
        $response->setContent(json_encode([
            'error' => $error,
        ]));
        $response->headers->set('Content-Type', 'application/json');

        return $response; 
    }

    /**
     * @Route("/getEspecies", name="taxon_getEspecies", methods={"POST"})
     */
    public function getEspecie(Request $request): Response
    {
        // Consulta Taxon Tipo "ESPECIES", con rango en el nombre de la A-M, ordenado ASC
        $taxons = $this->getDoctrine()
            ->getRepository(Taxon::class)
            ->whereTipo("SPECIES", "A", "B");

        //dump($taxons[1]); exit;

        $nombreGenero = NULL;
        $nombreFamilia = NULL;
        $options = [];

        foreach($taxons as $taxon) {
            $value = $taxon->getId();
            $nombre = $taxon->getNombre();
            $genero = $taxon->getPadre();

            if(!empty($genero)) {
                $nombreGenero = $genero->getNombre();
                $familia = $genero->getPadre();

                if(!empty($familia)) {
                    $nombreFamilia = $familia->getNombre();
                }
            }

            $options[$value] = $nombre;
            if(!empty($nombreGenero)) {
                $options[$value] .= " - " . $nombreGenero;

                if(!empty($nombreFamilia)) {
                    $options[$value] .= " - " . $nombreFamilia;
                }
            }
        }

        $response = new Response();
        $response->setContent(json_encode([
            'especies' => $options,
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
        $taxon = $variedad->getEspecie();

        $form = $this->createForm(Variedad1Type::class, $variedad, [
            'attr' => ['class' => 'formVariedadUpdate' ]
        ]);
        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            $datos = $request->request->get('variedad1');

            if(isset($datos["codigo"]) && empty($datos["codigo"])) {
                $variedades = $this->getDoctrine()
                    ->getRepository(Variedad::class)
                    ->findAll();

                $codigos = null;
                if(!empty($variedades)){
                    foreach($variedades as $variedadCodigo){
                        $codigos[] = $variedadCodigo->getCodigo();
                    }

                    $codigo = max($codigos) + 1;
                }
                
                $variedad->setCodigo($codigo);
            }

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
                        foreach ($datos[$value] as $id) {
                            $idsUsoVariedadsSinRelacion[] = $id;
                        }
                        $arrayIdUsos[] = intval($id);
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

                if(preg_match('/Otro uso/', $uso->getTipo())) { 
                    for($i = 0; $i < count($descripcionUsos); $i++) {
                        if( isset($datos[$descripcionUsos[$i]]) ) {
                            dump($descripcionUsos[$i]);
                            $usoVariedad->setDescripcion($datos[$descripcionUsos[$i]]);
                        }
                    }
                }

                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($usoVariedad);
                $entityManager->flush();

                $arrayIdUsoVariedades[] = $id;
            }

            //Comprobar que IDs se desmarcaron
            foreach ($arrayIdUsoVariedades as $id) {
                if(!in_array($id, $arrayIdUsos)) {

                    $idUsoVariedad = $this->getDoctrine()
                        ->getRepository(UsoVariedad::class)
                        ->findUsoVareidad($id, $variedad->getId());


                    //Obtenemos el registro y lo eliminamos
                    $usoVariedad = $this->getDoctrine()
                        ->getRepository(UsoVariedad::class)
                        ->find($idUsoVariedad[0]['id']);

                    $entityManager = $this->getDoctrine()->getManager();
                    $entityManager->remove($usoVariedad);
                    $entityManager->flush();
                }
            }

            //Editar descripcion Otro usos
            foreach($arrayIdUsos as $idUso){

                $uso = $this->getDoctrine()
                    ->getRepository(Uso::class)
                    ->find($idUso);

                if(preg_match('/Otro uso/', $uso->getTipo())) {

                    $idUsoVariedad = $this->getDoctrine()
                        ->getRepository(UsoVariedad::class)
                        ->findUsoVareidad($idUso, $variedad->getId());
                    
                    $usoVariedad = $this->getDoctrine()
                        ->getRepository(UsoVariedad::class)
                        ->find($idUsoVariedad[0]['id']);

                    for($i = 0; $i < count($descripcionUsos); $i++) {
                        if(isset($datos[$descripcionUsos[$i]]) && !empty($datos[$descripcionUsos[$i]])){
                            $usoVariedad->setDescripcion($datos[$descripcionUsos[$i]]);
                        }
                    }

                    $entityManager = $this->getDoctrine()->getManager();
                    $entityManager->persist($usoVariedad);
                    $entityManager->flush();
                }
            }

            $this->getDoctrine()->getManager()->flush();

            $datosCiclosYSiembras = $request->request->get('ciclo_y_siembra');
            $meses = ['ene', 'feb', 'mar', 'abr', 'may', 'jun', 'jul', 'ago', 'sep', 'oct', 'nov', 'dic'];
            
            if(isset($datosCiclosYSiembras) && !empty($datosCiclosYSiembras)) {
                foreach($datosCiclosYSiembras as $key => $datosCicloYSiembra){
                    $marcado = [];

                    //
                    $registro = $this->getDoctrine()
                        ->getRepository(CicloYSiembra::class)
                        ->find($key);

                    // dump($registro);

                    $nuevo = false;
                    if($registro == null){
                        $registro = new CicloYSiembra;
                        $registro->setVariedad($variedad);
                        $nuevo = true;
                        dump($registro);
                    }

                    
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
                            
                            if($nuevo === false) {
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

        $text = 'Editar Variedad: ';
        $spanVariedad = $variedad->getNombreComun() . " | ID: " . $variedad->getCodigo();

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
            'span_form' => $spanVariedad,
        ]);
    }

    /**
     * @Route("/{id}/verVariedades", name="variedadEnvases_ver", methods={"GET"})
     */
    public function verVariedades(Request $request): Response
    {
        $id = $request->attributes->get('id');

        $envase = $this->getDoctrine()
            ->getRepository(Envase::class)
            ->find($id);

        $variedadesDB = $envase->getVariedads()->getValues();

        $cicloysiembra = null;
        $arrayCicloysiembra = null;

        foreach($variedadesDB as $variedadDB){

            //Ciclo y Siembra de la variedad
            if(!empty($variedadDB->getCicloYSiembras()->getValues())){
                foreach($variedadDB->getCicloYSiembras()->getValues() as $cicloysiembra){
                    $arrayCicloysiembra[$variedadDB->getId()][$cicloysiembra->getId()]['altitud'] = $cicloysiembra->getAltitud();
                    $arrayCicloysiembra[$variedadDB->getId()][$cicloysiembra->getId()]['zona'] = $cicloysiembra->getZona();
    
                    if(!empty($cicloysiembra->getCiclo())){
                        $texto = "";
                        $ciclos = explode(";", $cicloysiembra->getCiclo());
    
                        for($i = 0; $i < count($ciclos); $i++){
    
                            if($i > 0 && count($ciclos) > 1 && $ciclos[$i] != ""){
                                $texto .= "-";
                            }
                            $texto .= $ciclos[$i];
                        }
    
                        $arrayCicloysiembra[$variedadDB->getId()][$cicloysiembra->getId()]['ciclo'] = $texto;
                    }
                    
                    $meses = [];
                    if($cicloysiembra->getEnero() != null){
                        $meses[] = "Enero";
                    }
                    if($cicloysiembra->getFebrero() != null){
                        $meses[] = "Febrero";
                    }
                    if($cicloysiembra->getMarzo() != null){
                        $meses[] = "Marzo";
                    }
                    if($cicloysiembra->getAbril() != null){
                        $meses[] = "Abril";
                    }
                    if($cicloysiembra->getMayo() != null){
                        $meses[] = "Mayo";
                    }
                    if($cicloysiembra->getJunio() != null){
                        $meses[] = "Junio";
                    }
                    if($cicloysiembra->getJulio() != null){
                        $meses[] = "Julio";
                    }
                    if($cicloysiembra->getAgosto() != null){
                        $meses[] = "Agosto";
                    }
                    if($cicloysiembra->getSeptiembre() != null){
                        $meses[] = "Septiembre";
                    }
                    if($cicloysiembra->getOctubre() != null){
                        $meses[] = "Octubre";
                    }
                    if($cicloysiembra->getNoviembre() != null){
                        $meses[] = "Noviembre";
                    }
                    if($cicloysiembra->getDiciembre() != null){
                        $meses[] = "Diciembre";
                    }
                    
                    if(!empty($meses)){
                        $texto = "";
    
                        for($i = 0; $i < count($meses); $i++){
    
                            if($i > 0 && count($meses) > 1 && $meses[$i] != ""){
                                $texto .= "-";
                            }
                            $texto .= $meses[$i];
                        }
    
                        $arrayCicloysiembra[$variedadDB->getId()][$cicloysiembra->getId()]['meses'] = $texto;
                    }
                }
            } else {
                $arrayCicloysiembra[$variedadDB->getId()][0]['altitud'] = "";
                $arrayCicloysiembra[$variedadDB->getId()][0]['zona'] = "";
                $arrayCicloysiembra[$variedadDB->getId()][0]['ciclo'] = "";
                $arrayCicloysiembra[$variedadDB->getId()][0]['meses'] = "";
            }
            
        }

        return $this->render('variedad/index.html.twig', [
            'variedades' => $variedadesDB,
            'cicloysiembra' => $arrayCicloysiembra,

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
