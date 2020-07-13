<?php

namespace App\Form\Contact;

use Symfony\Component\Validator\Constraints\DateTime;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use App\Form\ApplicationType;
use App\Entity\Expedition;

class ExpeditionType extends ApplicationType
{
      public function buildForm(FormBuilderInterface $builder, array $options)
  {
    $builder
      ->add('gender', ChoiceType::class, [
                 'choices' => [
                     'Madame' => 'Madame',
                     'Monsieur' => 'Monsieur'
                 ]
            ])
    ->add('lastname', TextType::class)
      ->add('firstname', TextType::class)
      ->add('email', EmailType::class)
      ->add('street', TextType::class)
      ->add('cp', TextType::class)
      ->add('city', TextType::class)
         ->add('subject')
      ->add('message', TextareaType::class, $this->getConfiguration(false, 'Message',  ['attr' => [
          'rows' => 5,
          'placeholder' => 'Message'
        ]]))
      ->add('dateExpedition', DateTimeType::class,  [
        'widget' => 'single_text',
        'html5' => false,
        'label' => "Date d'expédition",
       
      ]);
  }

  public function configureOptions(OptionsResolver $resolver)
  {
    $resolver->setDefaults([
      'data_class' => Expedition::class
    ]);
  }
}
