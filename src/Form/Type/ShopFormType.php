<?php

namespace App\Form\Type;

use App\Form\Model\ShopDto;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ShopFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('location_id')
            ->add('latitude')
            ->add('longitude')
            ->add('address')
            ->add('id_google')
            ->add('shopData_id')
            ->add('phone')
            ->add('isWhatsapp')
            ->add('description')
            ->add('logo')
            ->add('category_id')
            ->add('category')

        ;}
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => ShopDto::class,
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
