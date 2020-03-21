<?php

namespace App\Form;

use App\Entity\PropertiesBijou;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PropertiesBijouType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('aimant')
            ->add('puissance_aimant')
            ->add('matiere')
            ->add('revetement')
            ->add('finition')
            ->add('couleur_pierre')
            ->add('couleur')
            ->add('autre_propriete');
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => PropertiesBijou::class,
        ]);
    }
}