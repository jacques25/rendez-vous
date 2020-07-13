<?php

namespace App\Form;

use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\BirthdayType;
use App\Form\FormAccount\AccountType;
use App\Entity\User;


class UserBookingType  extends AccountType
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
            ->add('firstName', TextType::class)
            ->add('lastName', TextType::class)
            ->add('email', EmailType::class)
            ->add('date_naissance', DateType::class, [
                'widget' => 'single_text',
                'html5' => false,
            ])
            ->add('phone', TelType::class);
          
           
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
           'csrf_protection' => false,
        ]);
    }
}
