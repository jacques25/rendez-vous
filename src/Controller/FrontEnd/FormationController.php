<?php

namespace App\Controller\FrontEnd;

use Symfony\Component\Security\Csrf\TokenGenerator\TokenGeneratorInterface;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Repository\UserRepository;
use App\Repository\FormationRepository;
use App\Notification\FormationNotification;
use App\Form\UserBookingType;
use App\Form\FormAccount\AccountType;
use App\Entity\User;


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
  public function show($slug, FormationRepository $repo)
  { 
   
    $formation = $repo->findOneBy(['slug' => $slug]);
      $nbUsers = count($formation->getUsers());
     
    return $this->render('formations/show.html.twig', [
      'formation' => $formation,
      'nbUsers' => $nbUsers

    ]);
  }
    /**
     * @Route("/formation/inscription/{id}", name="formation_booking")
     *
     * @return void
     */
    public function inscriptionFormation($id, Request $request, FormationNotification $formationNotification,  Security  $security) {
               
                  
               
                     if (!$this->isGranted('IS_AUTHENTICATED_FULLY')) {  
                       $this->addFlash('warning', 'Vous devez  créer un compte et vous connectez afin de vous inscrire à cette formation');
                    return $this->redirectToRoute('account_login');
                     }

              $user = $this->getUser();  
            
             
                 
                 $form = $this->createForm(UserBookingType::class, $user);
                 $form->handleRequest($request);
                 
                 $formation = $this->formationRepository->findOneBy(['id' => $id]);
             
                 if ($form->isSubmitted() and $form->isValid()) {
               
                     $em = $this->getDoctrine()->getManager();
                     
                     $user->addRole("ROLE_FORMATION");
                     $user->setFormation($formation);
                     
                     $formationNotification->notify($id, $formation, $user);
                     $this->addFlash('success', 'Votre mail à été envoyé, nous vous répondrons dans les plus bref délais.');
                     
                     $em->persist($user);
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
