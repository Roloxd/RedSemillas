<?php

namespace App\Controller;

use App\Entity\MetodoEmpleado;
// use App\Form\MetodoEmpleadoType;
use App\Repository\MetodoEmpleadoRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/metodoEmpleado")
 */
class MetodoEmpleadoController extends AbstractController
{
    /**
     * @Route("/all", name="metodoEmpleado_all", methods={"POST"})
     */
    public function all(MetodoEmpleadoRepository $metodoEmpleadoRepository): Response
    {
        $datos = [];
        $metodos = $metodoEmpleadoRepository->findAll();

        foreach($metodos as $metodo) {
            $datos[$metodo->getId()] = $metodo->getMetodo();        
        }

        $response = new Response();
        $response->setContent(json_encode($datos));
        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }

    // #[Route('/new', name: 'metodo_empleado_new', methods: ['GET','POST'])]
    // public function new(Request $request): Response
    // {
    //     $metodoEmpleado = new MetodoEmpleado();
    //     $form = $this->createForm(MetodoEmpleadoType::class, $metodoEmpleado);
    //     $form->handleRequest($request);

    //     if ($form->isSubmitted() && $form->isValid()) {
    //         $entityManager = $this->getDoctrine()->getManager();
    //         $entityManager->persist($metodoEmpleado);
    //         $entityManager->flush();

    //         return $this->redirectToRoute('metodo_empleado_index', [], Response::HTTP_SEE_OTHER);
    //     }

    //     return $this->renderForm('metodo_empleado/new.html.twig', [
    //         'metodo_empleado' => $metodoEmpleado,
    //         'form' => $form,
    //     ]);
    // }

    // #[Route('/{id}', name: 'metodo_empleado_show', methods: ['GET'])]
    // public function show(MetodoEmpleado $metodoEmpleado): Response
    // {
    //     return $this->render('metodo_empleado/show.html.twig', [
    //         'metodo_empleado' => $metodoEmpleado,
    //     ]);
    // }

    // #[Route('/{id}/edit', name: 'metodo_empleado_edit', methods: ['GET','POST'])]
    // public function edit(Request $request, MetodoEmpleado $metodoEmpleado): Response
    // {
    //     $form = $this->createForm(MetodoEmpleadoType::class, $metodoEmpleado);
    //     $form->handleRequest($request);

    //     if ($form->isSubmitted() && $form->isValid()) {
    //         $this->getDoctrine()->getManager()->flush();

    //         return $this->redirectToRoute('metodo_empleado_index', [], Response::HTTP_SEE_OTHER);
    //     }

    //     return $this->renderForm('metodo_empleado/edit.html.twig', [
    //         'metodo_empleado' => $metodoEmpleado,
    //         'form' => $form,
    //     ]);
    // }

    // #[Route('/{id}', name: 'metodo_empleado_delete', methods: ['POST'])]
    // public function delete(Request $request, MetodoEmpleado $metodoEmpleado): Response
    // {
    //     if ($this->isCsrfTokenValid('delete'.$metodoEmpleado->getId(), $request->request->get('_token'))) {
    //         $entityManager = $this->getDoctrine()->getManager();
    //         $entityManager->remove($metodoEmpleado);
    //         $entityManager->flush();
    //     }

    //     return $this->redirectToRoute('metodo_empleado_index', [], Response::HTTP_SEE_OTHER);
    // }
}
