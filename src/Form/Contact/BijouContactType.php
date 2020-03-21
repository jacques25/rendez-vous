<?php

namespace App\Form\Contact;

use App\Entity\BijouContact;
use App\Form\ApplicationType;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class BijouContactType extends ApplicationType
{
  public function buildForm(FormBuilderInterface $builder, array $options)
  {
    $builder
      ->add('lastname', TextType::class, $this->getConfiguration(false, 'Prénom'))
      ->add('firstname', TextType::class,  $this->getConfiguration(false, 'Nom'))
      ->add('email', EmailType::class, $this->getConfiguration(false, 'Email'))
      ->add('phone', TextType::class, $this->getConfiguration(false, 'Téléphone'))
      ->add(
        'message',
        CKEditorType::class,
        $this->getConfiguration(false, 'Téléphone', ['config' => ['toolbar' => 'contact', 'height' => 180, 'uiColor' => '#c4f2f2']])

      );
  }

  public function configureOptions(OptionsResolver $resolver)
  {
    $resolver->setDefaults([
      'data_class' => BijouContact::class
    ]);
  }
}
