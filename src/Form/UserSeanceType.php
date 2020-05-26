<?php

namespace App\Form;

use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\AbstractType;
use App\Entity\UserSeance;

class UserSeanceType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('gender', ChoiceType::class, [
                'label' =>'Genre',
                'choices' => [ 'Madame' => 'Madame' , 'Monsieur' => 'Monsieur']
            ])
            ->add('firstName', TextType::class, ['label' => 'Prénom'] )
            ->add('lastName', TextType::class, ['label' => 'Nom'] )
            ->add('email', EmailType::class, ['label' => 'Email'] )
            ->add('phone', TextType::class, ['label'=> 'Téléphone'])
           
          
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => UserSeance::class,
        ]);
    }
}
