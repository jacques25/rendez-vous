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
    
    
    private $security;
    private $userRepository;
    public function __construct(UserRepository $userRepository){
                  
        $this->userRepository = $userRepository;
      
    
    }
    /**
     * @Route("/",  name="booking_calendar", methods ={"GET"})
     */
    public function calendar(): Response
    {
         
               return $this->render('agenda/agenda.html.twig');
    }
    /**
     * @Route("/", name="booking_index", methods={"GET"})
     */
    public function index(BookingRepository $bookingRepository): Response
    {
        return $this->render('booking/index.html.twig', [
            'bookings' => $bookingRepository->findAll(),
        ]);
    }

    /**
     * @Route("/nouveau", name="booking_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $booking = new Booking();
        $user = new User();
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
           
             else {
                 $formation = $booking->getFormation();
                
                 
                 if ($formation !== null) {
                     $nb_Users = count($formation->getUsers());
                 }
         
                 $form = $this->createForm(BookingType::class, $booking);
                 $form->handleRequest($request);
    
                 if ($form->isSubmitted() && $form->isValid()) {
                    $em =  $this->getDoctrine()->getManager();
                    $booking->setUser($user);
                    $em->persist($booking);
                    $em->flush();

                     return $this->redirectToRoute('seance_booking', [ 'id' => $booking->getId()]);
                 }
             }
        return $this->render('booking/edit.html.twig', [
            'booking' => $booking,
         /*    'seanceOption' => $seanceOption,
             'user' => $user,
             'formation' => $formation, */
            'form' => $form->createView(),
            'nbUsers' => $nb_Users,
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
}
