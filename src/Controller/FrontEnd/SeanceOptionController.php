<?php

namespace App\Controller\FrontEnd;

use Symfony\Component\Security\Csrf\TokenGenerator\TokenGeneratorInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use DateTime;
use App\Repository\SeanceRepository;
use App\Repository\SeanceOptionRepository;
use App\Notification\SeanceNotification;
use App\Form\BookingType;
use App\Entity\Booking;

class SeanceOptionController extends AbstractController
{
    /**
  * @Route("/rendezvous/{id}", name="seance_booking")
  *
  * @return void
  */
  public function seanceBooking($id, Request $request, SeanceRepository $seanceRepository, SeanceOptionRepository $seanceOptionRepository, SeanceNotification $seanceNotification)
  {
           
          if (!$this->isGranted('IS_AUTHENTICATED_FULLY')) {  
                       $this->addFlash('warning', 'Vous devez être inscrit et vous connectez  pour obtenir un rendez-vous');
                    return $this->redirectToRoute('account_login');
                     }
     
         $user = $this->getUser();
         $seanceOption = $seanceOptionRepository->findOneBy(['id' => $id]); 
       
         $seance = $seanceOption->getSeance();
       
        $booking = new Booking();     
        
        $form = $this->createForm(BookingType::class, $booking);
        $form->handleRequest($request);
         $start = $request->get('booking');
  
        if($form->isSubmitted() && $form->isValid()){  
         
      
                 $begin = strtotime($start['beginAt']);
                $dateNow =  \strtotime(\date_format(new DateTime('now'), "Y-m-d H:i"));
              

           if($begin == null ||$begin <= $dateNow)
           {
               $this->addFlash('warning' , 'Erreur sur le champs date  : date non valide');
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
             
                if (!$this->container->get('security.authorization_checker')->isGranted('ROLE_USER_SEANCE')) {
                    $user->addRole("ROLE_USER_SEANCE");
                }
                $seance->addUser($this->getUser());
                $seanceOption->addUser($this->getUser());
                $booking->addUser($this->getUser());
                $em->persist($booking);
             
              
                 $em->flush(); 
                 $this->addFlash('success', ' un mail de confirmation vous a été envoyé.');
                      $seanceNotification->notify($id, $booking, $user); 
                 return $this->redirectToRoute('seance_show', ['slug' => $seanceOption->getSeance()->getSlug()]);
               
              }
               
             
        
            
          }
        
        return $this->render('agenda/agenda.html.twig', [
          'form' => $form->createView(),
          'seanceOption' => $seanceOption,
          'user' => $user,
      
         
         
        ]);
  }

  
}
