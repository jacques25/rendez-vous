<?php

namespace App\Service;

use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Formation;
use App\Entity\Booking;


class BookingService
{
  private $manager;


  public function __construct(EntityManagerInterface $manager)
  {
    $this->manager = $manager;
  }

  public function findBy(Booking $booking = null)
  {

    return $this->manager->createQuery('SELECT b FROM  App\Entity\Booking b  LEFT JOIN b.formation f  WHERE f.id = ' . $booking->getId())->getResult();
  }
}
