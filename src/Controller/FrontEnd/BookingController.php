<?php

namespace App\Controller\FrontEnd;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Service\OptionSeanceService;
use App\Repository\SeanceOptionRepository;
use App\Repository\FormationRepository;
use App\Repository\BookingRepository;
use App\Form\UserSeanceType;
use App\Form\UserBookingType;
use App\Form\BookingType;
use App\Entity\SeanceOption;
use App\Entity\Seance;
use App\Entity\Booking;
use App\Entity\UserSeance;
use App\Repository\UserSeanceRepository;

/**
 * @Route("/rendez-vous")
 */
class BookingController extends AbstractController
{   
    
    private $seanceOptionRepository;
    private $formationRepository;
    private $userSeanceRepository;
    public function __construct(SeanceOptionRepository $seanceOptionRepository, FormationRepository $formationRepository, UserSeanceRepository $userSeanceRepository){
                  
        $this->seanceOptionRepository = $seanceOptionRepository;
        $this->formationRepository = $formationRepository;
        $this->userSeanceRepository = $userSeanceRepository;
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
        $user = new UserSeance();
        $form = $this->createForm(UserSeanceType::class, $user);
        $form->handleRequest($request);
          
        if ($form->isSubmitted() && $form->isValid()) {
        
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($booking);
            $entityManager->persist($user);
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
               $formation = $booking->getFormation();
             $nb_Users = 0;
          if($formation !== null) {
            $nb_Users = count($formation->getUserFormations());
            } 
         
        $form = $this->createForm(BookingType::class, $booking);
        $form->handleRequest($request);
    
        if ($form->isSubmitted() && $form->isValid()) {
          
            
      
             $this->getDoctrine()->getManager()->flush();

           return $this->redirectToRoute('seance_booking', ['id' => $seanceOption->getId() , 'id' => $formation->getId()]);
        }
       
        return $this->render('booking/edit.html.twig', [
            'booking' => $booking,
         /*    'seanceOption' => $seanceOption,
             'user' => $user,
             'formation' => $formation, */
            'form' => $form->createView(),
            'nbUsers' => $nb_Users
        ]);
    } 

    /**
     * @Route("/{id}", name="booking_delete", methods={"DELETE"})
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
