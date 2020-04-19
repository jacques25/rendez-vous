<?php

namespace App\Service;


use Spipu\Html2Pdf\Html2Pdf;
use Symfony\Component\HttpFoundation\Response;

use Twig\Environment;

class GetFacture
{   
    private $twig;
   
    public function __construct(Environment $twig){
       $this->twig = $twig;
   }

    public function Facture($facture)
    {
        $html = $this->twig->render('user/default/facturePDF.html.twig', ['facture' => $facture]);

     
        $html2pdf = new Html2Pdf('P', 'A4', 'fr', array(0, 0, 0, 0));
        $html2pdf->pdf->setImageScale(100, 100, 'PNG');
        $html2pdf->pdf->setAuthor('Rendez-vous avec soi');


        $html2pdf->pdf->SetTitle('Facture ' . $facture->getNumeroCommande());
        $html2pdf->pdf->SetSubject('facture RDAVS');
        $html2pdf->pdf->SetKeywords('facture, Rendez-vous avec soi');
        $html2pdf->pdf->SetDisplayMode('fullpage');
        $html2pdf->writeHTML($html);
        $html2pdf->output('Facture.pdf');

        $response = new Response();
        $response->headers->set('Content-type', 'application/pdf');

        return $response;
    }
}
