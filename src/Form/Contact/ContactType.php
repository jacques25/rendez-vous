<?php

namespace App\Form\Contact;

use App\Entity\Contact;
use App\Form\ApplicationType;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class ContactType extends ApplicationType
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
      ->add('lastname', TextType::class, $this->getConfiguration(false, 'Nom'))
      ->add('firstname', TextType::class,  $this->getConfiguration(false, 'Prénom'))
      ->add('email', EmailType::class, $this->getConfiguration(false, 'Email'))
      ->add('phone', TextType::class, $this->getConfiguration(false, 'Téléphone'))
      ->add('subject', ChoiceType::class, $this->getConfiguration(false, 'Sujet', [
        'placeholder' => "Choisir l'objet de votre mail",
        'choices' => [

          'Renseignements' => 'Renseignements',
          'Livraison' => 'Livraison',
          'Bug' => 'Bug',
        ]
      ]))

      ->add('message', TextareaType::class, $this->getConfiguration(false, 'Message', [
        'attr' => [
          'rows' => 5,
          'placeholder' => 'Message'
        ]
      ]));
  }

  public function configureOptions(OptionsResolver $resolver)
  {
    $resolver->setDefaults([
      'data_class' => Contact::class
    ]);
  }
}
