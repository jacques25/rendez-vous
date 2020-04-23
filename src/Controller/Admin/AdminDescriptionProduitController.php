<?php

namespace App\Controller\Admin;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Knp\Component\Pager\PaginatorInterface;
use App\Repository\DescriptionProduitRepository;
use App\Form\DescriptionProduitType;
use App\Form\DescriptionProduit1Type;
use App\Entity\DescriptionProduit;

/**
 * @Route("/admin/description/produit")
 */
class AdminDescriptionProduitController extends AbstractController
{
    /**
     * @Route("/liste", name="admin_description_produit_index", methods={"GET"})
     */
    public function index(DescriptionProduitRepository $descriptionProduitRepository, Request $request , PaginatorInterface $paginatorInterface): Response
    {   
         $description_produits = $paginatorInterface->paginate(
               $descriptionProduitRepository->findAll(),
               $request->query->getInt('page', 1 ),
               5
         );
        return $this->render('admin/description_produit/index.html.twig', [
            'description_produits' => $description_produits,
        ]);
    }

    /**
     * @Route("/nouveau",  name="admin_description_produit_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $descriptionProduit = new DescriptionProduit();
        $form = $this->createForm(DescriptionProduitType::class, $descriptionProduit);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($descriptionProduit);
            $entityManager->flush();

            return $this->redirectToRoute('admin_description_produit_index');
        }

        return $this->render('admin/description_produit/new.html.twig', [
            'description_produit' => $descriptionProduit,
            'form' => $form->createView(),
        ]);
    }

   
    /**
     * @Route("/{id}/editer",  name="admin_description_produit_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, DescriptionProduit $descriptionProduit): Response
    {
        $form = $this->createForm(DescriptionProduitType::class, $descriptionProduit);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('admin_description_produit_index');
        }

        return $this->render('admin/description_produit/edit.html.twig', [
            'description_produit' => $descriptionProduit,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}/suppression", name="admin_description_produit_delete", methods={"DELETE"})
     */
    public function delete(Request $request, DescriptionProduit $descriptionProduit): Response
    {
        if ($this->isCsrfTokenValid('delete'.$descriptionProduit->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($descriptionProduit);
            $entityManager->flush();
        }

        return $this->redirectToRoute('admin_description_produit_index');
    }
}
