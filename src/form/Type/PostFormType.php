<?php

namespace App\form\Type;

use App\Entity\Post;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PostFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title')
            ->add('post_content')
            ->add('image')
            ->add('shop_related')
            ->add('type_related')
            ->add('users_likes')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Post::class,
        ]);
    }

    public function getBlockPrefix(): string
    {
        return '';
    }

    public function getName(): string
    {
        return '';
    }
}
