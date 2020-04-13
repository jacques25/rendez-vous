<?php

namespace App\Controller\FrontEnd\User;

use App\Entity\Commandes;
use App\Service\GetFacture;
use App\Repository\CommandesRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class FactureController extends AbstractController
{  
   private $getFacture;
   private $commandesRepository;
   public function __construct(GetFacture $getFacture, CommandesRepository $commandesRepository){

    $this->getFacture = $getFacture;
    $this->commandesRepository = $commandesRepository;
   }
  
    
 /**
 * @Route("/profile/factures/", name="user_facture")
 */
    public function facture(CommandesRepository $commandesRepository)
    {

       
        $factures = $commandesRepository->byFacture($this->getUser());
        
        return $this->render('user/default/facture.html.twig', [
            'factures' => $factures
        ]);
    }

    /**
     * @Route("/profile/factures/pdf/{id}", name="facture_pdf")
     */
    public function facturePDF($id)
    {
       
        $facture = $this->commandesRepository->findOneBy([
            'user' => $this->getUser(),
            'valider' => 1,
            'id' => $id
        ]);

         
          $this->getFacture->facture($facture);
    }

     /**
     * @Route("/profile/voir/facture/{id}", name="show_facture" )
     */

    public function showFacture($id)
    {
      
       
       $facture = $this->commandesRepository->findOneBy([
            
            'user' => $this->getUser(),
            'valider' => 1,
            'id' => $id
        ]);
   
       
        if (!$facture) {
           
            return $this->redirectToRoute('user_facture');
        }

          return $this->render('user/default/showfacture.html.twig', [
            'facture' => $facture
        ]);
    }
   
     /**
     * @Route("/profile/edition/commande/{id}", name="edit_commande")
     */
    public function editFacture($id){
        $facture = $this->commandesRepository->findOneBy([
            'user' => $this->getUser(),
            'valider' => 1,
            'id' => $id
        ]);
         dump($facture);
        return $this->render('user/default/commande.html.twig', ['facture' => $facture]);
    }

}
