<?php

namespace Shop\CommonBundle\Presenter;

use Shop\CommonBundle\Entity\Order;
use Shop\CommonBundle\Entity\OrderItem;
use Shop\CommonBundle\Presenter\PresenterFactory;

class OrderPresenter
{
    /**
     * @var array
     */
    private $items;

    /**
     * @var \Shop\CommonBundle\Entity\Order
     */
    private $order;

    /**
     * @var PresenterFactory
     */
    private $presenterFactory;

    public function __construct(Order $order, $locale, PresenterFactory $presenterFactory)
    {
        $this->order = $order;
        $this->presenterFactory = $presenterFactory;
    }

    /**
     * @return \Shop\CommonBundle\Entity\Address
     */
    public function getBillingAddress()
    {
        return $this->order->getBillingAddress();
    }

    /**
     * @return \Shop\CommonBundle\Entity\datetime
     */
    public function getCreatedAt()
    {
        return (clone $this->order->getCreatedAt());
    }

    /**
     * @return \Shop\CommonBundle\Entity\Customer
     */
    public function getCustomer()
    {
        return $this->order->getCustomer();
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->order->getId();
    }

    /**
     * @return boolean
     */
    public function getIsPaid()
    {
        return $this->order->getIsPaid();
    }

    /**
     * @return boolean
     */
    public function getIsShipped()
    {
        return $this->order->getIsShipped();
    }

    /**
     * @return \Doctrine\ORM\PersistentCollection
     */
    public function getItems()
    {
        if($this->items == null) {
            $this->items = $this->presenterFactory->present($this->order->getItems());
        }
        return $this->items;
    }

    /**
     * @return string
     */
    public function getOrderId()
    {
        return $this->order->getOrderId();
    }

    /**
     * @return \DateTime
     */
    public function getPaymentDue()
    {
        return $this->order->getPaymentDue();
    }

    /**
     * @return boolean
     */
    public function getPaymentFee()
    {
        return $this->order->getPaymentFee();
    }

    /**
     * @return boolean
     */
    public function getPaymentType()
    {
        return $this->order->getPaymentType();
    }

    /**
     * @return \Shop\CommonBundle\Entity\Address
     */
    public function getShippingAddress()
    {
        return $this->order->getShippingAddress();
    }

    /**
     * @return boolean
     */
    public function getShippingFee()
    {
        return $this->order->getShippingFee();
    }

    /**
     * @return boolean
     */
    public function getShippingType()
    {
        return $this->order->getShippingType();
    }

    /**
     * @return float
     */
    public function getTaxRate()
    {
        return $this->order->getTaxRate();
    }

    /**
     * @return float
     */
    public function getTotalAmount()
    {
        return $this->order->getTotalAmount();
    }
}
