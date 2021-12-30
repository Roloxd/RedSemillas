<?php

namespace App\Controller;

// use App\Entity\User\User;

use App\Entity\Taxon;
use App\Form\SearchType;

use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

use App\Repository\Passport\PassportEnvasesRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\VarDumper\VarDumper;

use App\Entity\Variedad;
use mysqli;
use Symfony\Component\Validator\Constraints\IsNull;

/**
 * @Route("/semillas", name="search.")
 */
class SearchController extends AbstractController
{
	/**
     * @Route("/", methods={"GET"})
     * @param PassportEnvasesRepository $passportEnvasesRepository
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function index(): Response
    {
        $search = new Search();
        
        return $this->render('search/index.html.twig', [
            'controller_name' => 'SearchController',
        ]);
    }
    
    
   public function searchBar(){
        
        $form = $this->createForm(SearchType::class, null, 
            ['action' => $this->generateUrl('search.handleSearch')]);
        
        return $this->render('forms/searchbar.html.twig', [
            'form' => $form->createView(),
        ]);
        
    }
    
    /**
    * @Route("/", name="handleSearch")
    * @param Request $request
    */
    public function handleSearch(Request $request){

		$post = $request->request->get('search');//['search'];

		$variedades = null;
		$especies = null;
		$familias = null;
		$generos = null;
		$subtaxons = null;
		$titulo = 'Catálogo';

        if($post){    
			$titulo = 'Resultado de búsqueda';     
			// $qb =  $this->getDoctrine()
            // ->getRepository(Variedad::class)
            // ->createQueryBuilder('o')
			//    ->where('o.nombreLocal LIKE :busqueda')
			//    ->orWhere('o.nombreComun LIKE :busqueda')
			// //    ->orWhere('o.nombreComun LIKE :busqueda')
			//    ->orWhere('o.familia LIKE :busqueda')
			//    ->orWhere('o.genero LIKE :busqueda')
			//    ->orWhere('o.especie LIKE :busqueda')
			//    ->orWhere('o.polinizacion LIKE :busqueda')
			//    ->setParameter('busqueda', '%'.$post['search'].'%');

			// $variedades = $this->getDoctrine()
			// 	->getRepository(Variedad::class)
			// 	->findSearch($post);

			// Search [Nombre Local/Comun o Polinizacion]
			$qb = $this->getDoctrine()
				->getRepository(Variedad::class)
				->createQueryBuilder('v')
				->join('v.especie', 'e')
				->join('e.padre', 'g')
				->join('g.padre', 'f')
					->where('v.nombreLocal LIKE :busqueda')
					->orWhere('v.nombreComun LIKE :busqueda')
					->orWhere('v.polinizacion LIKE :busqueda')
					->orWhere('e.nombre LIKE :busqueda') //Especie
					->orWhere('g.nombre LIKE :busqueda') //Genero
					->orWhere('f.nombre LIKE :busqueda') //Genero
					->setParameter('busqueda', '%'.$post['search'].'%');

			$variedades = $qb->getQuery()->execute();
			
			// if($post['familia']){
			// 	$qb->andWhere('o.familia LIKE :familia')
			// 	->setParameter('familia', '%'.$post['familia'].'%');
			// }
			
			// if($post['especie']){
			// 	$qb->andWhere('o.especie LIKE :especie')
			// 	->setParameter('especie', '%'.$post['especie'].'%');
			// }
			
			// if($post['genero']){
			// 	$qb->andWhere('o.genero LIKE :genero')
			// 	->setParameter('genero', '%'.$post['genero'].'%');
			// }

			// if($post['polinizacion']){
			// 	$qb->andWhere('o.polinizacion LIKE :polinizacion')
			// 	->setParameter('polinizacion', '%'.$post['polinizacion'].'%');
			// }

			// if($post['nombreComun']){
			// 	$qb->andWhere('o.nombreComun LIKE :nombreComun')
			// 	->setParameter('nombreComun', '%'.$post['nombreComun'].'%');
			//}
			
			// $variedades = $qb->getQuery()
			// 				->getResult();

			if(empty($variedades)){
				$titulo = 'No hay resultados';
			} else {
				foreach($variedades as $variedadDB) {
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

						$subtaxons[$variedadDB->getId()] = "";
					} else {
						$especies[$variedadDB->getId()] = "";
						$generos[$variedadDB->getId()] = "";
						$familias[$variedadDB->getId()] = "";
						$subtaxons[$variedadDB->getId()] = "";
					}
				}
			}
        }
        
        return $this->render('vista-catalogo.html.twig', [
            'variedades' => $variedades,
			'especies' => $especies,
			'generos' => $generos,
			'familias' => $familias,
			'subtaxons' => $subtaxons,
			'titulo' => $titulo,
        ]);
    }
}

