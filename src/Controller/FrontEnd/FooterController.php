<?php

namespace App\Controller\FrontEnd;

use App\Repository\PageRepository;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class FooterController extends AbstractController
{
  /**
   * @Route("/mentions-legales", name="mentions_legales")
   */

  public function mentions(PageRepository $pageRepository)
  {
    $page = $pageRepository->findOneBy(['slug' => 'mentions-legales']);
    return $this->render('pages/legislation/mentions.html.twig', ['page' => $page]);
  }

  /**
   * @Route("protections-des-donnees", name="protection_donnees")
   */
  public function protectionDonnees(PageRepository $pageRepository)
  {
    $page = $pageRepository->findOneBy(['slug' => 'protections-des-donnees']);
    return $this->render('pages/legislation/protection.html.twig', ['page' => $page]);
  }
  /**
   * @Route("droits-de-retractions", name="droit_retraction")
   */
  public function droitRetraction(PageRepository $pageRepository)
  {
    $page = $pageRepository->findOneBy(['slug' => 'droit-de-retraction']);
    return $this->render('pages/legislation/retraction.html.twig', ['page' => $page]);
  }

  /**
   * @Route("/envoi-et-paiement", name="envoi_paiement")
   */

  public function expedition(PageRepository $pageRepository)
  {
    $page = $pageRepository->findOneBy(['slug' => 'envoi-et-paiement']);
    return $this->render('pages/legislation/envoi.html.twig', ['page' => $page]);
  }
}
