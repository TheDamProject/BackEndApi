<?php

namespace App\Form\Type;

use App\Form\Model\ShopDto;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ShopFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('location_id', IntegerType::class)
            ->add('shopCategory_id', IntegerType::class)
            ->add('data_collection',CollectionType::class,
                [
                'allow_add' => true,
                'allow_delete' => true,
                'entry_type' => ShopDataFormType::class
                ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => ShopDto::class,
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
