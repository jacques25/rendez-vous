<?php

namespace App\Controller\FrontEnd;


use App\Repository\CategoryRepository;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/categorie")
 */
class CategoryController extends AbstractController
{
    /**
     * @Route("/liste", name="category.index")
     */
    public function index(CategoryRepository $repo)
    {
        $categories = $repo->findCategories();

        return $this->render('categories/index.html.twig', ['categories' => $categories]);
    }

    /**
     * @Route("/{slug}", name="category_show", requirements={"slug": "[a-z-9\-]*"})
     */
    public function show(string $slug, CategoryRepository $repository)
    {
        $category = $repository->findOneBySlug(['slug' => $slug]);

        return $this->render('categories/show.html.twig', [
            'category' => $category,
            'current_menu' => 'categories',
        ]);
    }
}
