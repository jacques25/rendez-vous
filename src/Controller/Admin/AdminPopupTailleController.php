<?php

namespace App\Controller\Admin;

use App\Entity\PopupTaille;
use App\Form\PopupTailleType;
use App\Form\PopupTaille1Type;
use App\Repository\PopupTailleRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/admin")
 */
class AdminPopupTailleController extends AbstractController
{
    /**
     * @Route("/popup-taille/", name="admin_popup_taille_index", methods={"GET"})
     */
    public function index(PopupTailleRepository $popupTailleRepository): Response
    {
        return $this->render('admin/popup_taille/index.html.twig', [
            'popup_tailles' => $popupTailleRepository->findAll(),
        ]);
    }

    /**
     * @Route("/popup-taille/new", name="admin_popup_taille_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $popupTaille = new PopupTaille();
        $form = $this->createForm(PopupTailleType::class, $popupTaille);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($popupTaille);
            $entityManager->flush();

            return $this->redirectToRoute('admin_popup_taille_index');
        }

        return $this->render('admin/popup_taille/new.html.twig', [
            'popup_taille' => $popupTaille,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/popup-taille/{id}", name="admin_popup_taille_show", methods={"GET"})
     */
    public function show(PopupTaille $popupTaille): Response
    {
        return $this->render('admin/popup_taille/show.html.twig', [
            'popup_taille' => $popupTaille,
        ]);
    }

    /**
     * @Route("/popup-taille/{id}/edit", name="admin_popup_taille_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, PopupTaille $popupTaille): Response
    {
        $form = $this->createForm(PopupTailleType::class, $popupTaille);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('admin_popup_taille_index');
        }

        return $this->render('admin/popup_taille/edit.html.twig', [
            'popup_taille' => $popupTaille,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/popup-taille/{id}", name="admin_popup_taille_delete", methods={"DELETE"})
     */
    public function delete(Request $request, PopupTaille $popupTaille): Response
    {
        if ($this->isCsrfTokenValid('delete' . $popupTaille->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($popupTaille);
            $entityManager->flush();
        }

        return $this->redirectToRoute('admin_popup_taille_index');
    }
}
