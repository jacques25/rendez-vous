<?php

namespace App\Form;

use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TimeType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\AbstractType;

use App\Entity\SeanceOption;
use DateTime;
use Symfony\Component\Intl\DateFormatter\DateFormat\HourTransformer;

class SeanceOptionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('genre', ChoiceType::class, [
                'choices' => [
                    'Adulte' => 'Adulte',
                    'Adolescent' => "Adolescent",
                    'Enfant' => 'Enfant'
                ]
            ])
            ->add('prix',TextType::class)
            ->add('duree', TimeType::class)
            ;
       
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => SeanceOption::class,
        ]);
    }
}
