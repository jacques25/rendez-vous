<?php

namespace App\Controller\FrontEnd;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Knp\Component\Pager\PaginatorInterface;
use App\Repository\BijouRepository;
use App\Form\RechercheType;
use App\Entity\Recherche;
use App\Entity\Produit;
use App\Entity\DescriptionProduit;
use App\Entity\Boutique;

class ProduitController extends AbstractController
{
    /**
     * @Route("{boutique}/produit/{slug}", name="produit_show")
     * @ParamConverter("boutique", options={"mapping"= {"boutique" :"slug" }})
     */
    public function show(Request $request, BijouRepository $bijouRepository, Produit $produit, Boutique $boutique, $slug, PaginatorInterface $paginatorInterface): Response
    {  
        $search = new Recherche();
        $form = $this->createForm(RechercheType::class, $search);
        $form->handleRequest($request);
        $em = $this->getDoctrine()->getManager();

        $produit = $em->getRepository('App\Entity\Produit')
            ->findOneBy(['slug' => $slug]);
    
        $description = $em->getRepository(DescriptionProduit::class)->findByBoutique(['slug' =>$boutique], $produit);
      
        $listeBijoux = $paginatorInterface->paginate(
          $bijouRepository->findAllByBoutique(['slug' => $boutique], $produit),
        $request->query->getInt('page', 1),
        16
        );

        return $this->render('produits/show.html.twig', ['produit' => $produit, 'listeBijoux' => $listeBijoux, 'description' => $description , 'form' =>$form->createView()]);
    }

 
}
