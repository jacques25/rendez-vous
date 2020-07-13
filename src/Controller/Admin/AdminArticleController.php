<?php

namespace App\Controller\Admin;

use App\Entity\Article;
use App\Form\ArticleType;
use App\Repository\ArticleRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\AsciiSlugger;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/admin")
 */
class AdminArticleController extends AbstractController
{
    /**
     * @Route("/articles", name="admin.article.index", methods={"GET"})
     */
    public function index(ArticleRepository $articleRepository, PaginatorInterface $paginatorInterface, Request $request): Response
    {   
        $articles = $paginatorInterface->paginate(
             $articleRepository->findAll(),
             $request->query->getInt('page', 1),
              5
  
        );
        return $this->render('admin/article/index.html.twig', [
            'articles' => $articles
        ]);
    }

    /**
     * @Route("/article/new", name="admin.article.new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $article = new Article();
        $form = $this->createForm(ArticleType::class, $article);
        $form->handleRequest($request);
        if (!$this->isGranted('IS_AUTHENTICATED_FULLY')) {
            return  $this->redirectToRoute('account_login');
            $this->addFlash('danger', " Mais vous n' êtes pas connecté !");
        } elseif ($this->isGranted('IS_AUTHENTICATED_FULLY')) {
            if ($form->isSubmitted() && $form->isValid()) {
                $slugger = new AsciiSlugger();
                $article->setSlug($slugger->slug(strtolower($article->getTitle())));
                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($article);
                $entityManager->flush();

                return $this->redirectToRoute('admin.article.index');
            }

            return $this->render('admin/article/new.html.twig', [
                'article' => $article,
                'form' => $form->createView(),
            ]);
        }
        return $this->redirectToRoute('admin.article.index');
    }

    /**
     * @Route("/article/{id}/edit", name="admin.article.edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Article $article): Response
    {
        $form = $this->createForm(ArticleType::class, $article);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $article->setCreatedAt(new \DateTime());
            $slugger = new AsciiSlugger();
            $article->setSlug($slugger->slug(strtolower($article->getTitle())));
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('admin.article.index', [
                'id' => $article->getId(),
            ]);
        }

        return $this->render('admin/article/edit.html.twig', [
            'article' => $article,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="admin.article.delete", methods={"DELETE"})
     */
    public function delete(Request $request, Article $article): Response
    {
        if ($this->isCsrfTokenValid('delete' . $article->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($article);
            $entityManager->flush();
        }

        return $this->redirectToRoute('admin.article.index');
    }
}
