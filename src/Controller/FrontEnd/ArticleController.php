<?php

namespace App\Controller\FrontEnd;

use App\Entity\Article;
use App\Repository\ArticleRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/article")
 */
class ArticleController extends AbstractController
{
    /**
     * @Route("/{slug}", name="article_show", requirements={"slug": "[a-z-9\-]*"})
     */
    public function show(ArticleRepository $articleRepository, string $slug, Request $request)
    {
        $article = $articleRepository->findOneBySlug(['slug' => $slug]);

        return $this->render('articles/show.html.twig', [
            'article' => $article,
            'current_menu' => 'article',
        ]);
    }
}
