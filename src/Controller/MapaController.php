<?php

namespace App\Controller;

use App\Repository\EntradaRepository;
use stdClass;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/mapa")
 */
class MapaController extends AbstractController
{
    /**
     * @Route("/", name="mapa_index", methods={"GET"})
     */
    public function index(): Response
    {
        return $this->render('mapa/index.html.twig');
    }

    /**
     * @Route("/entradas", name="mapa_entradas", methods={"GET"})
     */
    public function getAllEntradas(EntradaRepository $entradaRepository): Response
    {
        $args = [];
        // Almacenamos todoas las entradas y hacemos loop para almacenar en un objecto
        // los datos que nos interesan
        $entradas = $entradaRepository->findAll();
        foreach($entradas as $entrada) {

            // Se crea un nuevo objeto y se almacenan los valores de la entrada que nos interesan
            $object = new stdClass();
            $object->tipoDeEntrada = $entrada->getTipoEntrada();
            $object->cantidad = $entrada->getCantidad();
            $object->cantidadUnidades = $entrada->getCantidadUnidades();
            $object->fecha = $entrada->getFechaEntrada();
             
            // Array para variables, dando que puede haber más de un valor
            $variedades = [];
            $arrayNombreComun = [];
            $arrayNombreLocal = [];
            $arrayNombreCientifico = [];
            // Para acceder a variedads de cada entrada, tenemos  primero que conseguir el envase
            $envases = $entrada->getNumEnvase()->getValues();
            // Hago loop a través de los envases, ya que puede haber más de uno
            // y almaceno las variedads en el array 
            if(!empty($envases)){
            foreach($envases as $envase){
                    $variedades = $envase->getVariedads();
                // Loop a través de cada variedad para conseguir los valores que necesitamos
                // Se hace a través de envases ya que cada envase puede tener muchas variedades
                // aunque no es lo normal.
                foreach ($variedades as $variedad) {
                    array_push($arrayNombreComun,$variedad->getNombreComun());
                    array_push($arrayNombreLocal,$variedad->getNombreLocal());
                    array_push($arrayNombreCientifico,$variedad->getEspecie());
                } 
        
            }

            }
                    // Almaceno en el objeto los array de los nombres de cada variedad
                    $object -> nombreComun = $arrayNombreComun;
                    $object -> nombreLocal = $arrayNombreLocal;
                    $object -> nombreCientifico = $arrayNombreCientifico;
        
            // Mismo procedimiento pero con terrenos
            $terrenos = $entrada->getTerrenos()->getValues();
            if(!empty($terrenos)) {
                foreach($terrenos as $terreno) {
                    $object->localidad = $terreno->getLocalidad();
                    $object->municipio = $terreno->getMunicipio();
                    // Cada objeto creado lo almaceno en un array
                    array_push($args,$object);
                }
            }   
        }

        // Para ver los objetos creado /mapa/entradas
        $response = new Response();
        $response->setContent(json_encode([
            'entradas' => $args,
        ]));

        $response->headers->set('Content-Type', 'application/json');

        return $response;  
    }
    
}