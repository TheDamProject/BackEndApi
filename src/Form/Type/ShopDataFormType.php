<?php

namespace App\Form\Type;

use App\Entity\ShopData;
use App\Form\Model\ShopDataDto;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ShopDataFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('phone')
            ->add('isWhatsapp')
            ->add('description')
            ->add('logo')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => ShopDataDto::class,
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
