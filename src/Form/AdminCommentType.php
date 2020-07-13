<?php

namespace App\Form;

use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\AbstractType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use App\Entity\User;
use App\Entity\Comment;

class AdminCommentType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder 
          
            ->add('content', TextareaType::class,  [
                'label' => 'Votre commentaire'
            ])

            ->add('approved', ChoiceType::class, [
                'choices' => [
                    'Approuvé' => true,
                    'Désapprouvé' => false]
            ])
               
            ->add('createdAt', DateTimeType::class,  [
                'label' => 'Date de création',
                  'widget' => 'single_text',
                
            ])
           
            ->add('rating',  ChoiceType::class, [
                'label' => 'Note',
                'attr' => ['class' => 'star'],
                'choices' => [
                    '1' => '1',
                    '2'  => '2',
                    '3' => '3',
                    '4' => '4',
                    '5' => '5'
                    ]
            ])
           
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Comment::class,
        ]);
    }
}
