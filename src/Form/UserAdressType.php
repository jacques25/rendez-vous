<?php

namespace App\Form;

use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use App\Form\ApplicationType;
use App\Entity\UserAdress;

class UserAdressType extends ApplicationType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('firstName', TextType::class, $this->getConfiguration(false, "Prénom"))
            ->add('lastName', TextType::class, $this->getConfiguration(false, "Nom"))
            ->add('phone', TelType::class, $this->getConfiguration(false, "Téléphone"))
            ->add('street', TextType::class, $this->getConfiguration(false, "Rue"))
            ->add('complement', TextType::class, $this->getConfiguration(false, "Complément d'adresse", ['required' => false]))
            ->add('cp', TextType::class, $this->getConfiguration(false, "Code postal"))
            ->add('city', TextType::class, $this->getConfiguration(false, "Ville"))
            ->add('country', TextType::class, $this->getConfiguration(false, "Pays", ['required' => false]));
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => UserAdress::class,
            'id' => 'address'
        ]);
    }
}
