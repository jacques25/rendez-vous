<?php

namespace App\Notification;

use Twig\Environment;
use Symfony\Component\Validator\Constraints\DateTime;
use Symfony\Component\Mime\Address;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use App\Repository\FormationRepository;

use App\Entity\Booking;
use App\Entity\UserFormation;

class FormationNotification
{
     private $mailer;
    private $renderer;
    private  $formation; 
      public function __construct(  MailerInterface $mailer,  Environment $renderer,  FormationRepository $formation )
      {
          $this->mailer = $mailer;
          $this->renderer = $renderer;
         $this->formation = $formation;
      }
       public  function notify(Booking $booking, $id, UserFormation $user)
       {   
            $formation = $this->formation->find($id);
           
            $contactEmail =  $user->getEmail();
          
            $gender = $user->getGender();
            $firstname = $user->getFirstname();
            $lastname = $user->getLastname();
            $phone = $user->getPhone();
            $name = $gender . " " . $firstname . " " . $lastname; 
            $date_debut =  new DateTime($booking->getBeginAt());
            $date_fin = new DateTime($booking->getEndAt());
              
           
            $message = "Nous avons bien pris en compte votre inscription à notre prochaine formation le" 
            . $date_debut . "au ". $date_fin  ;
            $subject  = $formation->getTitle();
            
          if ($date_debut !== null) {
              $mail = (new TemplatedEmail())
        ->from(new Address('contact.client@rendezvous.fr', 'Rendez-vous Avec Soi'))
        ->to(new Address($contactEmail, $name))
        ->subject($subject)
        ->htmlTemplate('email/formation.html.twig')
        ->context([
          'formation' => $formation->getTitle(),
          'date_debut' =>$date_debut,
          'date_fin' => $date_fin,
           'name' => $name,
           'message'=> $message,
           'subject' => $subject,
           'contactEmail' => $contactEmail,
           'name' => $name,
           'message' => $message,
           'phone' => $phone
        ]);
              
              $this->mailer->send($mail);
          }
           
       }
}
