<?php


namespace App\Controller;

use App\Entity\Taxon;
use App\Entity\Variedad;
use App\Entity\VariedadCopia;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin")
 */
class BackendController extends AbstractController
{
    /**
     * @Route("/", name="backend_index", methods={"GET"})
     */
    public function backend_index(): Response
    {
        return $this->render('backend/dashboard.html.twig');
    }

    /**
     * @Route("/addtaxon", name="backend_addtaxon", methods={"GET"})
     */
    public function addTaxon(): Response
    {
        $variedades = $this->getDoctrine()
            ->getRepository(VariedadCopia::class)
            ->findAllFamiliaGeneroEspecie();


        $familias = $this->getDoctrine()
            ->getRepository(Taxon::class)
            ->findFamilias();

        $arrayFamilias = [];

        foreach($familias as $familia){
            $arrayFamilias[] = $familia['nombre'];
        }

        foreach($variedades as $variedad){

            
            if(!in_array($variedad['familia'], $arrayFamilias) && !empty($variedad['familia'])){
                
                $newTaxon = new Taxon();
                $newTaxon->setTipo('Familia');
                $newTaxon->setNombre($variedad['familia']);

                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($newTaxon);
                $entityManager->flush();

                $idFamilia = $newTaxon->getId();
                $arrayFamilias[] = $variedad['familia'];

            } else if(!empty($variedad['familia'])) {

                $idTaxon = $this->getDoctrine()
                    ->getRepository(Taxon::class)
                    ->findId($variedad['familia']);

                $idFamilia = $idTaxon[0]['id'];
            }

            //Obtenemos los Generos de dicha Familia
            $resultados = $this->getDoctrine()
                ->getRepository(Taxon::class)
                ->findHijosFamilia($idFamilia);

            $generos = [];

            foreach($resultados as $resultado){
                $generos[] = $resultado['nombre'];
            }

            if(!in_array($variedad['genero'], $generos) && !empty($variedad['genero'])){
                $newTaxon = new Taxon();
                $newTaxon->setTipo('Genero');
                $newTaxon->setNombre($variedad['genero']);

                $newTaxon->setPadre($idFamilia);

                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($newTaxon);
                $entityManager->flush();

                $idGenero = $newTaxon->getId();
                $generos[] = $variedad['genero'];
                
            } else if(!empty($variedad['genero'])){
                $idTaxon = $this->getDoctrine()
                    ->getRepository(Taxon::class)
                    ->findId($variedad['genero']);

                $idGenero = $idTaxon[0]['id'];
            }

            //Obtenemos las especies de dicha Genero
            $resultados = $this->getDoctrine()
                ->getRepository(Taxon::class)
                ->findHijosGenero($idGenero);

            $especies = [];

            foreach($resultados as $resultado){
                $especies[] = $resultado['nombre'];
            }

            if(!in_array($variedad['especie'], $especies) && !empty($variedad['especie'])){

                $newTaxon = new Taxon();
                $newTaxon->setTipo('Especie');
                $newTaxon->setNombre($variedad['especie']);

                $newTaxon->setPadre($idGenero);

                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($newTaxon);
                $entityManager->flush();

                $variedadObjeto = $this->getDoctrine()
                        ->getRepository(Variedad::class)
                        ->find($variedad['id']);

                $variedadObjeto->setEspecie($newTaxon);

                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($variedadObjeto);
                $entityManager->flush();

                $especies[] = $variedad['especie'];

            } else if(!empty($variedad['especie'])){

                //Obtengo id
                $idTaxon = $this->getDoctrine()
                    ->getRepository(Taxon::class)
                    ->findId($variedad['especie']);

                //Obtengo el object de la especie en la tabla Taxon
                $taxon = $this->getDoctrine()
                    ->getRepository(Taxon::class)
                    ->find($idTaxon[0]['id']);

                if($taxon->getId() == 9){
                    dump($taxon); exit;
                }
                
                $variedadObjeto = $this->getDoctrine()
                        ->getRepository(Variedad::class)
                        ->find($variedad['id']);

                $variedadObjeto->setEspecie($taxon);

                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($variedadObjeto);
                $entityManager->flush();
            }
        }

        // $entityManager = $this->getDoctrine()->getManager();
        // $entityManager->persist($taxons);
        // $entityManager->flush();

        

        return $this->render('backend/dashboard.html.twig');
    }
}