<?php

namespace App\Service;

use Spipu\Html2Pdf\Html2Pdf;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\DependencyInjection\ContainerInterface;

class commande
{
  public function __construct(ContainerInterface $container)
  {

    $this->container = $container;
  }

  public function Commande($commande)
  {
    $html = $this->container->get('templating')->render('user/default/commandePDF.html.twig', ['commande' => $commande]);


    $html2pdf = new Html2Pdf('P', 'A4', 'fr');
    $html2pdf->pdf->setImageScale(100, 100, 'PNG');
    $html2pdf->pdf->setAuthor('Rendez-vous avec soi');


    $html2pdf->pdf->SetTitle('Facture ' . $commande->getReference());
    $html2pdf->pdf->SetSubject('Commande RDAVS');
    $html2pdf->pdf->SetKeywords('commande, Rendez-vous avec soi');
    $html2pdf->pdf->SetDisplayMode('real');
    $html2pdf->writeHTML($html);
    $html2pdf->output('Commande.pdf');

    $response = new Response();
    $response->headers->set('Content-type', 'application/pdf');

    return $response;
  }
}
