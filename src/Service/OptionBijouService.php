<?php

namespace App\Service;

use App\Entity\Bijou;
use Doctrine\ORM\EntityManagerInterface;

class OptionBijouService
{
  private $manager;


  public function __construct(EntityManagerInterface $manager)
  {
    $this->manager = $manager;
  }

  public function findBy(Bijou $bijou = null)
  {

    return $this->manager->createQuery('SELECT ob, b FROM  App\Entity\OptionBijou ob  JOIN ob.bijou b  WHERE b.id = ' . $bijou->getId())->getResult();
  }
}