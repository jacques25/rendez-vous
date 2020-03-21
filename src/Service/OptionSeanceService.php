<?php

namespace App\Service;

use App\Entity\Seance;
use Doctrine\ORM\EntityManagerInterface;

class OptionSeanceService
{
  private $manager;


  public function __construct(EntityManagerInterface $manager)
  {
    $this->manager = $manager;
  }

  public function findBy(Seance $seance = null)
  {

    return $this->manager->createQuery('SELECT so, s FROM  App\Entity\SeanceOption so JOIN so.seance s  WHERE s.id = ' . $seance->getId())->getResult();
  }
}
