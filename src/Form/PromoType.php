<?php

namespace App\Form;

use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\AbstractType;
use DateTime;
use App\Entity\Promo;

class PromoType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
                ->add('labelPromo', TextType::class, ['label' => 'Titre de la promotion'])
                ->add('slug')
                ->add('date_start', DateTimeType::class ,[
                 'required' => false,
                  'label' => false,
                  'widget' => 'single_text',
                 
                   'attr' => [ 'placeholder'=> 'Date de début' ],
                   'empty_data' => ' '
                 ])
              ->add('date_end',  null,  [
                'label' => 'Date de fin',
                'required' => false,
                 'widget' => 'single_text',
                 'attr' => [ 'placeholder' => 'Date de fin'],
                 'empty_data' => ' '
              ])
             ->add('port', MoneyType::class,  [
                'required' => false,
                'label' => 'Frais de livraison',
                'attr' => ['placeholder' => '2.00€']
            ])
           ->add('multiplicate', ChoiceType::class, [
                 'required' => false,
               'label' => 'Reduction',
               'choices' => [
                   '5%' => 0.95,
                   '10%' => 0.90,
                   '15%' => 0.85,
                   '20%' => 0.80,
                   '25%' => 0.75,
                   '30% ' => 0.70,
                   '35%' => 0.65,
                   '40%' => 0.60, 
                   '45%' => 0.55,
                   '50%' => 0.50,
                   '55%' => 0.45,
                   '60 %' => 0.40,
                   '65%' => 0.35,
                   '70%' => 0.30
               ]
                ])
                  ->add('promoIsActive', CheckboxType::class, [
                 'label' => 'En promo',
                'required' => false,
                'attr' => ['class' => 'checkbox']
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
