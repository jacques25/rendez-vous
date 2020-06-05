<?php

namespace App\Form;

use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\BirthdayType;
use Symfony\Component\Form\AbstractType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use DateTime;
use App\Form\FormAccount\AccountType;
use App\Entity\User;
use App\Entity\Booking;

class UserSeanceType  extends AbstractType
{
       public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        ->add('beginAt', DateTimeType::class, [
            'widget' => 'single_text',
            'html5' => false
        ])
        ->add('user', AccountType::class)
           ;
           
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Booking::class,
            'csrf_protection' => true,
            'csrf_fieldname' => '_token',
            'csrf_token_id' => 'booking'
        ]);
    }
}
