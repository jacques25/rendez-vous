<?php

namespace App\Controller\Admin;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Service\OptionSeanceService;
use App\Repository\SeanceOptionRepository;
use App\Repository\BookingRepository;
use App\Form\UserBookingType;
use App\Form\BookingType;
use App\Entity\SeanceOption;
use App\Entity\Seance;
use App\Entity\Booking;
use App\Entity\Formation;
use App\Repository\FormationRepository;
use App\Repository\SeanceRepository;
use DateTime;

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
           /*     $this->removeoldBooking($booking); */
                $bookings =  $em->getRepository(Booking::class)->findAll();
                    foreach ($bookings as $booking)
            {
                 $endAt = date_format($booking->getEndAt(), 'Y-m-d H:i');
                 $dateCompare = date_format(new DateTime('now'), 'Y-m-d 16:15');
              
         if($endAt < $dateCompare)   
                  unset($booking);
            }
               return $this->render('admin/agenda/agenda.html.twig', ['bookings' => $bookings]);
    }
    /**
     * @Route("/list", name="admin_booking_index", methods={"GET"})
     */
    public function index()
    {  
           $em = $this->getDoctrine()->getManager();
            $bookings =  $em->getRepository(Booking::class)->findAll();
        
          
        return $this->render('admin/booking/index.html.twig', [
            'bookings' => $bookings,
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
     * @Route("/{id}/edit", name="admin_booking_edit", methods={"GET","POST"})
     */
    public function edit($id, Request $request): Response
    {   
        $em = $this->getDoctrine()->getManager();
        $booking = $em->getRepository(Booking::class)->findOneBy(['id' => $id]);
        $form = $this->createForm(BookingType::class, $booking);
        $form->handleRequest($request);
    
        if ($form->isSubmitted() && $form->isValid()) {
           
            $em->flush();

           return $this->redirectToRoute('admin_booking_index');
        }

        return $this->render('admin/booking/edit.html.twig', [
            'booking' => $booking,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="booking_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Booking $booking, SeanceOption $seanceOption, Formation $formation): Response
    {    
         $seanceOption = $booking->getSeanceOption();
         $formation = $booking->getFormation();
       
        if ($this->isCsrfTokenValid('delete'.$booking->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($booking);
            $entityManager->flush();
        } 
         
           return $this->redirectToRoute('seance_booking', ['id' => $seanceOption->getId(), ['id' => $formation]]);
    }

    public function removeoldBooking(Booking $booking){
        $em = $this->getDoctrine()->getManager();
        $booking = $this->bookingRepository->findBy($booking->getId());
        if($booking->getEndAt() <=  new DateTime('now'))
        {
            $em->remove($booking);
        }

    }
  
}
