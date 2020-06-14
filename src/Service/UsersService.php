<?php

namespace App\Service;

use Symfony\Component\Security\Core\Security;

use Doctrine\ORM\EntityManagerInterface;
use App\Entity\User;
use App\Entity\Booking;
use Symfony\Component\ExpressionLanguage\Token;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class UsersService
{
     private $manager;

     private $tokenStorageInterface;
  public function __construct(EntityManagerInterface $manager, TokenStorageInterface $tokenStorageInterface)
  {
    $this->manager = $manager;
    $this->tokenStorageInterface = $tokenStorageInterface;

  }

  public function findBy(User $user = null)
  {
     $user = $this->tokenStorageInterface->getToken()->getUser();
    return $this->manager->createQuery('SELECT u.id  FROM  App\Entity\User u  WHERE u.id = ' . $user->getId())->getResult();
  }
}
