<?php

namespace App\Controller\FrontEnd;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Repository\SeanceOptionRepository;
use App\Form\UserSeanceType;
use App\Form\BookingType;
use App\Entity\UserSeance;
use App\Entity\Booking;
use DateTime;

class SeanceOptionController extends AbstractController
{
    /**
  * @Route("/rendezvous/{id}", name="seance_booking")
  *
  * @return void
  */
  public function seanceBooking($id, Request $request, SeanceOptionRepository $seanceOptionRepository)
  {
     
         $user = new UserSeance();
        $booking = new Booking();
        $form = $this->createForm(UserSeanceType::class, $user);
        $form->handleRequest($request);
        $seanceOption = $seanceOptionRepository->findOneBy(['id' => $id]);
         $start = $request->get('booking');
       
        if($form->isSubmitted() && $form->isValid()){  
              
               $begin = strtotime($start['beginAt']);
                $dateNow =  \strtotime(\date_format(new DateTime('now'), "Y-m-d H:i"));
                

           if($begin == null ||$begin <= $dateNow)
           {
               $this->addFlash('warning' , 'Erreur sur le champs date  :date non valide');
                return $this->redirectToRoute('seance_show', ['slug' => $seanceOption->getSeance()->getSlug()]); 
           }
           elseif ($begin !== null  and $begin >= $dateNow ) {
               $em = $this->getDoctrine()->getManager();
               $titleSeance = $seanceOption->getSeance()->getTitle();
               $dateoption =  $seanceOption->getDuree();
                 
               $dateDureeH = (\floatval(date_format($dateoption, 'H:i')));
               $dateDureeM = \intval(\date_format($dateoption, 'i')) ;
               $beginAt = date('Y-m-d H:i', $begin);
               $dureeH = date('Y-m-d H:i', strtotime('+'.$dateDureeH.' hour +' .$dateDureeM . 'minutes', strtotime($beginAt)));
               
                
               $booking->setBeginAt(new \Datetime($beginAt));
               $booking->setEndAt(new \Datetime($dureeH));
               $booking->setTitle($titleSeance);
               $booking->setSeanceOption($seanceOption);
               $booking->setUserSeance($user);
               
               $em->persist($booking);
               $em->persist($user);
               $em->flush(); 
               $this->addFlash('success', 'Votre rendez-vous a éte enregistré!');
              }
               
                return $this->redirectToRoute('seance_show', ['slug' => $seanceOption->getSeance()->getSlug()]);
        
        }

        return $this->render('agenda/agenda.html.twig', [
          'form' => $form->createView(),
          'seanceOption' => $seanceOption,
          'user' => $user
         
        ]);
  }

  
}
