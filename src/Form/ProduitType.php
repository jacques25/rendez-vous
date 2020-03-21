<?php

namespace App\Form;

use App\Entity\Produit;
use App\Entity\Boutique;
use Symfony\Component\Form\AbstractType;
use Jacques\ImageBundle\Form\Type\ImageType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;


class ProduitType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title')
            ->add('description')
            ->add('imageFile', ImageType::class, [
                'required' => false,
                'label' => false

            ])

            ->add('boutiques', EntityType::class, [
                'class' => Boutique::class,
                'by_reference' => false,
                'multiple' => true

            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Produit::class,
        ]);
    }
}
