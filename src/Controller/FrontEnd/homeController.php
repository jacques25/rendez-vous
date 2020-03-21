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
}
