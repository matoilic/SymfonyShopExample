<?php

namespace Shop\FrontendBundle\Service;

use Symfony\Component\HttpFoundation\Session;
use Shop\CommonBundle\Entity\Cart;
use Shop\CommonBundle\Repository\CartRepository;
use Shop\CommonBundle\Entity\CartItem;
use Shop\CommonBundle\Entity\Product;

class CartService
{
    const CART_SESSION_KEY = '__cartId';

    /**
     * @var \Shop\CommonBundle\Entity\Cart
     */
    private $cart;

    /**
     * @var \Shop\CommonBundle\Repository\CartRepository
     */
    private $cartRepository;

    /**
     * @var \Symfony\Component\HttpFoundation\Session
     */
    private $session;

    public function __construct(Session $session, CartRepository $cartRepository)
    {
        $this->session = $session;
        $this->cartRepository = $cartRepository;

        if($this->session->get(self::CART_SESSION_KEY) === null) {
            $this->cart = new Cart();
        } else {
            $this->cart = $this->cartRepository->find($this->session->get(self::CART_SESSION_KEY));
        }
    }

    public function __destruct()
    {
        if(count($this->cart->getItems()) > 0 || $this->cart->getId() > 0) {
            $this->cartRepository->persistImmediately($this->cart);
            $this->session->set(self::CART_SESSION_KEY, $this->cart->getId());
            $this->session->save();
        }
    }

    /**
     * @param \Shop\CommonBundle\Entity\Product $product
     * @param int $quantity
     * @param float $unitDiscount
     */
    public function addToCart(Product $product, $quantity, $unitDiscount = 0.0)
    {
        if($this->cart->containsProduct($product)) {
            $item = $this->cart->findItemForProduct($product);
            $item->setQuantity($item->getQuantity() + $quantity);
        } else {
            $item = new CartItem();
            $item->setProduct($product);
            $item->setQuantity($quantity);
            $item->setUnitDiscount($unitDiscount);
            $item->setCart($this->cart);
            $this->cart->addItem($item);
        }
    }

    /**
     * For internal use only
     *
     * @return \Shop\CommonBundle\Entity\Cart
     */
    public function __exportCart()
    {
        return $this->cart;
    }

    /**
     * @return bool
     */
    public function getIsCartEmpty()
    {
        return count($this->cart->getItems()) == 0;
    }

    /**
     * @return CartItem|null
     */
    public function getItem(Product $product)
    {
        foreach($this->getItems() as $cartItem) {
            if($cartItem->getProduct()->getId() == $product->getId()) {
                return $cartItem;
            }
        }

        return null;
    }

    /**
     * @return array
     */
    public function getItems()
    {
        return $this->cart->getItems();
    }

    /**
     * @return float
     */
    public function getTotalAmount()
    {
        return $this->cart->getTotalAmount();
    }

    /**
     * @param \Shop\CommonBundle\Entity\Product $product
     * @return mixed
     */
    public function removeFromCart(Product $product)
    {
        if(!$this->cart->containsProduct($product)) {
            return;
        }

        $this->cart->removeItem($this->cart->findItemForProduct($product));
    }

    /**
     * @param \Shop\CommonBundle\Entity\Product $product
     * @param int $quantity
     */
    public function updateQuantity(Product $product, $quantity)
    {
        if($this->cart->containsProduct($product)) {
            $this->getItem($product)->setQuantity($quantity);
        }
    }
}
