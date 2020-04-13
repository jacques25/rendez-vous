<?php

namespace App\Controller\FrontEnd;

use App\Entity\Contact;
use App\Form\Contact\ContactType;
use Symfony\Component\Mime\Address;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/** @Route("/page")
 */
class PageController extends AbstractController
{
  /**
   * @Route("/contact", name="contact_me")
   *
   * @return Response
   */
  public function contactMe(Request $request, MailerInterface $mailer): Response
  {
    $contact = new Contact();

    $form = $this->createForm(ContactType::class, $contact);
    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
     
      $contactEmail = $contact->getEmail();
      $name = ($contact->getFirstname() . ' ' .  $contact->getLastname());
      $phone = $contact->getPhone();
      $subject = $contact->getSubject();

      $mail = (new TemplatedEmail())
        ->from(new Address($contact->getEmail(), $name))
        ->to(new Address('jacquesrodi84@gmail.com', 'Rendez-vous Avec Soi'))
        ->subject($subject)
        ->htmlTemplate('email/email-contact.html.twig')
        ->context( [
           'name' => $name,
            'contactEmail' => $contactEmail,
           'phone'=> $phone,
           'message'=> $contact->getMessage(),
           'subject' => $contact->getSubject()
        ]);



      $mailer->send($mail);



      $this->addFlash('success', 'Votre mail à été envoyé, nous vous répondrons dans les plus bref délais.');

      return $this->redirectToRoute('app_homepage');
    }
    return $this->render('pages/contact.html.twig', ['form' => $form->createView()]);
  }
}
