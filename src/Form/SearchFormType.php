<?php

namespace App\Form;

use App\Entity\Produit;
use App\Data\SearchData;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class SearchFormType   extends AbstractType
{

  public function buildForm(FormBuilderInterface $builder, array $options)
  {
    $builder
      ->add('q', TextType::class, [
        'label' => false,
        'required' => false,
        'attr' => [
          'placeholder' => 'Rechercher...'
        ]
      ])
      ->add('produits', EntityType::class, [
        'label' => false,
        'required' => false,
        'class' => Produit::class,
        'expanded' => true,
        'multiple' => true
      ])
      ->add('min', NumberType::class, [
        'label' => false,
        'required' => false,
        'attr' => [
          'placeholder' => 'Min'
        ]

      ])
      ->add('max', NumberType::class, [
        'label' => false,
        'required' => false,
        'attr' => [
          'placeholder' => 'Max'
        ]

      ])
      ->add('promo', CheckboxType::class, [
        'label' => 'En promotion',
        'required' => false,
      ]);
  }
  public function configureOptions(OptionsResolver $resolver)
  {
    $resolver->setDefaults([
      'data' => SearchData::class,
      'method' => 'GET',
      'csrf_protection' => false
    ]);
  }

  public function getBlockPrefix()
  {
    return  '';
  }
}