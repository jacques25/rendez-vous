<?php

namespace App\Controller\FrontEnd;
use App\Entity\Commandes;
use App\Entity\UserAdress;
use function random_bytes;
use App\Entity\OptionBijou;
use App\Repository\CommandesRepository;
use App\Service\GetReference;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Mime\Address;

class CommandesController extends AbstractController
{  
   private $getReference;
   public function __construct(GetReference $getReference){

    $this->getReference = $getReference;
   }
  
  public function facture(Request $request)
  {

    $em = $this->getDoctrine()->getManager();
    $generator = random_bytes(20);
    $session = $request->getSession();

    $adresse = $session->get('address');
    $panier = $session->get('panier');

    $totalTTC = 0;
    $commande = array();
   

      $facturation = $em->getRepository(UserAdress::class)->find($adresse['facturation']);
      $livraison = $em->getRepository(UserAdress::class)->find($adresse['livraison']);
 
     $optionBijous = $em->getRepository(OptionBijou::class)->findArray(array_keys($session->get('panier')));
  
    /* $promos = $em->getRepository('BoutiqueBundle:Promo')->findArray(array_keys($session->get('panier'))); */

    foreach ($optionBijous as $optionBijou) {
       
       $commande['optionBijou'][$optionBijou->getId()] = array(
        'reference' => $optionBijou->getReference(),
        'taille' => $optionBijou->getTaille(),
        'prix' => $optionBijou->getPrix(),
        'quantite' => $panier[$optionBijou->getId()],
        'bijou'  => $optionBijou->getBijou()
      ); 
       $totalPrix = ($optionBijou->getPrix() * $panier[$optionBijou->getId()]);
       $totalTTC += $totalPrix;
    }
       
   
    $commande['livraison'] = array(
      'firstname' => $livraison->getFirstName(),
      'lastname' => $livraison->getLastName(),
      'phone' => $livraison->getPhone(),
      'address' => $livraison->getStreet(),
      'cp' => $livraison->getCp(),
      'city' => $livraison->getCity(),
      'country' => $livraison->getCountry(),
      'complement' => $livraison->getComplement()
    );

    $commande['facturation'] = array(
      'firstname' => $facturation->getFirstname(),
      'lastname' => $facturation->getLastname(),
      'phone' => $facturation->getPhone(),
      'address' => $facturation->getStreet(),
      'cp' => $facturation->getCp(),
      'city' => $facturation->getCity(),
      'country' => $facturation->getCountry(),
      'complement' => $facturation->getComplement()
    );
    

    $commande['token'] = bin2Hex($generator);
    $commande['totalCommande'] = $totalTTC;
    
    return $commande;
  }

  public function prepareCommande(Request $request)
  {
    $session = $request->getSession();

    $em = $this->getDoctrine()->getManager();


    if(!$session->has('commande')) 
      $commande = new Commandes();
    else

  
    $commande = $em->getRepository(Commandes::class)->find($session->get('commande'));
   
    $commande->setDateCommande(new \DateTime());
    $commande->setUser($this->container->get('security.token_storage')->getToken()->getUser());
    $commande->setValider(0);
    $commande->setNumeroCommande(0);
    $commande->setCommande($this->facture($request));
    
    
    if (!$session->has('commande')) {
      $em->persist($commande);

      $em->flush();
      $session->set('commande', $commande);
    }

    $em->flush();

    return new Response($commande->getId());
  }

  /*
     * cette méthode remplace l'api banque
     */

  /**
   *
   * @Route("/api/banque/{id}", name="validation_commande")
   */
  public function validationCommande(Request $request, $id, MailerInterface $mailer)
  { 
    
    $em = $this->getDoctrine()->getManager();

    $commande = $em->getRepository(Commandes::class)->find($id);
    if (!$commande) {
      
      throw $this->createNotFoundException('La commande n\'existe pas');
    }
     
    
      $user = $commande->getUser();
      $commande->setValider(1);
      $commande->setNumeroCommande($this->getReference->reference());
      $em->flush();
      $email = $user->getEmail();
      $username = $user->getLastName();
      $url = $this->generateUrl('show_facture', ['id' => $commande->getId()], UrlGeneratorInterface::ABSOLUTE_URL);
      $mail = (new TemplatedEmail())
        ->from(new Address('contact@rvas.site', 'Rendez-vous Avec Soi'))
        ->to(new Address($email, $username))
        ->subject("Bon de commande à Télécharger")
        ->htmlTemplate('email/email-commande-pdf.html.twig')
        ->context( [
           'user' => $user,
           'username' => $username,
           'url'=> $url,
           'commande'=> $commande
        ]);

      $mailer->send($mail);


    $session = $request->getSession();
    $session->remove('adresse');
    $session->remove('panier');
   
      $this->addFlash('success', 'Votre commande est validée, un lien vient de vous être envoyé pour la finaliser');
    return $this->redirectToRoute('panier');
  }
  
  /**
   * @Route("/annulation/commande/{id}", name="commande_remove")
   *
   * @param Request $request
   * @param CommandesRepository $commandesRepository
   */
  public function removeCommande($id, Request $request)
  {   
         $session = $request->getSession();
         $em = $this->getDoctrine()->getManager();
         $commande = $em->getRepository(Commandes::class)->find($id);
         $valid = $commande->getValider();
          
         if($valid === false){
           $em->remove($commande);
           $em->flush();
           $session->remove('panier');
           $session->remove('commande');
           $this->addFlash('success' , 'Vous avez annulé votre commande. Nous espérons vous revoir Bientôt !');
         return $this->redirectToRoute('panier');
         }
  }
}
