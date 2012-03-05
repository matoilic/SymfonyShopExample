<?php

namespace Shop\CommonBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class CategoryType extends AbstractType
{
    public function buildForm(FormBuilder $builder, array $options)
    {
        $builder
            ->add('name')
        ;
    }

    public function getDefaultOptions(array $options)
    {
        return array(
            'data_class' => 'Shop\CommonBundle\Entity\Category',
            'csrf_protection' => true,
            'csrf_field_name' => '_token'
        );
    }

    public function getName()
    {
        return 'shop_commonbundle_categorytype';
    }
}
