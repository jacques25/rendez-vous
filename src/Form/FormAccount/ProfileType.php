<?php

namespace App\Form\FormAccount;

use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Jacques\ImageBundle\Form\Type\ImageType;
use App\Form\UserAdressType;
use App\Form\ApplicationType;
use App\Entity\User;
use Symfony\Component\Form\Extension\Core\Type\BirthdayType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;

class ProfileType extends ApplicationType
{

  public function buildForm(FormBuilderInterface $builder, array $options)
  {
    $builder
       ->add('gender', ChoiceType::class, [
                 'label' => 'Civilité',
                 'choices' => [
                     'Madame' => 'Madame',
                     'Monsieur' => 'Monsieur'
                 ]
            ])
      ->add('firstName', TextType::class, $this->getConfiguration("Prénom", "Votre prénom..."))
      ->add('lastName', TextType::class, $this->getConfiguration("Nom", "Votre nom de famille..."))
      ->add('email', EmailType::class, $this->getConfiguration("Email", "Votre adresse email..."))
      ->add('date_naissance', BirthdayType::class,  [
          'label' => 'Date Naissance',
          'widget' => 'single_text',
          'html5' => false,
          
      ])
      ->add('phone', TextType::class, ['label' => 'Téléphone'])
      ->add('imageFile', ImageType::class, [
        'required' => false,
        'label' => false,
        'attr' => ['id' => 'image-profile']
      ])

      ->add('addresses', CollectionType::class, [
        'label' => false,
        'entry_type' => UserAdressType::class,
        'allow_add' => true,
        'by_reference' => false,
        'allow_delete' => true

      ]);
  }

  public function configureOptions(OptionsResolver $resolver)
  {
    $resolver->setDefaults([
      'data_class' => User::class,
      'label' => false
    ]);
  }

  public function getName()
  {
    return 'Adresse';
  }
}
