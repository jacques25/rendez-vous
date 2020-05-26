<?php

namespace App\Form;


use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use App\Entity\Booking;
use Symfony\Component\Form\AbstractType;

class BookingType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder  
            ->add('title')
            ->add('beginAt', DateTimeType::class, [
                'attr' => ['class' => 'datetimepicker'],
                'label' => 'Début',
                'html5' => false,
                'widget' => 'single_text'
                ])
        
                    ->add('endAt', DateTimeType::class, [
                      'attr' => ['class' => 'datetimepicker'],
                      'label' => 'Fin',
                      'html5' => false,
                          'widget' => 'single_text'
                ])
            
           ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Booking::class,
        ]);
    }
}
