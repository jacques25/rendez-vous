<?php

namespace App\Service;


use Spipu\Html2Pdf\Html2Pdf;
use Symfony\Component\HttpFoundation\Response;

use Twig\Environment;

class GetCommande
{   
    private $twig;
   
    public function __construct(Environment $twig){
       $this->twig = $twig;
   }

    public function commande($commande)
    {
        $html = $this->twig->render('user/default/commandePDF.html.twig', ['commande' => $commande]);

     
        $html2pdf = new Html2Pdf('P', 'A4', 'fr', array(0, 0, 0, 0));
        $html2pdf->pdf->setImageScale(100, 100, 'PNG');
        $html2pdf->pdf->setAuthor('Rendez-vous avec soi');


        $html2pdf->pdf->SetTitle('Commande ' . $commande->getNumeroCommande());
        $html2pdf->pdf->SetSubject('Commande RDAVS');
        $html2pdf->pdf->SetKeywords('Commande, Rendez-vous avec soi');
        $html2pdf->pdf->SetDisplayMode('fullpage');
        $html2pdf->writeHTML($html);
        $html2pdf->output('Commande.pdf');

        $response = new Response();
        $response->headers->set('Content-type', 'application/pdf');

        return $response;
    }
}
