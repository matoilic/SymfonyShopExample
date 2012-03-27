<?php

namespace Shop\CommonBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Shop\CommonBundle\Entity\Order
 *
 * @ORM\Table(name="order_items")
 * @ORM\Entity(repositoryClass="Shop\CommonBundle\Entity\OrderItemRepository")
 */
class OrderItem
{
    /**
     * @var integer $id
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var Order
     *
     * @ORM\ManyToOne(targetEntity="Order", inversedBy="items", fetch="EAGER")
     * @ORM\JoinColumn(name="order_id", referencedColumnName="id")
     * @Assert\NotBlank()
     */
    private $order;

    /**
     * @var Product
     *
     * @ORM\ManyToOne(targetEntity="Product", fetch="EAGER")
     * @ORM\JoinColumn(name="product_id", referencedColumnName="id")
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
     * @ORM\Column(name="total_amount", type="decimal", precision=20, scale=2)
     * @Assert\NotEmpty()
     */
    private $totalAmount;

    /**
     * @var float
     *
     * @ORM\Column(name="unit_discount", type="decimal", precision=20, scale=2)
     * @Assert\NotEmpty()
     */
    private $unitDiscount;

    /**
     * @var float
     *
     * @ORM\Column(name="unit_price", type="decimal", precision=20, scale=2)
     * @Assert\NotEmpty()
     */
    private $unitPrice;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return \Shop\CommonBundle\Entity\Order
     */
    public function getOrder()
    {
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
        return $this->quantity;
    }

    /**
     * @return float
     */
    public function getTotalAmount()
    {
        return $this->totalAmount;
    }

    /**
     * @return float
     */
    public function getUnitDiscount()
    {
        return $this->unitDiscount;
    }

    /**
     * @return float
     */
    public function getUnitPrice()
    {
        return $this->unitPrice;
    }

    /**
     * @param \Shop\CommonBundle\Entity\Order $order
     */
    public function setOrder($order)
    {
        $this->order = $order;
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
     * @param float $totalAmount
     */
    public function setTotalAmount($totalAmount)
    {
        $this->totalAmount = $totalAmount;
    }

    /**
     * @param float $unitDiscount
     */
    public function setUnitDiscount($unitDiscount)
    {
        $this->unitDiscount = $unitDiscount;
    }

    /**
     * @param float $unitPrice
     */
    public function setUnitPrice($unitPrice)
    {
        $this->unitPrice = $unitPrice;
    }
}
