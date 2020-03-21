<?php

namespace App\Form;

use App\Entity\Bijou;
use App\Entity\Produit;
use App\Entity\Boutique;
use App\Form\ApplicationType;
use App\Form\OptionBijouType;
use App\Form\PropertiesBijouType;
use Symfony\Component\Form\AbstractType;
use Jacques\ImageBundle\Form\Type\ImageType;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;

class BijouType extends ApplicationType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title')
            ->add('description', CKEditorType::class, [
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
            ->add('promo', CheckboxType::class, [
                'required' => false,

            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Bijou::class
        ]);
    }
}
