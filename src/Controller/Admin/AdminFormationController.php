<?php

namespace App\Controller\Admin;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Repository\FormationRepository;
use App\Repository\BookingRepository;
use App\Form\FormationType;
use App\Form\BookingType;
use App\Entity\Formation;
use App\Entity\Booking;

/**
 * @Route("/admin/formation")
 */
class AdminFormationController extends AbstractController
{   
 
    /**
     * @Route("/", name="admin_formation_index", methods={"GET"})
     */
    public function index(FormationRepository $formationRepository): Response
    {
        return $this->render('admin/formation/index.html.twig', [
            'formations' => $formationRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="admin_formation_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $formation = new Formation();
          
        $form = $this->createForm(FormationType::class, $formation);
        $form->handleRequest($request);
       
        if ($form->isSubmitted() && $form->isValid()) { 
           $booking = new Booking();
          
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($formation);
            $entityManager->flush();

            return $this->redirectToRoute('admin_formation_index');
        }

        return $this->render('admin/formation/new.html.twig', [
            'formation' => $formation,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="admin_formation_show", methods={"GET"})
     */
    public function show(Formation $formation): Response
    {
        return $this->render('admin/formation/show.html.twig', [
            'formation' => $formation,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="admin_formation_edit", methods={"GET","POST"})
     * 
     */
    public function edit( $id, Request $request, Formation $formation, BookingRepository $bookingRepository): Response
    {   
        $em = $this->getDoctrine()->getManager();
     
        
        $form = $this->createForm(FormationType::class, $formation);
        $form->handleRequest($request);
       
        if ($form->isSubmitted() && $form->isValid()) {
            
            $em->persist($formation);
            $em->flush();

            return $this->redirectToRoute('admin_formation_index');
        }

        return $this->render('admin/formation/edit.html.twig', [
            'formation' => $formation,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="admin_formation_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Formation $formation): Response
    {
        if ($this->isCsrfTokenValid('delete'.$formation->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($formation);
            $entityManager->flush();
        }

        return $this->redirectToRoute('admin_formation_index');
    }

 
}
