<?php

namespace App\Service;

use Doctrine\ORM\EntityManagerInterface;
use App\Entity\SeanceOption;

class BookingSeanceService
{
  private $manager;


  public function __construct(EntityManagerInterface $manager)
  {
    $this->manager = $manager;
  }

  public function findBy(SeanceOption $seanceOption = null)
  {

    return $this->manager->createQuery('SELECT b, so FROM  App\Entity\Booking b JOIN b.seanceOption so  WHERE so.id = ' . $seanceOption->getId())->getResult();
  }
}
