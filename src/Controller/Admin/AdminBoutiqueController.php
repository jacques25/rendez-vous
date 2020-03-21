<?php

namespace App\Controller\Admin;

use App\Entity\Boutique;
use App\Form\BoutiqueType;
use App\Repository\BoutiqueRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\AsciiSlugger;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/admin")
 */
class AdminBoutiqueController extends AbstractController
{
    /**
     * @Route("/boutique/categories", name="admin_boutique_index", methods={"GET"})
     */
    public function index(BoutiqueRepository $boutiqueRepository): Response
    {
        return $this->render('admin/boutique/index.html.twig', [
            'boutiques' => $boutiqueRepository->findAll(),
        ]);
    }

    /**
     * @Route("/boutique/new", name="admin_boutique_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $boutique = new Boutique();
        $form = $this->createForm(BoutiqueType::class, $boutique);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $slugger = new AsciiSlugger();
            $boutique->setSlug($slugger->slug($boutique->getTitle()));
            $entityManager->persist($boutique);
            $entityManager->flush();

            return $this->redirectToRoute('admin_boutique_index');
        }

        return $this->render('admin/boutique/new.html.twig', [
            'cat_boutique' => $boutique,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/boutique/{id}/edit", name="admin_boutique_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Boutique $boutique): Response
    {
        $form = $this->createForm(BoutiqueType::class, $boutique);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('admin_boutique_index', [
                'id' => $boutique->getId(),
            ]);
        }

        return $this->render('admin/boutique/edit.html.twig', [
            'boutique' => $boutique,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/boutique/delete/{id}", name="admin_boutique_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Boutique $boutique): Response
    {
        if ($this->isCsrfTokenValid('delete' . $boutique->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($boutique);
            $entityManager->flush();
        }

        return $this->redirectToRoute('admin_boutique_index');
    }
}
