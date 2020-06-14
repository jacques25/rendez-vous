<?php

namespace App\Controller\FrontEnd;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Mime\Address;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use App\Repository\PageRepository;
use App\Form\Contact\ContactType;
use App\Entity\Contact;
use App\Notification\ContactNotication;

class FooterController extends AbstractController
{
    /**
     * @Route("/mentions-legales", name="mentions_legales")
     */

    public function mentions(PageRepository $pageRepository)
    {
        $page = $pageRepository->findOneBy(['slug' => 'mentions-legales']);
        return $this->render('pages/legislation/mentions.html.twig', ['page' => $page]);
    }

    /**
     * @Route("protections-des-donnees", name="protection_donnees")
     */
    public function protectionDonnees(PageRepository $pageRepository)
    {
        $page = $pageRepository->findOneBy(['slug' => 'protections-des-donnees']);
        return $this->render('pages/legislation/protection.html.twig', ['page' => $page]);
    }
    /**
     * @Route("droits-de-retractions", name="droit_retraction")
     */
    public function droitRetraction(PageRepository $pageRepository)
    {
        $page = $pageRepository->findOneBy(['slug' => 'droit-de-retraction']);
        return $this->render('pages/legislation/retraction.html.twig', ['page' => $page]);
    }

    /**
     * @Route("/envoi-et-paiement", name="envoi_paiement")
     */

    public function expedition(PageRepository $pageRepository)
    {
        $page = $pageRepository->findOneBy(['slug' => 'envoi-et-paiement']);
        return $this->render('pages/legislation/envoi.html.twig', ['page' => $page]);
    }
 
    /**
     * @Route("/me-contacter",  name="contact_me")
     * @param Contact $contact
     * @return Response
     */
    public function contact(Request $request, ContactNotication $contactNotication ): Response
    {
        $contact = new Contact();
        $form = $this->createForm(ContactType::class, $contact);
        $form->handleRequest($request);
       
           if ($request->isMethod('POST')) {
           
           
            $em = $this->getDoctrine()->getManager();
            $em->persist($contact);
            $em->flush(); 
            $contactNotication->notify($contact); 
            $this->addFlash('success', ' Mail envoyé, nous vous répondrons dans les plus brefs délais.');
            return $this->redirectToRoute('app_homepage'); 
        }

        return $this->render('email/contact.html.twig', [
            'form' => $form->createView(), 
           'contact' => $contact
           ]);
    }
}
