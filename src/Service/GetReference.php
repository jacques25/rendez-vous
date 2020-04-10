<?php

namespace App\Service;

use App\Entity\Commandes;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class GetReference
{
      public function __construct(TokenStorageInterface $securityContext, EntityManagerInterface $entityManager)
    {

        $this->securityContext = $securityContext;
        $this->em = $entityManager;
    }

    public function reference()
    {
        $reference = $this->em->getRepository(Commandes::class)->findOneBy(['valider' => 1], ['id' => 'DESC'], 1, 1);

        if (!$reference) {
            return 1;
        } else {
            return $reference->getNumeroCommande() + 1;
        }
    }
}
