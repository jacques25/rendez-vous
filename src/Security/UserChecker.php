<?php

namespace App\Security;

use App\Entity\User;
use App\Entity\User as AppUser;
use App\Security\Exceptions\AccountEnabledException;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserCheckerInterface;
use Symfony\Component\Security\Core\Exception\AccountExpiredException;
use Symfony\Component\Security\Core\Exception\CustomUserMessageAuthenticationException;

class UserChecker implements UserCheckerInterface
{
  public function checkPreAuth(UserInterface $user)
  {
    if (!$user instanceof AppUser) {
      return;
    }

    // user is enabled, show a generic Account Not Found message.
    if (!$user->getEnabled()) {
      throw new CustomUserMessageAuthenticationException(
         'Votre compte n\'est pas activé.'
      );
    }
  }

  public function checkPostAuth(UserInterface $user)
  {
       $this->checkPreAuth($user);
  }
}
