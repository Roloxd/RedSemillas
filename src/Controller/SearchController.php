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
					->where('v.nombreLocal LIKE :busqueda')
					->orWhere('v.nombreComun LIKE :busqueda')
					->orWhere('v.polinizacion LIKE :busqueda')
					->setParameter('busqueda', '%'.$post['search'].'%');
			
			if(!empty($post['familia']) || !empty($post['especie']) || !empty($post['genero'])) {
				$qb->join('v.especie', 'e')
				->join('e.padre', 'g')
				->join('g.padre', 'f');

				if(!empty($post['familia'])) {
					$qb->andWhere('f.nombre LIKE :familia')
					->setParameter('familia', '%'.$post['familia'].'%');
				}
				if(!empty($post['especie'])){
					$qb->andWhere('e.nombre LIKE :especie')
					->setParameter('especie', '%'.$post['especie'].'%');
				}
				if(!empty($post['genero'])){
					$qb->andWhere('g.nombre LIKE :genero')
					->setParameter('genero', '%'.$post['genero'].'%');
				}
			}
			
			if(isset($post['polinizacion']) && !empty($post['polinizacion'])){
				$qb->andWhere('v.polinizacion LIKE :polinizacion')
				->setParameter('polinizacion', '%'.$post['polinizacion'].'%');
			}

			if(isset($post['nombreComun']) && !empty($post['nombreComun'])){
				$qb->andWhere('v.nombreComun LIKE :nombreComun')
				->setParameter('nombreComun', '%'.$post['nombreComun'].'%');
			}


			//Tipo Siembra
			if(isset($post['tipoSiembra']) && !empty($post['tipoSiembra']['directa'])){
				$qb->andWhere('v.tipoSiembra LIKE :tipoSiembra')
				->setParameter('tipoSiembra', 'Directa');
			}

			if(isset($post['tipoSiembra']) && !empty($post['tipoSiembra']['semillero'])){
				$qb->andWhere('v.tipoSiembra LIKE :tipoSiembra')
				->setParameter('tipoSiembra', 'Semillero');
			}

			if(isset($post['tipoSiembra']) && !empty($post['tipoSiembra']['voleo'])){
				$qb->andWhere('v.tipoSiembra LIKE :tipoSiembra')
				->setParameter('tipoSiembra', 'Voleo');
			}

			//Epoca Siembra
			if(isset($post['epocaSiembra'])) {
				$qb->join('v.cicloYSiembras', 'c');

				if(!empty($post['epocaSiembra']['ene'])){
					$qb->andWhere('c.enero LIKE :enero')
					->setParameter('enero', true);
				}
	
				if(!empty($post['epocaSiembra']['feb'])){
					$qb->andWhere('c.febrero LIKE :febrero')
					->setParameter('febrero', true);
				}
	
				if(!empty($post['epocaSiembra']['mar'])){
					$qb->andWhere('c.marzo LIKE :marzo')
					->setParameter('marzo', true);
				}
	
				if(!empty($post['epocaSiembra']['abr'])){
					$qb->andWhere('c.abril LIKE :abril')
					->setParameter('abril', true);
				}
	
				if(!empty($post['epocaSiembra']['may'])){
					$qb->andWhere('c.mayo LIKE :mayo')
					->setParameter('mayo', true);
				}
	
				if(!empty($post['epocaSiembra']['jun'])){
					$qb->andWhere('c.junio LIKE :junio')
					->setParameter('junio', true);
				}
	
				if(!empty($post['epocaSiembra']['jul'])){
					$qb->andWhere('c.julio LIKE :julio')
					->setParameter('julio', true);
				}
	
				if(!empty($post['epocaSiembra']['ago'])){
					$qb->andWhere('c.agosto LIKE :agosto')
					->setParameter('agosto', true);
				}
	
				if(!empty($post['epocaSiembra']['sep'])){
					$qb->andWhere('c.septiembre LIKE :septiembre')
					->setParameter('septiembre', true);
				}
	
				if(!empty($post['epocaSiembra']['oct'])){
					$qb->andWhere('c.octubre LIKE :octubre')
					->setParameter('octubre', true);
				}
	
				if(!empty($post['epocaSiembra']['nov'])){
					$qb->andWhere('c.noviembre LIKE :noviembre')
					->setParameter('noviembre', true);
				}
	
				if(!empty($post['epocaSiembra']['dic'])){
					$qb->andWhere('c.diciembre LIKE :diciembre')
					->setParameter('diciembre', true);
				}
			}
			
			$variedades = $qb->getQuery()->execute();

			if(empty($variedades) && !empty($post['search'])) {
				$qb = $this->getDoctrine()
				->getRepository(Variedad::class)
				->createQueryBuilder('v')
				->join('v.especie', 'e')
				->join('e.padre', 'g')
				->join('g.padre', 'f')
				->orWhere('e.nombre LIKE :busqueda') //Especie
				->orWhere('g.nombre LIKE :busqueda') //Genero
				->orWhere('f.nombre LIKE :busqueda') //Genero
				->setParameter('busqueda', '%'.$post['search'].'%');

				$variedades = $qb->getQuery()->execute();
			}

			if(empty($variedades)){
				$titulo = 'No hay resultados';
				$imagenes = null;
			}
        }

		if(!empty($variedades)){
			foreach($variedades as $variedadDB){
				if(!empty($variedadDB->getimagenSeleccionadas()->getValues())) {
					foreach($variedadDB->getimagenSeleccionadas()->getValues() as $imagenesDB) {
						//Si la imagen es principal
						if($imagenesDB->getImagen()->getPrincipal() === true){
							$imagenes[$variedadDB->getId()]['img'] = "/uploads/img/" . $imagenesDB->getImagen()->getUrl();
							$imagenes[$variedadDB->getId()]['autor'] = $imagenesDB->getImagen()->getCredito();
							break;
						} else {
							$imagenes[$variedadDB->getId()]['img'] = "/images/home_home_rgcs_impression.png";
							$imagenes[$variedadDB->getId()]['autor'] = "";
						}
					}
				} else {
					$imagenes[$variedadDB->getId()]['img'] = "/images/home_home_rgcs_impression.png";
					$imagenes[$variedadDB->getId()]['autor'] = "";
				}
			}
		}
		
        return $this->render('vista-catalogo.html.twig', [
            'variedades' => $variedades,
			'imagenes' => $imagenes,
			'titulo' => $titulo,
        ]);
    }
}

