<?php

namespace App\Notification;

use Twig\Environment;
use Symfony\Component\Mime\Address;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use App\Repository\BookingRepository;
use App\Entity\User;

use App\Entity\Booking;


class SeanceNotification
{
     private $mailer;
    private $renderer;
    private $bookingRepository;
      public function __construct(  MailerInterface $mailer,  Environment $renderer,   BookingRepository $bookingRepository)
      {
          $this->mailer = $mailer;
          $this->renderer = $renderer;
         
         $this->bookingRepository = $bookingRepository;
      }
       public  function notify($id, Booking $booking, User $user )
       {   
           
            $contactEmail =  $user->getEmail();
            $title = $booking->getTitle();
            $date = date_format($booking->getBeginAt(), 'd/m/Y');
            $begin  = date_format($booking->getBeginAt(), 'H:i');
            $end     =  date_format($booking->getEndAt(), 'H:i');
            $gender = $user->getGender();
            $firstname = $user->getFirstname();
            $lastname = $user->getLastname();
            $phone = $user->getPhone();
            $name = $gender . " " . $firstname . " " . $lastname; 
            
           
            $message = "Nous avons pris en compte votre demande de rendez-vous pour  le ". $date . ' de ' . $begin . ' à ' . $end . ' heure' ;
          
            $subject  = $title;
            
         
              $mail = (new TemplatedEmail())
        ->from(new Address('contact.client@rendezvous.fr', 'Rendez-vous Avec Soi'))
        ->to(new Address($contactEmail, $name))
        ->subject($subject)
        ->htmlTemplate('email/email-seance.html.twig')
        ->context([
          'booking' => $booking,
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
