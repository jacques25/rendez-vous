<?php

namespace App\Notification;

use Twig\Environment;
use Symfony\Component\Mime\Address;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use App\Entity\Contact;

class ContactNotication
{     
  private $mailer;
  private $renderer;
      public function __construct(MailerInterface $mailer,  Environment $renderer )
      {
          $this->mailer = $mailer;
          $this->renderer = $renderer;
      }
       public  function notify(Contact $contact){
            $contactEmail = $contact->getEmail();
            $name = ($contact->getFirstname() . ' ' .  $contact->getLastname());
            $phone = $contact->getPhone();
            $subject = $contact->getSubject();

           $mail = (new TemplatedEmail())
        ->from(new Address($contact->getEmail(), $name))
        ->to(new Address('jacques19611@live.fr', 'Rendez-vous Avec Soi'))
        ->subject($subject)
        ->htmlTemplate('email/email-contact.html.twig')
        ->context([
           'name' => $name,
            'contactEmail' => $contactEmail,
           'phone'=> $phone,
           'message'=> $contact->getMessage(),
           'subject' => $contact->getSubject()
        ]);



           $this->mailer->send($mail);
       }
}
