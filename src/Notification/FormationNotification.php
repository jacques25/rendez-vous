<?php

namespace App\Notification;

use App\Entity\Formation;
use Twig\Environment;
use Symfony\Component\Mime\Address;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use App\Repository\FormationRepository;

use App\Repository\BookingRepository;
use App\Entity\User;


class FormationNotification
{
     private $mailer;
    private $renderer;
    private  $formation; 
    private $booking;
      public function __construct(  MailerInterface $mailer,  Environment $renderer,  FormationRepository $formation, BookingRepository $booking)
      {
          $this->mailer = $mailer;
          $this->renderer = $renderer;
         $this->formation = $formation;
         $this->booking = $booking;
      }
       public  function notify($id, Formation $formation, User $user )
       {   
           
            $contactEmail =  $user->getEmail();
           
             $formation = $this->formation->findOneBy(['id' => $id]);     
            $gender = $user->getGender();
            $firstname = $user->getFirstname();
            $lastname = $user->getLastname();
            $phone = $user->getPhone();
            $name = $gender . " " . $firstname . " " . $lastname; 
          
           
            $message = "Nous avons bien pris en compte votre inscription à notre prochaine formation " ;
          
            $subject  = $formation->getTitle();
            
         
              $mail = (new TemplatedEmail())
        ->from(new Address('contact.client@rendezvous.fr', 'Rendez-vous Avec Soi'))
        ->to(new Address($contactEmail, $name))
        ->subject($subject)
        ->htmlTemplate('email/email-formation.html.twig')
        ->context([
          'formation' => $formation,
           'name' => $name,
           'message'=> $message,
           'subject' => $subject,
           'contactEmail' => $contactEmail,
           'message' => $message,
           'phone' => $phone
        ]);
              
              $this->mailer->send($mail);
          }
           
       
}
