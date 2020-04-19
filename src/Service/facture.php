<?php

namespace App\Service;

use Spipu\Html2Pdf\Html2Pdf;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\DependencyInjection\ContainerInterface;

class facture
{
  public function __construct(ContainerInterface $container)
  {

    $this->container = $container;
  }

  public function Facture($facture)
  {
    $html = $this->container->get('templating')->render('user/default/facturePDF.html.twig', ['facture' => $facture]);


    $html2pdf = new Html2Pdf('P', 'A4', 'fr');
    $html2pdf->pdf->setImageScale(100, 100, 'PNG');
    $html2pdf->pdf->setAuthor('Rendez-vous avec soi');


    $html2pdf->pdf->SetTitle('Facture ' . $facture->getReference());
    $html2pdf->pdf->SetSubject('Facture RDAVS');
    $html2pdf->pdf->SetKeywords('facture, Rendez-vous avec soi');
    $html2pdf->pdf->SetDisplayMode('real');
    $html2pdf->writeHTML($html);
    $html2pdf->output('Facture.pdf');

    $response = new Response();
    $response->headers->set('Content-type', 'application/pdf');

    return $response;
  }
}
