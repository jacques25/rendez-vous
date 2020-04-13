<?php

namespace App\Controller\Admin;

use App\Entity\Commandes;
use App\Repository\CommandesRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/admin")
 */
class AdminCommandeController extends AbstractController
{  
   private $commandesRepository;
   public function __construct(CommandesRepository $commandesRepository)
   {
      $this->commandesRepository = $commandesRepository;
   }
    
   public function navMenu($limit) 
   {
       $commandes = $this->commandesRepository
            ->findLastCommandes(
                array(),
                $limit,
                0
              
            );
        return $this->render('admin/commande/nav-commande.html.twig',[
                'commandes' => $commandes, 
              ]);
   }
  
   /**
    * @Route("/liste/commandes", name="admin_commandes_index")
    */

    public function index(){
      $commandes = $this->commandesRepository->findAll();
      
     
      return $this->render('admin/commande/index.html.twig', ['commandes' => $commandes]);
    }

   /**
    * @Route("/voir/commande/{id}", name="admin_commande_show")
    */

    public function show($id){
      $commande = $this->commandesRepository->findOneBy(['id' => $id]);

      return $this->render('admin/commande/show.html.twig', ['commande' => $commande]);
    }

    /**
    * @Route("/delete/commande/{id}", name="admin_commande_delete")
    */

    public function delete(Request $request, Commandes $commande){
 
       if ($this->isCsrfTokenValid('delete' . $commande->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($commande);
            $entityManager->flush();
        }

        return $this->redirectToRoute('admin_commmande_index');
    }
}
