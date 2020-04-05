<?php

namespace App\Form;

use App\Entity\OptionBijou;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;



class OptionBijouType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('prix', MoneyType::class, [
                'label' => 'Price'
            ])
            ->add('reference', TextType::class)
            ->add('taille', TextType::class, [
                'required' => false,
            ])
            ->add(
                'dimensions',
                TextType::class,
                [
                    'required' => false
                ]
            )
            ->add('disponible', ChoiceType::class, [
                'label' => 'Disponible',
                'choices' => [
                    'disponible' => true,
                    'indisponible' => false
                ]



            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => OptionBijou::class,

        ]);
    }
}
