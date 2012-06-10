<?php

namespace Shop\FrontendBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;
use Shop\CommonBundle\Form\AddressType;
use Shop\CommonBundle\Entity\Order;

class CheckoutType extends AbstractType
{
    public function buildForm(FormBuilder $builder, array $options)
    {
        $builder
            ->add('shipment', 'choice', array(
                'choices' => array(Order::SHIP_PRIORITY => 'checkout.shipment.priority', Order::SHIP_ECONOMY => 'checkout.shipment.economy'),
                'required' => false,
                'expanded' => true,
                'data' => 'p'
            ))
            ->add('payment', 'choice', array(
                'choices' => array(Order::PAY_INVOICE => 'checkout.payment.invoice', Order::PAY_CASH_ON_DELIVERY => 'checkout.payment.cod'),
                'required' => false,
                'expanded' => true,
                'data' => 'i'
            ))
            ->add('billingAddress', new AddressType())
            ->add('shippingAddress', new AddressType())
            ->add('differentShippingAddress', 'checkbox', array(
                'label' => 'checkout.differentShippingAddress',
                'required' => false
            ))
            ->add('termsAccepted', 'checkbox', array(
                'label' => 'checkout.terms.label',
                'required' => false
            ))
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
        return 'shop_frontendbundle_checkouttype';
    }
}
