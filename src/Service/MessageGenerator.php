<?php

namespace App\Service;

use Psr\Log\LoggerInterface;

class MessageGenerator
{
  /**
   * @param  $logger
   */
  public function __construct(LoggerInterface $logger)
  {
    $this->logger = $logger;
  }



  public function getMessage()
  {
    $messages = ['
      Vous avez reçu un message
      '];
    $index = \array_rand($messages);

    return $messages[$index];
  }
}
