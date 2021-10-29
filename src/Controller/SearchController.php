<?php

namespace App\Controller;

// use App\Entity\User\User;
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
        
        $variedades = null;
		$post = $request->request->get('search');//['search'];

		$titulo = 'Catálogo';

        if($post){    
			$titulo = 'Resultado de búsqueda';     
			/*$variedades = $this->getDoctrine()
            ->getRepository(Variedad::class)
            ->createQueryBuilder('o')
			   ->where('o.nombreLocal LIKE :busqueda')
			   ->orWhere('o.nombreComun LIKE :busqueda')
			   ->orWhere('o.nombreComun LIKE :busqueda')
			   ->orWhere('o.familia LIKE :busqueda')
			   ->orWhere('o.genero LIKE :busqueda')
			   ->orWhere('o.especie LIKE :busqueda')
			   ->orWhere('o.polinizacion LIKE :busqueda')
			   // ->andWhere('o.familia LIKE :familia')
			   ->setParameter('busqueda', '%'.$post['search'].'%')
			   // ->setParameter('familia', '%'.$post['familia'].'%')
			   ->getQuery()
			   ->getResult();
			 */
			$qb =  $this->getDoctrine()
            ->getRepository(Variedad::class)
            ->createQueryBuilder('o')
			   ->where('o.nombreLocal LIKE :busqueda')
			   ->orWhere('o.nombreComun LIKE :busqueda')
			//    ->orWhere('o.nombreComun LIKE :busqueda')
			   ->orWhere('o.familia LIKE :busqueda')
			   ->orWhere('o.genero LIKE :busqueda')
			   ->orWhere('o.especie LIKE :busqueda')
			   ->orWhere('o.polinizacion LIKE :busqueda')
			   ->setParameter('busqueda', '%'.$post['search'].'%');
			
			if($post['familia']){
				$qb->andWhere('o.familia LIKE :familia')
				->setParameter('familia', '%'.$post['familia'].'%');
			}
			
			if($post['especie']){
				$qb->andWhere('o.especie LIKE :especie')
				->setParameter('especie', '%'.$post['especie'].'%');
			}
			
			if($post['genero']){
				$qb->andWhere('o.genero LIKE :genero')
				->setParameter('genero', '%'.$post['genero'].'%');
			}

			if($post['polinizacion']){
				$qb->andWhere('o.polinizacion LIKE :polinizacion')
				->setParameter('polinizacion', '%'.$post['polinizacion'].'%');
			}

			if($post['nombreComun']){
				$qb->andWhere('o.nombreComun LIKE :nombreComun')
				->setParameter('nombreComun', '%'.$post['nombreComun'].'%');
			}
			
			$variedades = $qb->getQuery()
							->getResult();

			if(empty($variedades)){
				$titulo = 'No hay resultados';
			}

        }
       // dump($request->request->get('search')['query']); die;
        
        return $this->render('vista-catalogo.html.twig', [
            'variedades' => $variedades,
			'titulo' => $titulo,
        ]);
    }
	
	
    
}
