<?php

namespace App\Controller\FrontEnd;

use Symfony\Component\Security\Csrf\TokenGenerator\TokenGeneratorInterface;
use Symfony\Component\Security\Csrf\CsrfTokenManagerInterface;
use Symfony\Component\Security\Csrf\CsrfTokenManager;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Repository\UserRepository;
use App\Repository\FormationRepository;
use App\Repository\CommentRepository;
use App\Notification\FormationNotification;
use App\Form\UserBookingType;
use App\Form\FormAccount\AccountType;
use App\Form\CommentType;
use App\Entity\User;
use App\Entity\Comment;

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
  public function show($slug,  Request $request, FormationRepository $repo, CommentRepository $commentRepository)
  { 
    $user = $this->getUser();
   
    $comment = new Comment();
    $form =  $this->createForm(CommentType::class, $comment);
    $form->handleRequest($request);
  
    $formation = $repo->findOneBy(['slug' => $slug]);  
    $comments = $commentRepository-> getCommentsForSeance($formation->getId());
      $nbUsers = count($formation->getBooking());
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
      'formation' => $formation,
      'nbUsers' => $nbUsers,
      'comments' => $comments,
      'form' => $form->createView()
    ]);
  }
    /**
     * @Route("/formation/inscription/{id}", name="formation_booking")
     *
     * @return void
     */
    public function inscriptionFormation($id, Request $request, FormationNotification $formationNotification) {
               
                  
               
                     if (!$this->isGranted('IS_AUTHENTICATED_FULLY')) {  
                       $this->addFlash('warning', 'Vous devez avoir créé votre compte puis vous connectez,  afin de vous inscrire à cette formation');
                    return $this->redirectToRoute('account_login');
                     }

                $user = $this->getUser();  
               
                 $form = $this->createForm(UserBookingType::class, $user);
                 $form->handleRequest($request);
                 
                 $formation = $this->formationRepository->findOneBy(['id' => $id]);
               
                 if ($form->isSubmitted() and $form->isValid()) {
                 
                
                     $em = $this->getDoctrine()->getManager();
                     
                        if (!$this->container->get('security.authorization_checker')->isGranted('ROLE_FORMATION')) {
                              $user->addRole("ROLE_FORMATION");
                       }
                 
                     
                     $formationNotification->notify($id, $formation, $user);
                     $this->addFlash('success', 'Votre mail à été envoyé, nous vous répondrons dans les plus bref délais.');
                     $formation->addUser($user);
                     $em->persist($formation);
                     $em->flush();
                      
                  
                     return $this->redirectToRoute('app_homepage');
                 }
             
             
  
            return $this->render('formations/inscription.html.twig' , [
              'form' => $form->createView(),  
              'formation' => $formation, 
              'user' => $user, 
           
             ]);
    }
}
