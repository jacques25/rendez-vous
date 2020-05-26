<?php

namespace App\Form\Contact;

use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use App\Form\ApplicationType;
use App\Entity\Response;

class ResponseType extends ApplicationType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
          ->add('gender', ChoiceType::class, [
                 'choices' => [
                     'Madame' => 'Madame',
                     'Monsieur' => 'Monsieur'
                 ]
            ])
            ->add('firstname', TextType::class,  $this->getConfiguration( false,  'Prénom' ))
            ->add('lastname', TextType::class,  $this->getConfiguration( false,  'Nom') )
            ->add('email', EmailType::class,  $this->getConfiguration(' ' , 'Email'))
            ->add('subject', TextType::class) 
            ->add('message', TextareaType::class, $this->getConfiguration(' ',  'Message'))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Response::class,
        ]);
    }
}
