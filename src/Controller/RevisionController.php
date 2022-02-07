<?php

namespace App\Controller;

use App\Entity\Germinacion;
use App\Entity\Revision;
use App\Form\RevisionType;
use App\Repository\RevisionRepository;
use DateTime;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/revision")
 */
class RevisionController extends AbstractController
{
    /**
     * @Route("/", name="revision_index", methods={"GET"})
     */
    public function index(RevisionRepository $revisionRepository): Response
    {
        return $this->render('revision/index.html.twig', [
            'revisions' => $revisionRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="revision_new", methods={"GET", "POST"})
     */
    public function new(Request $request): Response
    {
        $revision = new Revision();
        $form = $this->createForm(RevisionType::class, $revision);
        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            $datos = $request->request->get('revision');

            // Fecha final
            if( isset($datos['revision_finalizada']) && !empty($datos['revision_finalizada']) ){
                if($datos['revision_finalizada'] === "1") {
                    $revision->setFechaRevisionFinalizacion(new DateTime());
                } else {
                    $revision->setFechaRevisionFinalizacion(null);
                }
            }

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($revision);
            $entityManager->flush();

            return $this->redirectToRoute('revision_index', [], Response::HTTP_SEE_OTHER);
        }

        $text_form = "Nueva Revision";

        return $this->renderForm('revision/new.html.twig', [
            'revision' => $revision,
            'form' => $form,
            'text_form' => $text_form,
        ]);
    }

    /**
     * @Route("/{id}", name="revision_show", methods={"GET"})
     */
    public function show(Revision $revision): Response
    {
        return $this->render('revision/show.html.twig', [
            'revision' => $revision,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="revision_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Revision $revision): Response
    {
        $form = $this->createForm(RevisionType::class, $revision);
        $form->handleRequest($request);

        // Comprobar si existe fecha final, para marcar el checbox
        $fecha_final = $revision->getFechaRevisionFinalizacion();
        $checkboxMarcado = false;
        if(!empty($fecha_final)) {
            $checkboxMarcado = true;
        }

        // Obtener el ultimo registro asociado a Germinación
        $germinacion = $revision->getGerminacion();
        $revisionesDB = $germinacion->getRevisiones()->getValues();
        $revisionId = [];
        $actualizar = [];
        foreach($revisionesDB as $revisionDB) {
            $revisionId[] = $revisionDB->getId();
            $actualizar['temperaturas_max'][] = $revisionDB->getTemperaturaMax();
            $actualizar['temperaturas_min'][] = $revisionDB->getTemperaturaMin();
            $actualizar['humedades_max'][] = $revisionDB->getHumedadMax();
            $actualizar['humedades_min'][] = $revisionDB->getHumedadMin();
        }
        $ultimoRegistro = max($revisionId);

        if ($form->isSubmitted()) {
            $datos = $request->request->get('revision');

            // Fecha final
            if(empty($fecha_final)) {
                if( isset($datos['revision_finalizada']) && !empty($datos['revision_finalizada']) ){
                    if($datos['revision_finalizada'] === "1") {
                        $revision->setFechaRevisionFinalizacion(new DateTime());
                    }
                }
            }

            $this->getDoctrine()->getManager()->flush();

            // Actualizar Porcentajes
            if($revision->getId() === $ultimoRegistro) {
                $germinacion = GerminacionController::actualizarPorcentajes($germinacion, $revision);
            }

            // Actualizar Temperaturas y Humedades
            $germinacion = GerminacionController::actualizarTemperaturas($germinacion, $actualizar);

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($germinacion);
            $entityManager->flush();

            return $this->redirectToRoute('revision_ver', ['id' => $germinacion->getId()], Response::HTTP_SEE_OTHER);
        }

        $text_form = "Editar Revision";

        return $this->renderForm('revision/edit.html.twig', [
            'revision' => $revision,
            'form' => $form,
            'text_form' => $text_form,
            'checkboxMarcado' => $checkboxMarcado,
        ]);
    }

    /**
     * @Route("/{id}/ver", name="revision_ver", methods={"GET"})
     */
    public function ver(Request $request): Response
    {
        $id = $request->attributes->get('id');

        $germinacion = $this->getDoctrine()
            ->getRepository(Germinacion::class)
            ->find($id);

        $revisions = $germinacion->getRevisiones()->getValues();

        return $this->render('revision/index.html.twig', [
            'revisions' => $revisions,
        ]);
    }

    /**
     * @Route("/{id}", name="revision_delete", methods={"POST"})
     */
    public function delete(Request $request, Revision $revision): Response
    {
        if ($this->isCsrfTokenValid('delete'.$revision->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($revision);
            $entityManager->flush();
        }

        return $this->redirectToRoute('revision_index', [], Response::HTTP_SEE_OTHER);
    }
}
