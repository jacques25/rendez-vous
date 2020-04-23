<?php

namespace App\Form;

use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\OptionsResolver\Options;
use Symfony\Component\Form\FormView;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\AbstractType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Jacques\ImageBundle\Form\Type\ImageType;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use App\Form\PhotoType;
use App\Entity\Produit;
use App\Entity\Category;
use App\Entity\Boutique;

class BoutiqueType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        //$edit = (null !== $builder->getData()->getPicture());
        $builder
            ->add('title')
           
            ->add('imageFile', ImageType::class, [
                'required' => false,
                'label' => false,
            ])

            ->add('category', EntityType::class, [
                'class' => Category::class,
                'choice_label' => 'title',
                'multiple' => false,
                'label' => 'Categories',
            ]);
    }

    public function buildView(FormView $view, FormInterface $form, array $options)
    {
        $view->vars['max_width'] = $options['max_width'];
        $view->vars['max_height'] = $options['max_height'];
        $view->vars['preview_width'] = $options['preview_width'];
        $view->vars['preview_height'] = $options['preview_height'];
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Boutique::class,
        ]);

        $resolver

            ->setDefault('max_width', 800)
            ->setDefault('max_height', 600)
            ->setDefault('preview_width', function (Options $options) {
                return sprintf('%dpx', $options['max_width']);
            })

            ->setDefault('preview_height', function (Options $options) {
                return sprintf('%dpx', $options['max_height']);
            });
    }
}
