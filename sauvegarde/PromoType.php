<?php

namespace App\Form;

use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\AbstractType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use App\Form\Type\DateTimePickerType;
use App\Entity\Reduce;
use App\Entity\Promo;

class PromoType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('date_start', null ,[
                  'label' => 'Date de début',
                  'widget' => 'single_text',
                   'html5' => false,
                   'attr' => ['class' => 'datetimepicker'],
                   'empty_data' => ' '
                 
            ])
            ->add('date_end',  null,  [
                'label' => 'Date de fin',
                 'widget' => 'single_text',
                 'html5' => false,
                 'attr' => ['class' => 'datetimepicker'],
                 'empty_data' => ' '
                 
              
            ])
            ->add('prix', TextType::class, [
                'label' => 'Prix bijou',
                'empty_data' => 00.00
            ])
            ->add('port', TextType::class,  [
                'label' => 'Frais de livraison',
                'empty_data' => 2.00
            ])
           ->add('reduce', EntityType::class, [
               'label' => 'Reduction',
               'class' => Reduce::class,
               'multiple' => false
           ])
            ->add('isActive', CheckboxType::class, [
                 'label' => 'En promo',
                 'required' => false
               
            ])
        ;
      
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Promo::class,
            
        ]);
    }
}
