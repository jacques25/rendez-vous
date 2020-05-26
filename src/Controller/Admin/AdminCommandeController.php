<?php

namespace App\Controller\Admin;

use Symfony\Component\Validator\Constraints\Date;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Mime\Address;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Knp\Component\Pager\PaginatorInterface;
use DateTime;
use App\Service\GetReference;
use App\Service\GetFacture;
use App\Repository\CommandesRepository;
use App\Entity\Expedition;
use App\Entity\Commandes;
use App\Form\Contact\ExpeditionType;
use App\Notification\ExpeditionNotification;

/**
 * @Route("/admin")
 */
class AdminCommandeController extends AbstractController
{  
   private $commandesRepository;
   private $getReference;
    private $getFacture;
   
   
   public function __construct(CommandesRepository $commandesRepository, GetReference $getReference, GetFacture $getFacture)
   {  
      $this->commandesRepository = $commandesRepository;  
      $this->getReference = $getReference;
      $this->getFacture = $getFacture;
    
   }
    
   public function navMenu() 
   {  
     $commandeCount = $this->commandesRepository->getCommandesCount();
       $commandes = $this->commandesRepository
            ->findLastCommandes(
                array(),  
            );
        return $this->render('admin/commande/block/nav-commande.html.twig',[
                'commandes' => $commandes, 
                'commandesCount' => $commandeCount
        ]);
   }
  
   /**
    * @Route("/liste/commandes", name="admin_commandes_index")
    */

    public function index(PaginatorInterface $paginatorInterface, Request $request)
    {
      $commandes = $paginatorInterface->paginate(
                    $this->commandesRepository->findAllVisibleQuery(),
                    $request->query->getInt('page' ,  1),
                    5
      );
      
      return $this->render('admin/commande/index.html.twig', ['commandes' => $commandes]);
    }

   /**
    * @Route("/voir/commandes/{user}", name="admin_commande_show", requirements={"user"="\d+"})
    */

    public function show($user){
      $commandes = $this->commandesRepository->findCommandesByUser($user);
      
      return $this->render('admin/commande/show.html.twig', ['commandes' => $commandes]);
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

        return $this->redirectToRoute('admin_commandes_index');
    }
    
    /**
     * @Route("/expedition/commande/{id}", name="admin_expedition")
     *
     * @param [type] $id
     * @param Request $request
     * @param MailerInterface $mailer
     * @return void
     */
    public function EnvoiMessage( $id, Request $request , CommandesRepository $commandesRepository, ExpeditionNotification $expeditionNotification)
    {
  
    $commande = $commandesRepository->find($id);
    $user = $commande->getUser();
    
     $expedition = new Expedition();
     $form = $this->createForm(ExpeditionType::class, $expedition);
     $form->handleRequest($request);
      
     if ($request->isMethod('POST')) { 
         $commande->setSendCommande(1);
         $commande->setNumeroCommande($this->getReference->reference());
         $commande->setDateExpedition($expedition->getDateExpedition());
         $em= $this->getDoctrine()->getManager();
         $em->persist($commande);
         $em->flush(); 
         if ($commande !== null) {
           
             $expeditionNotification->notify($expedition, $commande);
         
             $this->addFlash('success', 'Message envoyé');
             return $this->redirectToRoute('admin_commande_show', ['user' => $user->getId()]);
         }
     }
                 

          return $this->render('email/expedition.html.twig', ['commande'=> $commande,  'form' => $form->createView(), 'expedition' => $expedition]);

    }

     /**
     * @Route("/factures/pdf/{id}", name="admin_facture_pdf")
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
 * @Route("/user/factures/", name="admin_user_facture")
 */
    public function facture(CommandesRepository $commandesRepository)
    {

       
        $factures = $commandesRepository->byFacture($this->getUser());
        
        return $this->render('user/default/facture.html.twig', [
            'factures' => $factures
        ]);
    }

    /* /**
     *  @route("/imprimer/pdf", name="admin_print_pdf")
     */
   /*  public function printPdf(CommandesRepository $commandesRepository, \Knp\Snappy\Pdf $knpSnappy)
    {
     $factures = $commandesRepository->byFacture($this->getUser());
      $html = $this->renderView('user/default/facture.html.twig', [
            'factures' => $factures
        ]);
        $filename =  sprintf('facture-%s.pdf', date('d-m-Y'));

        return new PdfResponse( 
         $knpSnappy->getOutputFromHtml($html),
          200,
          [
              'Content-Type' => 'application/pdf',
              'Content-Disposition' => sprintf('attachment;  filename="%s"', $filename),
          ]
          );
         
    }  */
}
