<?php

namespace App\Controller\FrontEnd;

use App\Entity\Produit;
use App\Entity\Boutique;
use App\Repository\BijouRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;


class ProduitController extends AbstractController
{
    /**
     * @Route("{boutique}/produit/{slug}", name="produit_show")
     * @ParamConverter("boutique", options={"mapping"= {"boutique" :"slug" }})
     */
    public function show(BijouRepository $bijouRepository, Produit $produit, Boutique $boutique, $slug): Response
    {
        $em = $this->getDoctrine()->getManager();

        $produit = $em->getRepository('App\Entity\Produit')
            ->findOneBy(['slug' => $slug]);

        $listeBijoux =  $bijouRepository->findAllByBoutique(['slug' => $boutique], $produit);

        return $this->render('produits/show.html.twig', ['produit' => $produit, 'listeBijoux' => $listeBijoux]);
    }
}
