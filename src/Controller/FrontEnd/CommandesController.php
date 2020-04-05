<?php

namespace App\Controller\FrontEnd;
use App\Entity\Bijou;
use App\Entity\OptionBijou;
use App\Entity\Commandes;
use App\Entity\UserAdress;
use function random_bytes;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class CommandesController extends AbstractController
{
    public function facture(Request $request)
  {

    $em = $this->getDoctrine()->getManager();
    $generator = random_bytes(20);
    $session = $request->getSession();

    $adresse = $session->get('address');
    $panier = $session->get('panier');
    $taille = $session->get('taille');
    $reference = $session->get('reference');
    $prix = $session->get('prix');
    $bijou = $session->get('bijou');
    $totalTTC = 0;
   
    
   
    $commande = array();
    $totalPromo = 0;
    $horsPromoTTC = 0;
    $fraisPort = 0;

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


    if(!$session->has('commande')) {
      $commande = new Commandes();
    } else

      
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
  public function validationCommande(Request $request, $id)
  {
    $em = $this->getDoctrine()->getManager();

    $commande = $em->getRepository(Commandes::class)->find($id);
    if (!$commande || $commande->getValider() == 1) {

      throw $this->createNotFoundException('La commande n\'existe pas');
    }

    $commande->setValider(1);
    $commande->setReference($this->container->get('setNewReference')->reference()); //service

    $em->flush();

    $session = $request->getSession();
    $session->remove('adresse');
    $session->remove('panier');
    /*  $session->remove('taille');
        $session->remove('prix');
        $session->remove('reference');
        $session->remove('commande'); */

    $this->addFlash('success', 'Votre commande a été validée avec succès');
    return $this->redirectToRoute('panier');
  }
}
