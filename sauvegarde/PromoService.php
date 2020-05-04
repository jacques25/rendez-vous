<?php

namespace App\Service;

use Doctrine\ORM\EntityManagerInterface;
use App\Entity\OptionBijou;



class PromoService
{
    public function __construct(EntityManagerInterface $manager)
  {
    $this->manager = $manager;
  }

  public function findBy(OptionBijou $option_bijou = null)
  {
               
    return $this->manager->createQuery('SELECT p, r, ob FROM  App\Entity\Promo p JOIN p.reduce r  JOIN p.option_bijou ob  WHERE ob.id = ' . $option_bijou->getId())->getResult();
  } 
}
