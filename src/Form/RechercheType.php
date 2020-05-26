<?php

namespace App\Form;

use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;

use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\AbstractType;
use App\Entity\Recherche;

class RechercheType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('reference',  TextType::class, [
                'required' => false,
                'label' => false,
                'attr' => ['placeholder' => 'Référence ex: 439-2']
            ])
            ->add('prix', TextType::class ,     [
                'required' => false,
                'label' => false,
                'attr' => ['placeholder' => 'Prix']
            ])
            ->add('title', TextType::class, [
                'required' => false,
                'label' => false,
                'attr' => ['placeholder' => ' article']
            ])
           
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Recherche::class,
            'method' => 'get',
            'csrf_protection' => false
        ]);
    }

    public function getBlockPrefix()
    {
         return '';
    }
}
