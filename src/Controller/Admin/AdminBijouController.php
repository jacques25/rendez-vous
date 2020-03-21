<?php

namespace App\Controller\Admin;

use DateTime;
use App\Entity\Bijou;
use App\Form\BijouType;
use App\Repository\BijouRepository;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\String\Slugger\AsciiSlugger;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/admin")
 */
class AdminBijouController extends AbstractController
{
    /**
     * @Route("/bijou/liste", name="admin_bijou_index", methods={"GET"})
     */
    public function index(BijouRepository $repository)
    {

        $bijous = $repository->findAll();

        return $this->render('admin/bijou/index.html.twig', [
            'bijous' => $bijous,
        ]);
    }

    /**
     * @Route("/bijou/new", name="admin_bijou_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $bijou = new Bijou();

        // original OptionBijou entity 
        $originalOptionBijou = new ArrayCollection();
        foreach ($bijou->getOptionBijou() as $optionBijou) {
            $originalOptionBijou->add($optionBijou);
        }
        $form = $this->createForm(BijouType::class, $bijou);
        $form->handleRequest($request);


        if ($form->isSubmitted() && $form->isValid()) {
            $manager = $this->getDoctrine()->getManager();
            $slugger = new AsciiSlugger();
            $bijou->setSlug($slugger->slug(strtolower($bijou->getTitle())));

            $bijou->setCreatedAt(new DateTime());
            $bijou->setUpdatedAt(new DateTime());

            $manager->persist($bijou);
            $manager->flush();

            return $this->redirectToRoute('admin_bijou_index');
        }

        return $this->render('admin/bijou/new.html.twig', [
            'bijou' => $bijou,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/bijou/{id}", name="admin_bijou_show", methods={"GET"})
     */
    public function show(Bijou $bijou): Response
    {
        return $this->render('admin/bijou/show.html.twig', [
            'bijou' => $bijou,
        ]);
    }

    /**
     * @Route("/bijou/{id}/edit", name="admin_bijou_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, $id, Bijou $bijou): Response
    {
        $manager = $this->getDoctrine()->getManager();
        $bijou = $manager->getRepository('App:Bijou')->findOneBy(['id' => $id]);

        // original OptionBijou entity 
        $originalOptionBijou = new ArrayCollection();

        foreach ($bijou->getOptionBijou() as $optionBijou) {
            $originalOptionBijou->add($optionBijou);
        }
        $form = $this->createForm(BijouType::class, $bijou);
        $form->handleRequest($request);



        if ($form->isSubmitted() && $form->isValid()) {
            //get rid of the ones that bijou got rid of in the interface(DOM)
            foreach ($originalOptionBijou as $optionBijou) {
                // check if the optionBijou is in the $bijou->getOptionBijou()
                if ($bijou->getOptionBijou()->contains($optionBijou) === false) {
                    $manager->remove($optionBijou);
                }
            }
            $slugger = new AsciiSlugger();
            $bijou->setSlug($slugger->slug(strtolower($bijou->getTitle())));
            $bijou->setUpdatedAt(new DateTime());
            $manager->flush();

            return $this->redirectToRoute('admin_bijou_index', [
                'id' => $bijou->getId(),
            ]);
        }

        return $this->render('admin/bijou/edit.html.twig', [
            'bijou' => $bijou,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/bijou/{id}", name="admin_bijou_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Bijou $bijou): Response
    {
        if ($this->isCsrfTokenValid('delete' . $bijou->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($bijou);
            $entityManager->flush();
        }

        return $this->redirectToRoute('admin_bijou_index');
    }
}
