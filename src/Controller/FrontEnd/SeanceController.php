<?php

namespace App\Controller\FrontEnd;

use App\Entity\Seance;
use App\Repository\SeanceRepository;
use App\Service\OptionSeanceService;
use App\Repository\SeanceOptionRepository;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class SeanceController extends AbstractController
{

  /**
   * @Route("/seance/{slug}", name="seance_show")
   *  
   */
  public function show($slug, SeanceRepository $repo, OptionSeanceService $optionSeanceService, SerializerInterface $serializer)
  {
    $seance = $repo->findOneBy(['slug' => $slug]);


    $options =  $optionSeanceService->findBy($seance);

    return $this->render('seances/show.html.twig', [
      'seance' => $seance,
      'options' => $options,

    ]);
  }
}
