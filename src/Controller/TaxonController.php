<?php


namespace App\Controller;


use App\Entity\Taxon;
use App\Entity\Variedad;
use App\Form\TaxonType;
use stdClass;
use App\Repository\TaxonRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


/**
 * @Route("/admin/taxon")
 */
class TaxonController extends AbstractController
{
    /**
     * @Route("/", name="taxon_index", methods={"GET"})
     */
    public function index(TaxonRepository $taxonRepository): Response
    {   
        return $this->render('taxon/index.html.twig', [
            'taxa' => $taxonRepository -> findBy(
                array(),
                array("nombre" => "DESC"),
                10,
                0
            ),
        ]);
    }

    /**
     * @Route("/new", name="taxon_new", methods={"GET", "POST"})
     */
    public function new(Request $request): Response
    {
        $taxon = new Taxon();
        // $form = $this->createForm(TaxonType::class, $taxon);
        $form = $this->createForm(TaxonType::class, $taxon);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($taxon);
            $entityManager->flush();

            return $this->redirectToRoute('taxon_index', [], Response::HTTP_SEE_OTHER);
        }

        $text_form = 'Nuevo Taxon';

        return $this->renderForm('taxon/new.html.twig', [
            'taxon' => $taxon,
            'form' => $form,
            'text_form' => $text_form,
        ]);
    }

     /**
     * @Route("/wfo/post", name="taxon_post", methods={"GET","POST"})
     * @param Request $request
     * @return Response
    */
    public function getPagina (Request $request,TaxonRepository $taxonRepository) : Response
    {
        $data1 = $request->getContent();
        $data2 = json_decode($data1);
        // dump($data2);

        return $this->json(['pagina' => $data2 ]);
   
    }

    /**
     * @Route("/wfo", name="all_taxon", methods={"GET" , "POST"})
     */
    
     public function getAllTaxon($page = 1, TaxonRepository $taxonRepository): Response
     {

        $tamañoDePagina = 10;
        $datoInicial = ($page * $tamañoDePagina) - $tamañoDePagina;
        $datoFinal = $page * $tamañoDePagina;
        // $paginaActual = $this -> pagina;
        $args = [];

        $taxons = $taxonRepository -> findBy(
            array(),
            array("nombre" => "DESC"),
            10,
            0
        );
        
        foreach($taxons as $taxon){
            $object =  new stdClass();
            // $object -> id = $taxon -> getId();
            $object -> tipo = $taxon -> getTipo();
            $object -> nombre = $taxon -> getNombre();
            $object -> padre = $taxon -> getPadre();
            $object -> autoridad = $taxon -> getAutoridad();
            $object -> subtaxon  = $taxon -> getSubtaxon();
            $object -> autoridadSubtaxon  = $taxon -> getAutoridadSubtaxon();
            $object -> observaciones = $taxon -> getObservaciones();
            $object -> descripcion = $taxon -> getDescripcion();
            


            array_push($args,$object);
        }
        
        $response = new Response();
        $response->setContent(json_encode([
            'wfo' => $args,
        ]));

        $response->headers->set('Content-Type', 'application/json');

        return $response;

     }

    /**
     * @Route("/{id}", name="taxon_show", methods={"GET"})
     */
    public function show(Taxon $taxon): Response
    {
        return $this->render('taxon/show.html.twig', [
            'taxon' => $taxon,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="taxon_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Taxon $taxon): Response
    {
        $form = $this->createForm(TaxonType::class, $taxon);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('taxon_index', [], Response::HTTP_SEE_OTHER);
        }

        $text_form = 'Editar Taxon';

        return $this->renderForm('taxon/edit.html.twig', [
            'taxon' => $taxon,
            'form' => $form,
            'text_form' => $text_form,
        ]);
    }

    /**
     * @Route("/{id}", name="taxon_delete", methods={"POST"})
     */
    public function delete(Request $request, Taxon $taxon): Response
    {
        if ($this->isCsrfTokenValid('delete'.$taxon->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($taxon);
            $entityManager->flush();
        }

        return $this->redirectToRoute('taxon_index', [], Response::HTTP_SEE_OTHER);
    }
}
