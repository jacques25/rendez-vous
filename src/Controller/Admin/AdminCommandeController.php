<?php

namespace App\Controller\Admin;

use App\Entity\User;
use App\Entity\Commandes;
use App\Service\GetReference;
use Symfony\Component\Mime\Address;
use App\Repository\CommandesRepository;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


/**
 * @Route("/admin")
 */
class AdminCommandeController extends AbstractController
{  
   private $commandesRepository;
   private $getReference;
   
   public function __construct(CommandesRepository $commandesRepository, GetReference $getReference)
   {
      $this->commandesRepository = $commandesRepository;  
      $this->getReference = $getReference;
   }
    
   public function navMenu() 
   {
       $commandes = $this->commandesRepository
            ->findLastCommandes(
                array(),  
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

        return $this->redirectToRoute('admin_commmande_index');
    }
    
    /**
     * @Route("/expdition/commande/{id}", name="admin_expedition")
     *
     * @param [type] $id
     * @param Request $request
     * @param MailerInterface $mailer
     * @return void
     */
    public function EnvoiMessage( $id, Request $request , MailerInterface $mailer)
    {
       $em = $this->getDoctrine()->getManager();

    $commande = $em->getRepository(Commandes::class)->find($id);
    if (!$commande) {
      
      throw $this->createNotFoundException('La commande n\'existe pas');
    }
     
    
      $user = $commande->getUser();
      $commande->setSendCommande(1);
      $commande->setNumeroCommande($this->getReference->reference());
      $em->flush();
      $email = $user->getEmail();
      $username = $user->getLastName();
      $url = $this->generateUrl('show_facture', ['id' => $commande->getId()], UrlGeneratorInterface::ABSOLUTE_URL);
      $mail = (new TemplatedEmail())
        ->from(new Address('contact@rvas.site', 'Rendez-vous Avec Soi'))
        ->to(new Address($email, $username))
        ->subject("Expédition de votre commande")
        ->htmlTemplate('email/email-expedition.html.twig')
        ->context( [
           'user' => $user,
           'username' => $username,
           'url'=> $url,
           'commande'=> $commande
        ]);

      $mailer->send($mail);


   
   
      $this->addFlash('success', 'Message envoyé');
    return $this->redirectToRoute('admin_commande_show', ['user' => $user->getId()]);

    }
}
