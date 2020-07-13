<?php

namespace App\Controller\FrontEnd\User;

use App\Entity\Commandes;
use App\Service\GetFacture;
use App\Repository\CommandesRepository;
use App\Service\GetCommande;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CommandeController extends AbstractController
{  
   private $getCommande;
   private $commandesRepository;
   public function __construct(GetCommande $getCommande, CommandesRepository $commandesRepository){

    $this->getCommande = $getCommande;
    $this->commandesRepository = $commandesRepository;
   }
  
    
 /**
 * @Route("/profile/commandes/", name="user_commande")
 */
    public function commande(CommandesRepository $commandesRepository)
    {

       
        $commandes = $commandesRepository->byFacture($this->getUser());
           
        return $this->render('user/default/commande.html.twig', [
            'commandes' => $commandes
        ]);
    }

    /**
     * @Route("/profile/commandes/pdf/{id}", name="commande_pdf")
     */
    public function CommandePDF($id)
    {
       
        $commande = $this->commandesRepository->findOneBy([
            'user' => $this->getUser(),
            'valider' => 1,
            'id' => $id
        ]);
    
          $this->getCommande->commande($commande);
    }

     /**
     * @Route("/profile/voir/commande/{id}", name="show_commande" )
     */

    public function showCommande($id)
    {
      
       
       $commande = $this->commandesRepository->findOneBy([
            
            'user' => $this->getUser(),
            'valider' => 1,
            'id' => $id
        ]);
   
       
        if (!$commande) {
           
            return $this->redirectToRoute('user_commande');
        
        }

          return $this->render('user/default/showCommande.html.twig', [
            'commande' => $commande
        ]);
    }
   
     /**
     * @Route("/profile/edition/commande/{id}", name="edit_commande")
     */
    public function editFacture($id){
        $commande = $this->commandesRepository->findOneBy([
            'user' => $this->getUser(),
            'valider' => 1,
            'id' => $id
        ]);
   
        return $this->render('user/default/commande.html.twig', ['commande' => $commande]);
    }

}
