<?php

namespace App\Security;

use App\Entity\User;
use App\Entity\Bijou;
use Prophecy\Argument\Token\TokenInterface;
use Symfony\Component\Security\Core\Security;

class BijouVoter extends Voter
{

  private $security;

  public function __construct(Security $security)
  {
    $this->security = $security;
  }

  const VIEW = 'view';
  const EDIT = 'edit';

  protected function supports($attribute, $subject)
  {
    if (!\in_array($attribute, [self::VIEW, self::EDIT])) {
      return false;
    }

    if (!$subject instanceof Bijou) {
      return false;
    }
    return true;
  }

  protected function voteAttribute($attribute, $subject, TokenInterface $token)
  {
    $user = $token->getUser();

    if (!$user instanceof User) {
      return false;
    }

    $bijou = $subject;
    switch ($attribute) {
      case self::VIEW:
        return $this->canView($bijou, $user);
      case self::EDIT:
        return $this->canEdit($bijou, $user);
    }
    throw new \LogicException('This code should not be reached');

    if ($this->security->isGranted('ROLE__ADMIN')) {
      return true;
    }
  }

  private function canView(Bijou $bijou, User $user)
  {
    if ($this->canEdit($bijou, $user)) {
      return true;
    }

    return !$bijou->isPrivate();
  }

  private function canEdit(Bijou $bijou, User $user)
  {
    return $user === $bijou->getOwner();
  }
}
