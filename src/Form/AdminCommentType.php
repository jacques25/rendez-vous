<?php

namespace App\Form;

use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\AbstractType;
use App\Entity\Comment;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;

class AdminCommentType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder 
            ->add('authorName', TextType::class, [
                'label' => 'Auteur'
            ]) 
            ->add('content', TextareaType::class,  [
                'label' => 'Votre commentaire'
            ])

            ->add('approved',CheckboxType::class,  [
                'label' => 'Approuver',
                  'required' => false,
                'attr' => ['class' => 'customCheckbox']
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
