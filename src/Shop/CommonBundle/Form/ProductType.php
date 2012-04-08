<?php

namespace Shop\CommonBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class ProductType extends AbstractType
{
    public function buildForm(FormBuilder $builder, array $options)
    {
        $builder
            ->add('deTranslation', new ProductTextType())
            ->add('enTranslation', new ProductTextType())
            ->add('image')
            ->add('price')
            ->add('salesEnd', 'date', array(
                'widget' => 'single_text',
                'format' => 'dd.mm.yyyy',
                'required' => false
            ))
            ->add('salesStart', 'date', array(
                'widget' => 'single_text',
                'format' => 'dd.mm.yyyy'
            ))
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
