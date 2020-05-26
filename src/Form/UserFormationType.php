<?php

namespace App\Form;

use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\BirthdayType;
use App\Form\ApplicationType;
use App\Entity\UserFormation;
use App\Entity\User;
use Symfony\Component\Form\FormEvent;

class UserFormationType extends ApplicationType
{
     public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder  
          -> add('gender', ChoiceType::class, [
                   'choices' => [
                     'Madame' => "Madame" ,
                    'Monsieur'=> "Monsieur"
                   ],
                   'label' => 'Civilité'
             ])
             ->add('firstName', TextType::class, $this->getConfiguration('Prénom', "Votre prénom", ['attr' => ['class'=> 'form-control-sm']]))
            ->add('lastName', TextType::class, $this->getConfiguration("Nom", "Votre nom", ['attr' => ['class'=> 'form-control-sm']]))
            ->add('date_naissance', BirthdayType::class, [
                 'attr' => ['class'=> 'form-control-sm'],
                 'widget' => 'single_text',
                 ])
            ->add('email', EmailType::class, [ 
             
            ])
            
            ->add('phone', TextType::class, $this->getConfiguration(false, "ex: 04 58 78 98 10"))
            ;
        
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => UserFormation::class,
        ]);
    }
}
