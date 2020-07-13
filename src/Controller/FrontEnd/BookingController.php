<?php

namespace App\Controller\FrontEnd;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Repository\UserRepository;
use App\Repository\BookingRepository;
use App\Form\BookingType;
use App\Entity\User;
use App\Entity\Booking;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;


/**
 * @Route("/rendez-vous")
 */
class BookingController extends AbstractController
{   
    
    /**
     * @Route("/calendrier",  name="booking_calendar", methods ={"GET"})
     */
    public function calendar(Booking $booking): Response
    {           
                dd($booking);
                 $this->removeoldBooking($booking);
               return $this->render('agenda/agenda.html.twig');
    }
   

    /**
     * @Route("/nouveau", name="booking_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $booking = new Booking();
        $user = $this->getUser();
        $form = $this->createForm(BookingType::class, $user);
        $form->handleRequest($request);
          
        if ($form->isSubmitted() && $form->isValid()) {
        
            $entityManager = $this->getDoctrine()->getManager();
          
            $entityManager->persist($booking);
          
            $entityManager->flush();

            return $this->redirectToRoute('seance_booking');
        }

        return $this->render('booking/new.html.twig', [
            'booking' => $booking,
            'user' => $user,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="booking_show", methods={"GET"})
     */
    public function show(Booking $booking): Response
    {
        return $this->render('booking/show.html.twig', [
            'booking' => $booking,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="booking_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Booking $booking): Response
    {   

               $user = $this->getUser();
               
           if (!$this->isGranted('ROLE_USER_SEANCE')  ) {  
                       $this->addFlash('warning', 'vous n\êtes pas connecté ');
                    return $this->redirectToRoute('account_login');
                     }
             
           
             if(! $user->getId()) {
              
                 $this->addFlash('danger' , 'Vous ne pouvez pas modifier ce rendez-vous');
                 return $this->redirectToRoute('seance_booking', ['id' => $booking->getId()]);
             } 
           
             
         
                 $form = $this->createForm(BookingType::class, $booking);
                 $form->handleRequest($request);
    
                 if ($form->isSubmitted() && $form->isValid()) {
                    $em =  $this->getDoctrine()->getManager();
                    $booking->addUser($user);
                    $em->persist($booking);
                    $em->flush();

                     return $this->redirectToRoute('seance_booking', [ 'id' => $booking->getId()]);
                 
             }
        return $this->render('booking/edit.html.twig', [
            'booking' => $booking,
            'form' => $form->createView(),
            'user' => $user
        ]);
    } 

    /**
     * @Route("/{id}/supprimer", name="booking_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Booking $booking): Response
    {    
         $seanceOption = $booking->getSeanceOption();
          
        if ($this->isCsrfTokenValid('delete'.$booking->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($booking);
            $entityManager->flush();
        } 
         
           return $this->redirectToRoute('seance_booking', ['id' => $seanceOption->getId()]);
    }


       public function removeOldBooking(Booking $booking){
          $em = $this->getDoctrine()->getManager();
            $endDate = date_format($booking->getEndAt(), 'Y-m-d H:i');
            $now = date_format(new \DateTime('now'),  'Y-m-d H:i');
            dd($endDate);
            if ($endDate < $now) {
             $em->remove($booking);
             $em->flush();
         }

    }
}
