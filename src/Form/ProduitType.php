<?php

namespace App\Form;

use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\AbstractType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Jacques\ImageBundle\Form\Type\ImageType;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use App\Entity\Produit;
use App\Entity\Boutique;
use App\Entity\DescriptionProduit;

class ProduitType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title')
        
            ->add('imageFile', ImageType::class, [
                'required' => false,
                'label' => false

            ])

            ->add('boutiques', EntityType::class, [
                'class' => Boutique::class,
                'by_reference' => false,
                'multiple' => true

            ])
             ->add('descriptionProduits', EntityType::class, [
                "required" => false,
                'class' => DescriptionProduit::class,
                'choice_label' => 'title',
                'multiple' => true,
                'expanded' => false
            ]);
            
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Produit::class,
        ]);
    }
}
