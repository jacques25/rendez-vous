<?php

namespace App\Controller\Admin;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Doctrine\Common\Collections\ArrayCollection;
use App\Repository\FormationRepository;
use App\Form\FormationType;

use App\Entity\User;
use App\Entity\Formation;


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
            'formations' => $formationRepository->findAll()
        ]);
    }

    /**
     * @Route("/new", name="admin_formation_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $formation = new Formation();
         $originalBooking= new ArrayCollection();
   
        foreach ($formation->getBooking() as $booking) {
            $originalBooking->add($booking);
        }
        $form = $this->createForm(FormationType::class, $formation);
        $form->handleRequest($request);
       
        if ($form->isSubmitted() && $form->isValid()) { 
            $referer =$request->getSession('referer');
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($formation);
            $entityManager->flush();

            return $this->redirectToRoute('admin_formation_index', [ 'refrerer' => $referer] );
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
    public function edit($id, Request $request, Formation $formation): Response
    {
        $em = $this->getDoctrine()->getManager();
        $formation = $em->getRepository('App:Formation')->findOneBy(['id' => $id]);
        
          // original Booking entity 
        $originalBooking= new ArrayCollection();
   
        foreach ($formation->getBooking() as $booking) {
            $originalBooking->add($booking);
        }
        $form = $this->createForm(FormationType::class, $formation);
        $form->handleRequest($request);
     
        if ($form->isSubmitted() && $form->isValid()) {
                 
                 foreach ($originalBooking as $booking) {
                // check if the optionBijou is in the $bijou->getOptionBijou()
                if ($formation->getBooking()->contains($booking) === false) {
                    $em->remove($booking);
                }
            } 
                $em->persist($formation);
                $em->flush();

                return $this->redirectToRoute('admin_formation_index', ['id' => $formation->getId()]);
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
