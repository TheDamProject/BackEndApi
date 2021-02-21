<?php

namespace App\Form\Type;

use App\Entity\PostType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TypeFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('type');
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => PostType::class,
        ]);
    }
    public function getName()
    {
        return '';

    }

    public function getBlockPrefix()
    {
        return '';
    }


}

