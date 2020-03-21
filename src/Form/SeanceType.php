<?php

namespace App\Form;

use App\Entity\Seance;
use App\Entity\Category;
use App\Form\SeanceOptionType;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Jacques\ImageBundle\Form\Type\ImageType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;

class SeanceType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', TextType::class)
            ->add('description', CKEditorType::class, [
                'required' => false
            ])
            ->add('seanceOptions', CollectionType::class, [
                'label' => false,
                'entry_type' => SeanceOptionType::class,
                'entry_options' => [
                    'label' => false
                ],
                'by_reference' => false,
                'allow_add' => true,
                'allow_delete' => true
            ])

            ->add('category', EntityType::class, [
                'class' => Category::class,
                'choice_label' => 'title',
                'multiple' => false,
                'label' => 'Categories',
                'attr' => ['class' => 'select']
            ])
            ->add('imageFile', ImageType::class, [
                'label' => false,
                'required' => false
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Seance::class,
        ]);
    }
}
