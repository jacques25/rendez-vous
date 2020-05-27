<?php

namespace App\Controller\FrontEnd;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use App\Repository\FormationRepository;
use App\Form\UserFormationType;
use App\Entity\UserFormation;

use App\Entity\Booking;

use App\Notification\FormationNotification;

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
      $nbUsers = count($formation->getUserFormations());
     
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
    public function inscriptionFormation($id, Request $request, FormationNotification $formationNotification) {
               

                     if (!$this->isGranted('IS_AUTHENTICATED_FULLY')) {  
                       $this->addFlash('warning', 'Vous devez  créer un compte et vous connectez afin de vous inscrire à cette formation');
                    return $this->redirectToRoute('account_login');
                     }
           
              
                 $user = new UserFormation();
              
                 $form = $this->createForm(UserFormationType::class, $user);
                 $form->handleRequest($request);
                 
                 $formation = $this->formationRepository->findOneBy(['id' => $id]);
                 
                 if ($form->isSubmitted() and $form->isValid()) {
                     
                     $em = $this->getDoctrine()->getManager();
                     $user->setFormation($formation);
                   $notify =  $formationNotification->notify($formation, $user); 
                
                   $this->addFlash('success', 'Votre mail à été envoyé, nous vous répondrons dans les plus bref délais.');
               
                     $em->persist($user);
                     $em->flush();
                  
            return $this->redirectToRoute('app_homepage'); 
                 
          
                
             }
             
  
            return $this->render('formations/inscription.html.twig' , ['form' => $form->createView(),  'formation' => $formation, 'user' => $user]);
    }
}
