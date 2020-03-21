<?php

namespace App\Controller\FrontEnd;

use App\Entity\Contact;
use App\Form\Contact\ContactType;
use Symfony\Component\Mime\Email;
use Symfony\Component\Mime\Message;
use Symfony\Component\Mime\RawMessage;
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
      $message =  '<h1> Objet: ' . $subject . '</h1><br><p> Nom: ' . $name . '</p><p> Téléphone: ' . $phone . '
                    </p><p> <h5>Message </h5>' . $contact->getMessage() . '</p>';

      $email = (new Email())
        ->from($contactEmail)
        ->To('jacques19611@live.fr')
        ->subject($subject)
        ->html($message);
      $mailer->send($email);

      $this->addFlash('success', 'Votre mail à été envoyé, nous vous répondrons dans les plus bref délais.');

      return $this->redirectToRoute('accueil');
    }
    return $this->render('pages/contact.html.twig', ['form' => $form->createView()]);
  }
}
