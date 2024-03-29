<?php

namespace Shop\CommonBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class UserType extends AbstractType
{
    public function buildForm(FormBuilder $builder, array $options)
    {
        $builder
            ->add('email')
            ->add('firstName')
            ->add('lastName')
            ->add('plainPassword', 'password', array('required' => false))
        ;
    }

    public function getDefaultOptions(array $options)
    {
        return array(
            'data_class' => 'Shop\CommonBundle\Entity\User',
            'csrf_protection' => true,
            'csrf_field_name' => '_token'
        );
    }

    public function getName()
    {
        return 'shop_commonbundle_usertype';
    }
}
