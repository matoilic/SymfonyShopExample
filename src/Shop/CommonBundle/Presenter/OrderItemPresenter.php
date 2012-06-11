<?php

namespace Shop\CommonBundle\Presenter;

use Shop\CommonBundle\Entity\OrderItem;
use Shop\CommonBundle\Entity\Order;
use Shop\CommonBundle\Entity\Product;
use Shop\CommonBundle\Presenter\PresenterFactory;
use Shop\CommonBundle\Configuration\PresentedBy;

class OrderItemPresenter
{
    /**
     * @var Order
     */
    private $order;

    /**
     * @var \Shop\CommonBundle\Entity\OrderItem
     */
    private $orderItem;

    /**
     * @var PresenterFactory
     */
    private $presenterFactory;

    /**
     * @var Product
     */
    private $product;

    public function __construct(OrderItem $orderItem, $locale, PresenterFactory $presenterFactory)
    {
        $this->orderItem = $orderItem;
        $this->product = $presenterFactory->present($orderItem->getProduct());
        $this->presenterFactory = $presenterFactory;
    }

    /**
     * @return float
     */
    public function getFinalUnitPrice()
    {
        return $this->orderItem->getFinalUnitPrice();
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->orderItem->getId();
    }

    /**
     * @return \Shop\CommonBundle\Entity\Order
     */
    public function getOrder()
    {
        if($this->order == null) {
            $this->order = $this->presenterFactory->present($this->orderItem->getOrder());
        }

        return $this->order;
    }

    /**
     * @return \Shop\CommonBundle\Entity\Product
     */
    public function getProduct()
    {
        return $this->product;
    }

    /**
     * @return int
     */
    public function getQuantity()
    {
        return $this->orderItem->getQuantity();
    }

    /**
     * @return float
     */
    public function getTotalAmount()
    {
        return $this->orderItem->getTotalAmount();
    }

    /**
     * @return float
     */
    public function getUnitDiscount()
    {
        return $this->orderItem->getUnitDiscount();
    }

    /**
     * @return float
     */
    public function getUnitPrice()
    {
        return $this->orderItem->getUnitPrice();
    }
}
