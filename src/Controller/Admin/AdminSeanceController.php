<?php

namespace App\Controller\Admin;

use App\Entity\Seance;
use App\Form\SeanceType;
use App\Repository\SeanceRepository;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\String\Slugger\AsciiSlugger;

/**
 * @Route("/admin")
 */
class AdminSeanceController extends AbstractController
{

    /**
     * @Route("/seances/liste", name="admin_seance_index", methods={"GET"})
     */
    public function index(SeanceRepository $seanceRepository): Response
    {
        return $this->render('admin/seance/index.html.twig', [
            'seances' => $seanceRepository->findAll(),
        ]);
    }

    /**
     * @Route("/seance/new", name="admin_seance_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $seance = new Seance();

        $form = $this->createForm(SeanceType::class, $seance);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $slugger = new AsciiSlugger();
            $seance->setSlug($slugger->slug(strtolower($seance->getTitle())));

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($seance);
            $entityManager->flush();

            return $this->redirectToRoute('admin_seance_index');
        }

        return $this->render('admin/seance/new.html.twig', [
            'seance' => $seance,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/seance/{id}", name="admin_seance_show", methods={"GET"})
     */
    public function show(Seance $seance): Response
    {
        return $this->render('admin_seance/show.html.twig', [
            'tarif_seance' => $seance,
        ]);
    }

    /**
     * @Route("/seance/{id}/edit", name="admin_seance_edit", methods={"GET","POST"})
     */
    public function edit($id, Request $request, Seance $seance): Response
    {
        $manager = $this->getDoctrine()->getManager();
        $seance = $manager->getRepository('App:Seance')->findOneBy(['id' => $id]);
        // original SeanceOption entity 
        $originalOptionSeance = new ArrayCollection();

        foreach ($seance->getSeanceOptions() as $seanceOption) {
            $originalOptionSeance->add($seanceOption);
        }


        $form = $this->createForm(SeanceType::class, $seance);
        $form->handleRequest($request);


        if ($form->isSubmitted() && $form->isValid()) {

            foreach ($originalOptionSeance as $seanceOption) {
                // check if the seanceOption is in the $seance->getSeanceOptions()

                if ($seance->getSeanceOptions()->contains($seanceOption) === false) {
                    $manager->remove($seanceOption);
                }
            }
            $slugger = new AsciiSlugger();
            $seance->setSlug($slugger->slug(strtolower($seance->getTitle())));
            $manager->flush();

            return $this->redirectToRoute('admin_seance_index');
        }

        return $this->render('admin/seance/edit.html.twig', [
            'seance' => $seance,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/seance/{id}", name="admin_seance_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Seance $seance): Response
    {
        if ($this->isCsrfTokenValid('delete' . $seance->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($seance);
            $entityManager->flush();
        }

        return $this->redirectToRoute('admin_seance_index');
    }
}
