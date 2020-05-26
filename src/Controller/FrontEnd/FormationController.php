<?php

namespace App\Controller\FrontEnd;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use App\Repository\FormationRepository;

use App\Form\UserFormationType;
use App\Form\FormAccount\AccountType;
use App\Entity\UserFormation;
use App\Entity\User;
use App\Entity\Booking;

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
    public function inscriptionFormation($id, Request $request) {
               

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
                    
                     $em->persist($user);
                     $em->flush();
                     $this->addFlash('success', 'Vous êtes enregistré');
                     $this->redirectToRoute('app_homepage');
                 
          
                
             }
             
  
            return $this->render('formations/inscription.html.twig' , ['form' => $form->createView(),  'formation' => $formation, 'user' => $user]);
    }
}
