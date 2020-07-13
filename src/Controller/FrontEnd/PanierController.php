<?php

namespace App\Controller\FrontEnd;


use App\Entity\Commandes;
use App\Entity\UserAdress;
use App\Form\UserAdressType;
use App\Repository\CommandesRepository;
use Symfony\Component\Mime\Email;
use App\Repository\OptionBijouRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\Security\Csrf\TokenGenerator\TokenGeneratorInterface;

class PanierController extends AbstractController
{

  public function __construct(SessionInterface $session)
  {

    $this->session = $session;
  }
  
 
  public function menu(Request $request, OptionBijouRepository $optionBijouRepository)
  {
   
    $session =  $request->getSession();
       if (!$session->has('panier')) $session->set('panier', []);
    
    $result = [];
    $panier = $session->get('panier');
    $totalTTC = 0;
    $totalPromo = 0 ;
    $totalBijou = 0;
    $items = $optionBijouRepository->findArray(array_keys($session->get('panier')));

   
    if (!$session->has('panier')) {
      $items = 0;
      $this->redirectToRoute('app_homepage');
    } else {
        $itemsCount = count($session->get('panier'));
        foreach ($items as $item) {
          $result['item'][$item->getId()] = array(
          'quantite' => $panier[$item->getId()],
          'reference' => $item->getReference(),
          'prix' => $item->getPrix(),
          'multiplicate' => $item->getBijou()->getMultiplicate(),
          'promoIsActive' => $item->getBijou()->getPromoIsActive(),
          'bijou'  => $item->getBijou()
        );
               if($item->getBijou()->getPromoIsActive()) {
                  
                 $prixPromo = ($item->getPrix() * $item->getBijou()->getMultiplicate())* $panier[$item->getId()];
                  $totalPromo +=  $prixPromo;

               } else {
                  $prixBijou  = $item->getPrix() * $panier[$item->getId()] ;
                  $totalBijou += $prixBijou;
               }
           
               
     
            
                 
            
           
              $totalTTC = $totalBijou+ $totalPromo ;
             
        }

         $result['totalCommande'] = $totalTTC;
     return   $this->render('panier/menu.html.twig', ['itemsCount' => $itemsCount , 'result' => $result ]);
      
    }
          return $this->render('panier/menu.html.twig', ['itemsCount' => $itemsCount]);
  }


  /**
   * @Route("/panier", name="panier")
   */
  public function panier(Request $request, OptionBijouRepository $optionBijouRepository)
  {

    $session = $request->getSession();
  
    if (!$session->has('panier')) $session->set('panier', []);
    $items = $optionBijouRepository->findArray(array_keys($session->get('panier')));
   
    return $this->render('panier/panier.html.twig', [
      'items' => $items,
      'panier' => $session->get('panier'),

    ]);
  }
  /**
   * @Route("panier/ajouter/{id}", name="panier_add", methods={"GET"}, options={"expose"=true})
   *
   * @return void
   */
  public function add($id, Request $request)
  {
    $session = $request->getSession();

    if (!$session->has('panier')) $session->set('panier', []);

    $panier = $session->get('panier');

    

    if (array_key_exists($id, $panier)) {
      if ($request->query->get('qte') != null) $panier[$id] = $request->query->get('qte');
      $this->addFlash('success', 'Vous avez modifié la quantité de cet article');
    } else {
      if ($request->query->get('qte') != null)
        $panier[$id] = $request->query->get('qte');

      else
        $panier[$id] = 1;
      $this->addFlash('success', 'nouvel article dans votre panier');
    }


    $session->set('panier', $panier);


    return  $this->redirectToRoute('panier');
  }



  /**
   * @Route("panier/supprimer/{id}", name="panier_remove")
   *
   */
  public function remove(Request $request, $id)
  {
    $session = $request->getSession();
    $panier = $session->get('panier');

    if (array_key_exists($id, $panier)) {
      unset($panier[$id]);
      $session->set('panier', $panier);

      $this->addFlash('success', 'Vous avez supprimer cet article de votre panier');
    }


    return $this->redirectToRoute('panier');
  }

  /**
   * @Route("/panier/livraison", name="panier_livraison")
   */

  public function livraison(Request $request)
  {
    $role = ["ROLE_CLIENT"];
    $user = $this->container->get('security.token_storage')->getToken()->getUser();
    $userAddresss = new UserAdress();

    $form = $this->createForm(UserAdressType::class, $userAddresss);
    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
      $manager = $this->getDoctrine()->getManager();

      $user->setRoles($role);
      $userAddresss->setUser($user);
      $manager->persist($userAddresss);
      $manager->flush();
      
      $this->addFlash('success', "L'adresse a bien été ajouter");
      return $this->redirectToRoute('panier_livraison');
    }
    
    return $this->render('panier/livraison.html.twig', ['form' => $form->createView(), 'user' => $user]);
  }


  /**
   * @Route("/panier/validation", name="panier_validation",requirements={"user"="\d+"})
   * 
   */
  public function validation(Request $request , CommandesRepository $commandesRepository)
  { 

    if ($request == null) {
      $this->addFlash('warning', 'Votre panier est vide');
       $this->redirectToRoute('app_homepage');
    } 
    
    if ($request->getMethod() == 'POST')
    $this->setLivraisonOnSession($request);
     
      $prepareCommande = $this->forward('App\Controller\FrontEnd\CommandesController:prepareCommande');
      
      $commande = $commandesRepository->find($prepareCommande->getContent());
  
       return $this->render('panier/validation.html.twig', [
        'commande' => $commande
       ]);
   
    
   

  }  
      


  public function setLivraisonOnSession(Request $request)
  {
    $session = $request->getSession();

    if (!$session->has('address')) $session->set('address', array());

    $address = $session->get('address');

    if ($request->get('livraison') != null && $request->get('facturation') != null) {
      $address['livraison'] = $request->get('livraison');
      $address['facturation'] = $request->get('facturation');
    } else {
      return $this->redirectToRoute('panier_validation');
    }

    $session->set('address', $address);

    return $this->redirectToRoute('panier_validation');
  }

  /**
   * @Route("livraison/adresse/suppression/{id}",name="livraisonadressesuppression")
   */
  public function suppressionAdresseAction($id)
  {
    $em = $this->getDoctrine()->getManager();
    $entity = $em->getRepository(UserAdress::class)->find($id);
    if ($this->container->get('security.token_storage')->getToken()->getUser() != $entity->getUser() || !$entity) {
      return $this->redirectToRoute('panier_livraison');
    }

    $em->remove($entity);
    $em->flush();

    return $this->redirectToRoute('panier_livraison');
  }
}
