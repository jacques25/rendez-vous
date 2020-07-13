<?php

namespace App\Notification;

use Twig\Environment;
use Symfony\Component\Mime\Address;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use App\Repository\CommentRepository;
use App\Entity\User;

use App\Entity\Comment;
use App\Service\UsersService;

class CommentNotification
{
     private $mailer;
    private $renderer;
   
      public function __construct(  MailerInterface $mailer,  Environment $renderer )
      {
          $this->mailer = $mailer;
          $this->renderer = $renderer;
      
      }
       public  function notify(Comment $comment, User $user )
       {   
    
            $contactEmail =  $user->getEmail();
            
            $date = date_format($comment->getCreatedAt(), 'd/m/Y');
            $gender = $user->getGender();
            $firstname = $user->getFirstname();
            $lastname = $user->getLastname();
            $phone = $user->getPhone();
            $name = $gender . " " . $firstname . " " . $lastname; 
            
           
         
            if($comment->getFormation() != null ) {
               $subject  =  $comment->getFormation()->getTitle();   
               $messageCommentMail = "Nouveau commentaire sur la " . $comment->getFormation()->getTitle(). ' le ' .$date . " écrit par "  . $firstname. ' '  .$lastname  ;
           
            }
            if($comment->getSeance() != null) { 
                  $subject = $comment->getSeance()->getTitle();
                  $messageCommentMail = "Nouveau commentaire sur la  " . $comment->getSeance()->getTitle(). ' le ' .$date .   " écrit par "  . $firstname. ' '  .$lastname ;
            }
            
         
              $mail = (new TemplatedEmail())
        ->from(new Address($contactEmail, $name))
        ->to(new Address('client@rendezvous.fr', 'Rendez-vous Avec Soi'))
        ->subject($subject)
        ->htmlTemplate('email/email-comment.html.twig')
        ->context([
          'comment' => $comment,
           'name' => $name,
           'messageCommentMail'=> $messageCommentMail,
           'subject' => $subject,
           'contactEmail' => $contactEmail,
           'phone' => $phone
        ]);
              
              $this->mailer->send($mail);
          }
           
       
}
