<?php

namespace App\Form\FormAccount;

use App\Entity\User;

use App\Form\ApplicationType;
use Jacques\ImageBundle\Form\Type\ImageType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class AccountType extends ApplicationType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('firstName', TextType::class)
            ->add('lastName', TextType::class)
            ->add('email', EmailType::class)
            ->add('imageFile', ImageType::class, [
                'required' => false,
                'label' => false,
            ])
            ->add('introduction', TextareaType::class, [
                'required' => false

            ])
            ->add('description', TextareaType::class, [
                'required' => false
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
            'csrf_protection' => true,
            'csrf_fieldname' => '_token',
            'csrf_token_id' => 'user_item'
        ]);
    }
}
