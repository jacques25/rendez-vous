<?php

namespace App\Security\Exceptions;

use Symfony\Component\Security\Core\Exception\AccountStatusException;

class AccountEnabledException extends  AccountStatusException
{
  /**
   * {@inheritdoc}
   */
  public function getMessageKey()
  {
    return 'Account is not activate.';
  }
}
