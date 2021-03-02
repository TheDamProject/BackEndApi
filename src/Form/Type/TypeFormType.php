<?php

namespace App\Form\Type;

use App\Form\Model\PostTypeDto;
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
            'data_class' => PostTypeDto::class,
            'csrf_protection' => false,
        ]);
    }
    public function getName(): string
    {
        return '';

    }

    public function getBlockPrefix(): string
    {
        return '';
    }


}

