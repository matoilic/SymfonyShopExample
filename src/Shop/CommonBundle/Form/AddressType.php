<?php

namespace Shop\CommonBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class AddressType extends AbstractType
{
    public function buildForm(FormBuilder $builder, array $options)
    {
        $builder
            ->add('addressLine1')
            ->add('addressLine2', null, array('required' => false))
            ->add('city')
            ->add('company', null, array('required' => false))
            ->add('firstName', null, array('required' => false))
            ->add('lastName', null, array('required' => false))
            ->add('zipCode', 'text')
        ;
    }

    public function getDefaultOptions(array $options)
    {
        return array(
            'data_class' => 'Shop\CommonBundle\Entity\Address',
            'csrf_protection' => true,
            'csrf_field_name' => '_token'
        );
    }

    public function getName()
    {
        return 'shop_commonbundle_addresstype';
    }
}
