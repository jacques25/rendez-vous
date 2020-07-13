<?php

namespace App\Controller\FrontEnd;

use App\Entity\Category;
use App\Form\CategoryType;
use App\Repository\BoutiqueRepository;
use App\Repository\CategoryRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class MenuController extends AbstractController
{
    public function menu(CategoryRepository $repo, BoutiqueRepository $boutiqueRepository,  $limit)
    {


        $categories = $repo
            ->findAllOrderByRang(
                array(),
                $limit,
                0
            );
        $boutiques = $boutiqueRepository->findBoutiqueWithCategory();
       
        return $this->render(
            'partials/header.html.twig',
            [
                'categories' => $categories,
                'boutiques'  => $boutiques

            ]
        );
    }

  
}
