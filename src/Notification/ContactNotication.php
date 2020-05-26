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
               
               $gender = $contact->getGender();
               $contactEmail  = $contact->getEmail();
               $lastname = $contact->getLastname();
               $firstname= $contact->getFirstname();
               $username = $gender . " " .$lastname . " " . $firstname;
               $phone = $contact->getPhone();
               $subject = $contact->getSubject();
               $messageMail = $contact->getMessage();
        
        
               $mail = (new TemplatedEmail())
        ->from(new Address($contactEmail, $username))
        ->to(new Address('jacques19611@live.fr', 'Rendez-vous Avec Soi'))
        ->subject($subject)
        ->htmlTemplate('email/email-contact.html.twig')
        ->context([
           'name' => $username,
           'contactEmail' => $contactEmail,
           'phone'=> $phone,
           'messageMail'=> $messageMail,
           'subject' => $subject
        ]);
          

               $this->mailer->send($mail);
           }
       }
