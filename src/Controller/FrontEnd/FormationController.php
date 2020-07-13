<?php

namespace App\Controller\FrontEnd;

use App\Entity\Booking;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Service\UsersService;
use App\Repository\CommentRepository;
use App\Notification\FormationNotification;
use App\Form\UserBookingType;

use App\Form\CommentType;
use App\Repository\FormationRepository;
use App\Entity\Comment;
use App\Repository\BookingRepository;
use App\Repository\UserRepository;
use App\Service\BookingService;
use App\Service\FormationService;

class FormationController extends AbstractController
{

   private $formationRepository;

   public function __construct(FormationRepository $formationRepository)
   {
       $this->formationRepository = $formationRepository;
   }
    /**
   * @Route("/formation/{slug}", name="formation_show")
   *  
   */
  public function show($slug,  Request $request, FormationRepository $repo, CommentRepository $commentRepository, BookingRepository $bookingRepository)
  { 
    $user = $this->getUser();
    $formation = $repo->findOneBy(['slug' => $slug]);  
    $bookings = $bookingRepository->findByFormation($formation->getId()); 
  
    $comments = $commentRepository->getCommentsForFormation($formation->getId());
    
    
    $comment = new Comment();
    $form =  $this->createForm(CommentType::class, $comment);
    $form->handleRequest($request);
  
      
      if ($form->isSubmitted() and  $form->isValid()) {
          $author = $user->getFirstName();
          $em = $this->getDoctrine()->getManager();
          $comment->setFormation($formation);
          $comment->setAuthorName($author);
          $em->persist($comment);
          $em->flush();
                       
          return $this->redirectToRoute('formation_show', ['slug' => $formation->getSlug() ]);
      }
    return $this->render('formations/show.html.twig', [
      'bookings' =>$bookings,
      'comments' => $comments,
      
      'form' => $form->createView(),
      'formation' => $formation
    ]);
  }
    /**
     * @Route("/formation/inscription/{id}/{booking}", name="formation_booking")
     *
     * @return void
     */
    public function inscriptionFormation($id,  Request $request, FormationNotification $formationNotification, Booking $booking,
                                                                                  UserRepository $userRepository, BookingRepository $bookingRepository) {
                
                   $user = $this->getUser();
            
                     if (!$this->isGranted('IS_AUTHENTICATED_FULLY')) {  
                       $this->addFlash('warning', 'Vous devez avoir créé votre compte puis vous connectez,  afin de vous inscrire à cette formation');
                    return $this->redirectToRoute('account_login');
                     }
                    $formation =   $this->formationRepository->findOneBy(['id' => $id]);      
                    
                   
                     $bookings = $formation->getBooking()->current();
         
                 $form = $this->createForm(UserBookingType::class, $user);
                 $form->handleRequest($request);
                      
                 
                 if ($form->isSubmitted() and $form->isValid()) {  
                    $em = $this->getDoctrine()->getManager();   
                      $users = $userRepository->findByFormation($formation, $booking);
                  
                     
                   
                        if(in_array($user, $users ))
                        {     
                              
                          $this->addFlash( 'success', 'Bonjour ' .$user->getGender() .' '. $user->getFirstName(). ' ' . $user->getLastName(). " vous êtes déjà inscrit :-)");
                          return  $this->redirectToRoute('app_homepage');
                        }
          
                             if (!$this->container->get('security.authorization_checker')->isGranted('ROLE_FORMATION')) {
                                                  $user->addRole("ROLE_FORMATION");
                }
                        
                            $formation->addUser($user);
                            $booking->addUser($user);
                            $em->persist($user);
                            $em->flush();
                           $formationNotification->notify($id, $formation, $user);
                           $this->addFlash('success', 'Vous vous êtes inscrit à notre formation, vous allez recevoir un mail de confirmation');
                            return $this->redirectToRoute('app_homepage'); 
                        }
                        
                     
           
  
            return $this->render('formations/inscription.html.twig' , [
              'form' => $form->createView(),  
              'formation' => $formation, 
              'bookings' => $bookings,
              'user' => $user, 
              'booking' => $booking
              
           
             ]);
    }
}
