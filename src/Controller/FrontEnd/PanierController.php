<?php

namespace App\Controller\FrontEnd;


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
}
