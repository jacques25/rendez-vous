<?php

namespace App\Form\FormAccount;

use App\Entity\User;
use App\Form\ApplicationType;
use Jacques\ImageBundle\Form\Type\ImageType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class ProfileType extends ApplicationType
{

  public function buildForm(FormBuilderInterface $builder, array $options)
  {
    $builder
      ->add('firstName', TextType::class, $this->getConfiguration("Prénom", "Votre prénom..."))
      ->add('lastName', TextType::class, $this->getConfiguration("Nom", "Votre nom de famille..."))
      ->add('email', EmailType::class, $this->getConfiguration("Email", "Votre adresse email..."))
      ->add('imageFile', ImageType::class, [
        'required' => false,
        'label' => false,
      ])

      ->add('introduction', TextType::class, $this->getConfiguration('Introduction', "Présentez vous en quelques mots..."))
      ->add('description', TextareaType::class, $this->getConfiguration("Description détaillée", "C'est le moment de vous présenter en détails !"));
  }

  public function configureOptions(OptionsResolver $resolver)
  {
    $resolver->setDefaults([
      'data_class' => User::class,
    ]);
  }
}
