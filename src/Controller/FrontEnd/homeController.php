<?php

namespace App\Controller\FrontEnd;


use App\Controller\BaseController;
use App\Repository\PageRepository;
use App\Repository\ArticleRepository;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class homeController extends BaseController
{
  /**
   * @Route("/" ,  name="app_homepage")
   */

  public function home(PageRepository $pageRepository)
  {
    $page = $pageRepository->findOneBy(['slug' => 'presentation']);

    return $this->render('pages/accueil.html.twig', ['page' => $page]);
  }

  /**
   * @route("/qui-suis-je", name="qui_suis_je")
   */

  public function quiSuisJe(PageRepository $pageRepository)
  {
    $page = $pageRepository->findOneBy(['slug' => 'qui-suis-je']);

    return $this->render('pages/qui.html.twig', ['page' => $page]);
  }
  
  /**
   * @Route("/envoi-et-paiement", name="envoi_paiement")
   *
   * @param PageRepository $pageRepository
   * @return void
   */
  public function envoi(PageRepository $pageRepository){
    
    $page = $pageRepository->findOneBy(['slug' => 'envoi-et-paiement']);

    return $this->render('pages/legislation/envoi.html.twig', ['page' => $page]);

  }

  /**
   * @Route("/droit-de-retraction", name="droit_retraction")
   *
   * @param PageRepository $pageRepository
   * @return void
   */
  public function retraction(PageRepository $pageRepository){
    
    $page = $pageRepository->findOneBy(['slug' => 'droit-de-retraction']);
    
    return $this->render('pages/legislation/retraction.html.twig', ['page' => $page, 'title' => $page->getTitle()]);

  }

    /**
   * @Route("/mentions-legales", name="mentions-legales")
   *
   * @param PageRepository $pageRepository
   * @return void
   */
  public function mentions(PageRepository $pageRepository){
    
    $page = $pageRepository->findOneBy(['slug' => 'mentions-legales']);
    
    return $this->render('pages/legislation/mentions.html.twig', ['page' => $page, 'title' => $page->getTitle()]);

  }

    /**
   * @Route("/protection-des-donnees", name="protection_donnees")
   *
   * @param PageRepository $pageRepository
   * @return void
   */
  public function protection(PageRepository $pageRepository){
    
    $page = $pageRepository->findOneBy(['slug' => 'protection-des-donnees']);
    
    return $this->render('pages/legislation/protection.html.twig', ['page' => $page, 'title' => $page->getTitle()]);

  }
}
