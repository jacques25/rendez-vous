<?php

namespace App\Controller\FrontEnd;

use function random_bytes;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Entity\Commandes;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
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
    $totalTTC = 0;

    $commande = array();
    $totalPromo = 0;
    $horsPromoTTC = 0;
    $fraisPort = 0;

    /*   $facturation = $em->getRepository('App:UserAddress')->find($adresse['facturation']);
        $livraison = $em->getRepository('App:UserAddress')->find($adresse['livraison']); */

    $bijous = $em->getRepository('App:Bijou')->findArray(array_keys($session->get('panier')));

    /* $promos = $em->getRepository('BoutiqueBundle:Promo')->findArray(array_keys($session->get('panier'))); */

    foreach ($bijous as $bijou) {
      $totalPrix = ($prix[$bijou->getId()] * $panier[$bijou->getId()]);
      $totalTTC += $totalPrix;

      $commande['bijou'][$bijou->getId()] = array(
        'reference' => $reference[$bijou->getId()],
        'title' => $bijou->getTitle(),
        'quantite' => $panier[$bijou->getId()],
        'taille' => $taille[$bijou->getId()],
        'prix' => $prix[$bijou->getId()],

      );
    }

    $commande['livraison'] = array(
      'firstname' => $livraison->getFirstname(),
      'lastname' => $livraison->getLastname(),
      'phone' => $livraison->getPhone(),
      'address' => $livraison->getAddress(),
      'cp' => $livraison->getCp(),
      'city' => $livraison->getCity(),
      'country' => $livraison->getCountry(),
      'complement' => $livraison->getComplement()
    );

    $commande['facturation'] = array(
      'firstname' => $facturation->getFirstname(),
      'lastname' => $facturation->getLastname(),
      'phone' => $facturation->getPhone(),
      'address' => $facturation->getAddress(),
      'cp' => $facturation->getCp(),
      'city' => $facturation->getCity(),
      'country' => $facturation->getCountry(),
      'complement' => $facturation->getComplement()
    );


    $commande['token'] = bin2Hex($generator);
    $commande['totalCommande'] = $totalTTC;

    return $commande;
  }

  public function prepareCommandeAction(Request $request)
  {
    $session = $request->getSession();

    $em = $this->getDoctrine()->getManager();


    if (!$session->has('commande'))
      $commande = new Commandes();
    else

      $commande = $em->getRepository('BoutiqueBundle:Commandes')->find($session->get('commande'));

    $commande->setDate(new \DateTime());
    $commande->setUser($this->container->get('security.token_storage')->getToken()->getUser());
    $commande->setValider(0);
    $commande->setReference(0);
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
  public function validationCommandeAction(Request $request, $id)
  {
    $em = $this->getDoctrine()->getManager();

    $commande = $em->getRepository('BoutiqueBundle:Commandes')->find($id);
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
