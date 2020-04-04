<?php

namespace App\Controller\FrontEnd;


use App\Entity\UserAdress;
use App\Form\UserAdressType;
use App\Form\FormAccount\UserType;
use App\Repository\OptionBijouRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class PanierController extends AbstractController
{

  public function __construct(SessionInterface $session)
  {

    $this->session = $session;
  }

  public function menu(Request $request)
  {
    $session =  $request->getSession();
    if (!$session->has('panier')) {
      $items = 0;
      $this->redirectToRoute('app_homepage');
    } else {
      $items = count($session->get('panier'));
    }

    return $this->render('panier/menu.html.twig', ['items' => $items]);
  }


  /**
   * @Route("/panier", name="panier")
   *
   * @return Response
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
    $role = ['ROLE_CLIENT'];

    $user = $user = $this->container->get('security.token_storage')->getToken()->getUser();
    $userAddresss = new UserAdress();
    $form = $this->createForm(UserAdressType::class, $userAddresss);

    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
      $manager = $this->getDoctrine()->getManager();

      $user->addRoles($role);
      $userAddresss->setUser($user);
      $manager->persist($userAddresss);
      $manager->flush();

      $this->addFlash('notice', "L'adresse a bien été ajouter");
      return $this->redirectToRoute('panier_livraison');
    }

    return $this->render('panier/livraison.html.twig', ['form' => $form->createView(), 'user' => $user]);
  }


  /**
   *
   * @Route("panier/validation/", name="panier_validation", requirements={"user"="\d+"} )
   * 
   */
  public function validationAction(Request $request)
  {


    if ($request == null) {
      $this->addFlash('warning', 'Votre panier est vide');
      $this->redirectToRoute('app_homepage');
    }

    if ($request->isMethod('POST'))
      $this->setLivraisonOnSession($request);

    $em = $this->getDoctrine()->getManager();

    $prepareCommande = $this->forward('Commandes:prepareCommande');

    $commande = $em->getRepository('App:Commandes')->find($prepareCommande->getContent());


    return $this->render('Panier:validation.html.twig', [
      'commande' => $commande

    ]);
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
