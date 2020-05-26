<?php

namespace App\Notification;

use Twig\Environment;
use Symfony\Component\Validator\Constraints\DateTime;
use Symfony\Component\Mime\Address;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use App\Entity\Expedition;
use App\Repository\CommandesRepository;

class ExpeditionNotification
{
     private $mailer;
    private $renderer;
    private $commande;
      public function __construct(  MailerInterface $mailer,  Environment $renderer, CommandesRepository $commande )
      {
          $this->mailer = $mailer;
          $this->renderer = $renderer;
          $this->commande =  $commande;
      }
       public  function notify(Expedition $expedition, $id)
       {   
            $commande = $this->commande->find($id);
            $numeroCommande = $commande->getNumeroCommande();
            $contactEmail =  $expedition->getEmail();
            $streetAdress = $expedition->getStreet();
            $cp = $expedition->getCp();
            $city = $expedition->getCity();
            $cpCity = $cp . " " . $city;
            $gender = $expedition->getGender();
            $firstname = $expedition->getFirstname();
            $lastname = $expedition->getLastname();
            $name = $gender . " " . $firstname . " " . $lastname;
            $dateExpedition =  $expedition->getDateExpedition();
            $message = $expedition->getMessage();
            $subject  = $expedition->getSubject();
            
          if ($dateExpedition !== null) {
              $mail = (new TemplatedEmail())
        ->from(new Address('contact.client@rendezvous.fr', 'Rendez-vous Avec Soi'))
        ->to(new Address($contactEmail, $name))
        ->subject($subject)
        ->htmlTemplate('email/email-expedition.html.twig')
        ->context([
          'numeroCommande' => $numeroCommande,
          'dateExpedition' =>$dateExpedition,
           'name' => $name,
           'contactEmail' => $contactEmail,
           'address' => $streetAdress,
           'cpCity' => $cpCity,
           'message'=> $message,
           'subject' => $subject
         
        ]);
              
              $this->mailer->send($mail);
          }
           
       }
}
