<?php

namespace App\Form;

use App\Entity\PopupTaille;

use Symfony\Component\Form\AbstractType;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class PopupTailleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', TextType::class, ['label' => 'titre'])
            ->add('popup', CKEditorType::class, [
                'label' => 'Trouvez votre taille',
                'config' => ['toolbar' => 'toolbar2']
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => PopupTaille::class,
        ]);
    }
}
