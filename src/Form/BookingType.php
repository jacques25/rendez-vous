<?php

namespace App\Form;


use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\AbstractType;
use App\Entity\Booking;
use DateTime;

class BookingType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder  
            ->add('title')
            ->add('beginAt', DateTimeType::class, [
                'attr' => ['class' => 'beginAt'],
                'label' => 'Début',
                'widget' => 'single_text'
                ])
        
                    ->add('endAt', DateTimeType::class, [
                      'attr' => ['class' => 'endAt'],
                      'label' => 'Fin',
                       'widget' => 'single_text'
                ])
            
           ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Booking::class,
              'csrf_protection' => false,
           
        ]);
    }
}
