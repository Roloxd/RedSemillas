<?php

namespace App\Controller;

use App\Entity\Taxon;
use App\Entity\Variedad;
use App\Form\TaxonType;
use App\Repository\TaxonRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/taxon')]
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
            'taxa' => $taxonRepository->findAll(),
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
     * @Route("/familia", name="taxon_familia", methods={"POST"})
     */
    public function familia(): Response
    {

        $familia = $this->getDoctrine()
            ->getRepository(Taxon::class)
            ->findAllFamilia();

        $response = new Response();
        $response->setContent(json_encode([
            'familia' => $familia,
        ]));
        $response->headers->set('Content-Type', 'application/json');

        return $response;     
    }

    /**
     * @Route("/especie", name="taxon_especie", methods={"POST"})
     */
    public function especie(Request $request): Response
    {
        $idVariedad = $request->request->get('idVariedad');
        $array = [];
        $especieDefault = null;

        $especies = $this->getDoctrine()
            ->getRepository(Taxon::class)
            ->findAllEspecie();

        foreach($especies as $especie){
            $especieName = $especie['nombre'];
             //Añadir especie, familia, genero, y enviar a la  vista

            $genero = $this->getDoctrine()
                ->getRepository(Taxon::class)
                ->find($especie['padre']);

            $generoName = $genero->getNombre();

            $familia = $this->getDoctrine()
                ->getRepository(Taxon::class)
                ->find($genero->getPadre());

            $familiaName = $familia->getNombre();

            $array[$especieName] = $familiaName . " - " . $generoName . " - " . $especieName;
        }

        if($idVariedad){
            $variedad = $this->getDoctrine()
                ->getRepository(Variedad::class)
                ->find($idVariedad);

            if(!empty($variedad->getEspecie())){
                $especieDefault = $variedad->getEspecie()->getNombre();
            }
        }

        $response = new Response();
        $response->setContent(json_encode([
            'especies' => $array,
            'especieDefault' => $especieDefault,
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
