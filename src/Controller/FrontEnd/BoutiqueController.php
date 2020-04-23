<?php

namespace App\Controller\FrontEnd;

use App\Repository\BoutiqueRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/boutique")
 */
class BoutiqueController extends AbstractController
{
    /**
     * @Route("/{slug}", name="boutique_show", requirements={"slug": "[a-z-9\-]*"})
     */
    public function show(string $slug, Request $request, BoutiqueRepository $repo)
    {
       
        $boutique = $repo->findOneBySlug(['slug' => $slug]);


        return $this->render('boutique/show.html.twig', [
            'boutique' => $boutique,

            'current_menu' => 'boutique'
        ]);
    }
}
