<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AppFixtures extends Fixture
{
    private $encoder;

    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }

    public function load(ObjectManager $manager)
    {
        $user = new User();

        $user->setFirstName('Jacques')
            ->setLastName('Rodi')
            ->setEmail('jacques19611@live.fr')
            ->setIntroduction("L'adminstrateur du site")
            ->setDescription("Je suis l'administraeur du site RVAS...")
            ->setSlug("jacques-rodi")
            ->setPassword($this->encoder->encodePassword($user, 'PeleMele84$'))
            ->setRoles(['ROLE_ADMIN']);
        $manager->persist($user);

        $manager->flush();
    }
}
