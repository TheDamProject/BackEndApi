<?php

namespace App\Form\Type;

use App\Form\Model\PostDto;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PostFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title')
            ->add('type_id' , IntegerType::class)
            ->add('shopRelated_id', IntegerType::class)
            ->add('content')
            ->add('image')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => PostDto::class,
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
