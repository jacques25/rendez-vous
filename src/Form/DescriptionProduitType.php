<?php

namespace App\Form;

use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\AbstractType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use App\Entity\Produit;
use App\Entity\DescriptionProduit;
use App\Entity\Boutique;

class DescriptionProduitType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title')
                ->add('introduction', CKEditorType::class)
                ->add('produits', EntityType::class, [
                    'class' => Produit::class,
                    'choice_label' => 'title',
                    'multiple' => true,
                    'expanded' => false])
                ->add('boutiques', EntityType::class, [
                    'class' => Boutique::class,
                    'choice_label' => 'title',
                    'multiple' => true,
                    'expanded' => false])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => DescriptionProduit::class,
        ]);
    }
}
