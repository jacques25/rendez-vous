<?php

namespace App\Service;

use Knp\Snappy\Pdf;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Twig\Environment;
use Symfony\Component\Mailer\MailerInterface;

class Mailer
{
    private $mailer;
    private $twig;
    private $pdf;
    
    public function __construct(MailerInterface $mailer, Environment $twig, Pdf $pdf)
    {
      $this->mailer = $mailer;
      $this->twig = $twig;
      $this->pdf = $pdf;
    }

    public function attachPdf( $autor, $commande): TemplatedEmail
    {
           $html = $this->twig->render('email/email-commande-pdf.html.twig', ['commande' => $commande]);
           $pdf = $this->pdf->getOutputFromHtml($html);

          
    }
}
