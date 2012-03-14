<?php

namespace Shop\CommonBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class SessionType extends AbstractType
{
    public function buildForm(FormBuilder $builder, array $options)
    {
        $builder
            ->add('username', 'text', array('required' => true))
            ->add('password', 'password', array('required' => true))
        ;
    }

    public function getDefaultOptions(array $options)
    {
        return array(
            'csrf_protection' => true,
            'csrf_field_name' => '_token'
        );
    }

    public function getName()
    {
        return 'shop_commonbundle_sessiontype';
    }
}
