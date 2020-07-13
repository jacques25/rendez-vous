<?php

namespace App\Form;


use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Intl\NumberFormatter\NumberFormatter;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\AbstractType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use App\Entity\User;
use App\Entity\Comment;

class CommentType extends AbstractType
{
       
    public function buildForm(FormBuilderInterface $builder, array $options)
    {  
       
        
    
        $builder 
              ->add('user', EntityType::class, [
                  'label' => 'Auteur',
                  'class' => User::class,
                'choice_label' => 'firstName',
              ])   
             ->add('content', TextareaType::class)
             ->add('rating', NumberType::class, [
                  'label' => false,
                   'attr' => [
                        'class' =>'rating-control',
                   ],
                  
                  'rounding_mode' => \NumberFormatter::ROUND_HALFDOWN
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
