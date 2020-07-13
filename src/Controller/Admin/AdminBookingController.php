<?php

namespace App\Controller\Admin;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Repository\FormationRepository;
use App\Repository\BookingRepository;
use App\Form\FormationBookingType;
use App\Form\BookingType;
use App\Entity\Booking;

/**
 * @Route("/admin/rendez-vous")
 */
class AdminBookingController extends AbstractController
{   
    private $bookingRepository;
 
     public function __contruct(BookingRepository $bookingRepository)
     {
            $this->bookingRepository = $bookingRepository;
            
     }
    /**
     * @Route("/calendrier",  name="admin_booking_calendar", methods ={"GET"})
     */
    public function calendar(): Response
    {           
               $em = $this->getDoctrine()->getManager();
         
                $bookings =  $em->getRepository(Booking::class)->findAll();
             
               return $this->render('admin/agenda/agenda.html.twig', ['bookings' => $bookings]);
    }
    /**
     * @Route("/list", name="admin_booking_index", methods={"GET"})
     */
    public function index(BookingRepository $bookingRepository, FormationRepository $formationRepository)
    {  
             
            $bookings =  $bookingRepository->findAll();
        
          
        return $this->render('admin/booking/index.html.twig', [
            'bookings' => $bookings
        ]);
    }

     /**
     * @Route("/nouveau", name="admin_booking_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $booking = new Booking();
     
        $form = $this->createForm(BookingType::class, $booking);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
           
            $entityManager->persist($booking);
            $entityManager->flush();

            return $this->redirectToRoute('admin_booking_index');
        }
          
        return $this->render('admin/booking/new.html.twig', [
            'booking' => $booking,
            'form' => $form->createView(),
        ]);
    } 

    /**
     * @Route("/{id}", name="admin_booking_show", methods={"GET"})
     */
    public function show(Booking $booking): Response
    {
        return $this->render('admin/agenda/agenda.html.twig', [
            'booking' => $booking,
        ]);
    }

    /**
     * @Route("/{id}/editer", name="admin_booking_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Booking $booking): Response
    {   
          
          if(!$this->getUser()) {
                   return  $this->redirectToRoute('app_homepage');
          }
        $form = $this->createForm(BookingType::class, $booking);
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {
          $this->getDoctrine()->getManager()->flush();

           return $this->redirectToRoute('admin_booking_index');
        }
        return $this->render('admin/booking/edit.html.twig', [
            'booking' => $booking,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}/supprimer", name="admin_booking_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Booking $booking): Response
    {    
         if(!$this->getUser){
             return $this->redirectToRoute('app_homepage');
         }
        if ($this->isCsrfTokenValid('delete'.$booking->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();

            $entityManager->remove($booking);
            $entityManager->flush();
        } 
         
           return $this->redirectToRoute('admin_booking_index');
    }
   

  
}
