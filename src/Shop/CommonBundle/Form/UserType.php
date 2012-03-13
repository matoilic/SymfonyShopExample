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
            ->add('password')
            ->add('salt')
            ->add('roles')
        ;
    }

    public function getName()
    {
        return 'shop_commonbundle_usertype';
    }
}
