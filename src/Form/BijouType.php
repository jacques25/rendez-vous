<?php

namespace App\Form;

use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Jacques\ImageBundle\Form\Type\ImageType;
use FOS\CKEditorBundle\Form\Type\CKEditorType;

use App\Form\PropertiesBijouType;
use App\Form\PromoType;
use App\Form\OptionBijouType;
use App\Form\ApplicationType;
use App\Entity\Produit;
use App\Entity\PopupTaille;
use App\Entity\Boutique;
use App\Entity\Bijou;

class BijouType extends ApplicationType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title')
            ->add('description', CKEditorType::class, [
                'config' => [
                    'height' => 300
                ],
                'label' => false
            ])
            ->add('imageFile', ImageType::class, [
                'required' => false,
                'label' => false,
            ])
            ->add('properties_bijou', PropertiesBijouType::class, [
                'label' => false

            ])
            ->add('option_bijou', CollectionType::class, $this->getConfiguration(false, '',  [
                'entry_type' => OptionBijouType::class,
                'by_reference' => false,
                'allow_add' => true,
                'allow_delete' => true,

            ]))
            ->add('pictureFiles', FileType::class, [
                'label' => false,
                'required' => false,
                'multiple' => true,

            ])


            ->add('produits', EntityType::class, [
                'label' => 'Produits',
                'class' =>  Produit::class,
                'choice_label' => 'title',
                'multiple' => true,

            ])
            ->add('boutiques', EntityType::class, [
                'label' => 'Boutiques',
                'class' =>  Boutique::class,
                'choice_label' => 'title',
                'multiple' => true,

            ])
            ->add('popuptailles', EntityType::class, [
                'attr' => ['id' => 'multiple'],
                'required' => false,
                'placeholder' => 'Choisir un tableau de conversion',
                'class' => PopupTaille::class,
                'label' => 'Conversion des tailles',
                'choice_label' => 'title',
                'multiple' => true,
                'expanded' => false

            ])
                ->add('promo', TextType::class, [
                  'required' => false,
                  'attr' => [ 
                  'placeholder'=> 'Libellé de promotion'
                  ]
                ])
             ->add('date_start', null ,[
                 'required' => false,
                  'label' => false,
                  'widget' => 'single_text',
                   'html5' => false,
                   'attr' => ['class' => 'datetimepicker', 'placeholder'=> 'Date de début' ],
                   'empty_data' => ' '
                 
            ])
            ->add('date_end',  null,  [
                'label' => 'Date de fin',
                'required' => false,
                 'widget' => 'single_text',
                 'html5' => false,
                 'attr' => ['class' => 'datetimepicker2'],
                 'empty_data' => ' '
                 
              
            ])
             ->add('port', MoneyType::class,  [
                'required' => false,
                'label' => 'Frais de livraison',
                'empty_data' => 2.00
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
                 'required' => false
            ])
            
            ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Bijou::class
        ]);
    }
}
