<?php

namespace App\Form;

use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Jacques\ImageBundle\Form\Type\ImageType;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use App\Form\BookingType;
use App\Form\ApplicationType;
use App\Entity\Formation;
use App\Entity\Category;

class FormationType extends ApplicationType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', TextType::class, $this->getConfiguration('Titre',  'Titre'))
            ->add('description', CKEditorType::class, $this->getConfiguration('Description', 'Description...'))
            ->add('imageFile', ImageType::class, [
                'label' => false,
            ])
           
            ->add('prix', MoneyType::class, [
                'label' => 'Tarif'
            ])
              ->add('category', EntityType::class, [
                'class' => Category::class,
                'choice_label' => 'title',
                'multiple' => false,
                'label' => 'Choisir une catégorie',
                'attr' => ['class' => 'select']
            ])
            ->add('nb_users', IntegerType::class ,[
                'label' => 'Nombre de participants maximum'
            ])

            ->add('booking', CollectionType::class, [
                'entry_type' => BookingType::class,
                'by_reference' => false,
                'allow_add' => true,
                'allow_delete' => true,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Formation::class,
        ]);
    }
}
