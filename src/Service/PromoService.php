<?php

namespace App\Service;

use App\Entity\Bijou;
use Doctrine\ORM\EntityManagerInterface;

class PromoService
{
  private $manager;


  public function __construct(EntityManagerInterface $manager)
  {
    $this->manager = $manager;
  }

  public function findBy(Bijou $bijou = null)
  {

    return $this->manager->createQuery('SELECT pr, b FROM  App\Entity\Promo pr  JOIN pr.bijou b  WHERE b.id = ' . $bijou->getId())->getResult();
  }
}
