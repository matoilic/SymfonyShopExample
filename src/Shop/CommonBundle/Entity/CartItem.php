<?php

namespace Shop\CommonBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Shop\CommonBundle\Entity\Order
 *
 * @ORM\Table(name="cart_items")
 * @ORM\Entity(repositoryClass="Shop\CommonBundle\Entity\CartItemRepository")
 */
class CartItem
{
    /**
     * @var Cart
     *
     * @ORM\ManyToOne(targetEntity="Cart", inversedBy="items")
     * @ORM\JoinColumn(name="cart_id", referencedColumnName="id", fetch="EAGER")
     * @Assert\NotBlank()
     */
    private $cart;

    /**
     * @var integer $id
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var Product
     *
     * @ORM\ManyToOne(targetEntity="Product")
     * @ORM\JoinColumn(name="product_id", referencedColumnName="id", fetch="EAGER")
     * @Assert\NotBlank()
     */
    private $product;

    /**
     * @var int
     *
     * @ORM\Column(name="quantity", type="integer")
     * @Assert\NotBlank()
     */
    private $quantity;

    /**
     * @var float
     *
     * @ORM\Column(name="unit_discount", type="decimal", precision=20, scale=2)
     * @Assert\NotEmpty()
     */
    private $unitDiscount;

    /**
     * @return \Shop\CommonBundle\Entity\Cart
     */
    public function getCart()
    {
        return $this->cart;
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
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
        return $this->quantity;
    }

    /**
     * @return float
     */
    public function getUnitDiscount()
    {
        return $this->unitDiscount;
    }

    /**
     * @param \Shop\CommonBundle\Entity\Cart $cart
     */
    public function setCart($cart)
    {
        $this->cart = $cart;
    }

    /**
     * @param \Shop\CommonBundle\Entity\Product $product
     */
    public function setProduct($product)
    {
        $this->product = $product;
    }

    /**
     * @param int $quantity
     */
    public function setQuantity($quantity)
    {
        $this->quantity = $quantity;
    }

    /**
     * @param float $unitDiscount
     */
    public function setUnitDiscount($unitDiscount)
    {
        $this->unitDiscount = $unitDiscount;
    }
}
