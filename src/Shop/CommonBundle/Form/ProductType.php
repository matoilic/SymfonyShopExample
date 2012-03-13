<?php

namespace Shop\CommonBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class ProductType extends AbstractType
{
    public function buildForm(FormBuilder $builder, array $options)
    {
        $builder
            ->add('description')
            ->add('image')
            ->add('name')
            ->add('price')
            ->add('salesEnd')
            ->add('salesStart')
            ->add('category')
            ->add('stock')
        ;
    }

    public function getDefaultOptions(array $options)
    {
        return array(
            'data_class' => 'Shop\CommonBundle\Entity\Product',
            'csrf_protection' => true,
            'csrf_field_name' => '_token'
        );
    }

    public function getName()
    {
        return 'shop_commonbundle_producttype';
    }
}
