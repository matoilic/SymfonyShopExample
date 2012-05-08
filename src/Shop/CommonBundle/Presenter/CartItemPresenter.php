<?php

namespace Shop\CommonBundle\Presenter;

use Shop\CommonBundle\Entity\Cart;
use Shop\CommonBundle\Entity\CartItem;
use Shop\CommonBundle\Entity\Product;

class CartItemPresenter
{
    /**
     * @var Cart
     */
    private $cart;

    /**
     * @var CartItem
     */
    private $cartItem;

    /**
     * @var Product
     */
    private $product;

    /**
     * @param CartItem $cartItem
     * @param string $locale
     * @param PresenterFactory $presenterFactory
     */
    public function __construct(CartItem $cartItem, $locale, PresenterFactory $presenterFactory)
    {
        $this->cartItem = $cartItem;
        $this->product = $presenterFactory->present($cartItem->getProduct());
        $this->cart = $presenterFactory->present($cartItem->getCart());
    }

    /**
     * @return \Shop\CommonBundle\Entity\Cart
     */
    public function getCart()
    {
        return $this->cart;
    }

    /**
     * @return float
     */
    public function getFinalUnitPrice()
    {
        return $this->cartItem->getFinalUnitPrice();
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->cartItem->getId();
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
        return $this->cartItem->getQuantity();
    }

    /**
     * @return float
     */
    public function getTotalAmount()
    {
        return $this->cartItem->getTotalAmount();
    }

    /**
     * @return float
     */
    public function getUnitDiscount()
    {
        return $this->cartItem->getUnitDiscount();
    }

    /**
     * @return float
     */
    public function getUnitPrice()
    {
        return $this->cartItem->getUnitPrice();
    }
}
