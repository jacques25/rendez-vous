<?php

namespace App\Controller\FrontEnd;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Doctrine\Persistence\ObjectManager;
use App\Service\UsersService;
use App\Service\FormationService;
use App\Service\BookingService;
use App\Repository\UserRepository;

use App\Repository\RatingRepository;
use App\Repository\FormationRepository;
use App\Repository\CommentRepository;
use App\Repository\BookingRepository;
use App\Notification\FormationNotification;
use App\Notification\CommentNotification;
use App\Form\UserBookingType;
use App\Form\CommentType;
use App\Entity\Rating;
use App\Entity\Formation;
use App\Entity\Comment;
use App\Entity\Booking;
use Symfony\Component\HttpFoundation\RedirectResponse;

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
  public function show($slug,  Request $request, FormationRepository $repo, CommentRepository $commentRepository, CommentNotification $commentNotification, BookingRepository $bookingRepository)
  { 
     $referer = $request->headers->get('referer');
     
    $user = $this->getUser(); 
   
    $formation = $repo->findOneBy(['slug' => $slug]);  
   $bookings = $bookingRepository->findByFormation($formation->getId()); 
   $ratingsData = $commentRepository ->getRatingCommentByFormation($formation);
   $nbComments = $commentRepository->getNumberCommentByFormation($formation);
    $ratingsPrinted = $ratingsData['numberRatings'];
    $averageRatings = $ratingsData['averageRatings'];
    $ratings = $commentRepository->getRatingByComment();
    
    $comment = new Comment(); 
 
  
    $form =  $this->createForm(CommentType::class, $comment);    
   
    $form->handleRequest($request);
 
     if($form->isSubmitted() and !$form->isValid())
     {
        $this->addFlash('warning', 'Certains champs ne sont remplis, veuillez recommencer.' );
        return new RedirectResponse($referer);
     }
     
      if ($form->isSubmitted() and  $form->isValid()) {
      
          $em = $this->getDoctrine()->getManager();
          $comment->setFormation($formation);
          $comment->setCommentLu(false);
          $comment->setUser($user);
          $em->persist($comment);
          $em->flush();
          $commentNotification->notify($comment, $user);
            $this->addFlash('success', ' Merci, ' . $user->getFirstname(). " pour votre commentaire. Votre commentaire sera publié  dès  que nous l 'aurons approuvé");
          return $this->redirectToRoute('formation_show', ['slug' => $formation->getSlug() ]);
      }
    return $this->render('formations/show.html.twig', [
      'bookings' =>$bookings,
      'form' => $form->createView(),
      'formation' => $formation,
      'nbComments' =>$nbComments ,
      'averageRatings' => $averageRatings,
      'ratingsPrinted' => $ratingsPrinted,
      'ratings' => $ratings,
     
     
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
