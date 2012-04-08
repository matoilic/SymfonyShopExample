<?php

namespace Shop\CommonBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * Shop\CommonBundle\Entity\Order
 *
 * @ORM\Table(name="orders")
 * @ORM\Entity(repositoryClass="Shop\CommonBundle\Repository\OrderRepository")
 */
class Order
{
    /**
     * @var Address
     *
     * @ORM\ManyToOne(targetEntity="Address")
     * @ORM\JoinColumn(name="billing_address_id", referencedColumnName="id")
     * @Assert\NotBlank()
     */
    private $billingAddress;

    /**
     * @var datetime $updated
     *
     * @ORM\Column(name="created_at", type="datetime")
     * @Gedmo\Timestampable(on="create")
     */
    private $createdAt;

    /**
     * @var Customer
     *
     * @ORM\ManyToOne(targetEntity="Customer", inversedBy="orders")
     * @ORM\JoinColumn(name="customer_id", referencedColumnName="id")
     * @Assert\NotBlank()
     */
    private $customer;

    /**
     * @var integer $id
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\OneToMany(targetEntity="OrderItem", mappedBy="order", cascade={"persist"})
     */
    private $items;

    /**
     * @var boolean
     *
     * @ORM\Column(name="is_paid", type="boolean")
     * @Assert\NotBlank()
     */
    private $isPaid = false;

    /**
     * @var boolean
     *
     * @ORM\Column(name="is_shipped", type="boolean")
     * @Assert\NotBlank()
     */
    private $isShipped = false;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="payment_due", type="date")
     * @Assert\NotBlank()
     */
    private $paymentDue;

    /**
     * @var Address
     *
     * @ORM\ManyToOne(targetEntity="Address")
     * @ORM\JoinColumn(name="shipping_address_id", referencedColumnName="id")
     * @Assert\NotBlank()
     */
    private $shippingAddress;

    /**
     * @var float
     *
     * @ORM\Column(name="tax_rate", type="decimal", precision=4, scale=2)
     * @Assert\NotBlank()
     */
    private $taxRate = 8.0;

    /**
     * @var float
     *
     * @ORM\Column(name="total_amount", type="decimal", precision=20, scale=2)
     * @Assert\NotBlank()
     */
    private $totalAmount = 0;

    public function __construct()
    {
        $this->items = new ArrayCollection();
    }

    /**
     * @param OrderItem $item
     */
    public function addItem(OrderItem $item)
    {
        if($this->containsProduct($item->getProduct())) {
            throw new \Exception('Order contains product #' . $item->getProduct()->getId() . ' already');
        }

        $this->items->add($item);
    }

    /**
     * @param Product $product
     * @return bool
     */
    public function containsProduct(Product $product)
    {
        foreach($this->items as $item) {
            if($item->getProduct()->getId() == $product->getId()) {
                return true;
            }
        }

        return false;
    }

    /**
     * @return \Shop\CommonBundle\Entity\Address
     */
    public function getBillingAddress()
    {
        return $this->billingAddress;
    }

    /**
     * @return \Shop\CommonBundle\Entity\datetime
     */
    public function getCreatedAt()
    {
        return (clone $this->createdAt);
    }

    /**
     * @return \Shop\CommonBundle\Entity\Customer
     */
    public function getCustomer()
    {
        return $this->customer;
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return boolean
     */
    public function getIsPaid()
    {
        return $this->isPaid;
    }

    /**
     * @return boolean
     */
    public function getIsShipped()
    {
        return $this->isShipped;
    }

    /**
     * @param Product $product
     * @return null|OrderItem
     */
    public function getItemForProduct(Product $product)
    {
        foreach($this->items as $item) {
            if($item->getProduct()->getId() == $product->getId()) {
                return $item;
            }
        }

        return null;
    }

    /**
     * @return \Doctrine\ORM\PersistentCollection
     */
    public function getItems()
    {
        return $this->items->toArray();
    }

    /**
     * @return \DateTime
     */
    public function getPaymentDue()
    {
        return $this->paymentDue;
    }

    /**
     * @return \Shop\CommonBundle\Entity\Address
     */
    public function getShippingAddress()
    {
        return $this->shippingAddress;
    }

    /**
     * @return float
     */
    public function getTaxRate()
    {
        return $this->taxRate;
    }

    /**
     * @return float
     */
    public function getTotalAmount()
    {
        return $this->totalAmount;
    }

    /**
     * @param OrderItem $item
     */
    public function removeItem(OrderItem $item)
    {
        $this->items->remove($item);
    }

    /**
     * @param \Shop\CommonBundle\Entity\Address $billingAddress
     */
    public function setBillingAddress($billingAddress)
    {
        $this->billingAddress = $billingAddress;
    }

    /**
     * @param \Shop\CommonBundle\Entity\Customer $customer
     */
    public function setCustomer($customer)
    {
        $this->customer = $customer;
    }

    /**
     * @param boolean $isPaid
     */
    public function setIsPaid($isPaid)
    {
        $this->isPaid = $isPaid;
    }

    /**
     * @param boolean $isShipped
     */
    public function setIsShipped($isShipped)
    {
        $this->isShipped = $isShipped;
    }

    /**
     * @param \DateTime $paymentDue
     */
    public function setPaymentDue($paymentDue)
    {
        $this->paymentDue = $paymentDue;
    }

    /**
     * @param \Shop\CommonBundle\Entity\Address $shippingAddress
     */
    public function setShippingAddress($shippingAddress)
    {
        $this->shippingAddress = $shippingAddress;
    }

    /**
     * @param float $taxRate
     */
    public function setTaxRate($taxRate)
    {
        $this->taxRate = $taxRate;
    }

    /**
     * @param float $totalAmount
     */
    public function setTotalAmount($totalAmount)
    {
        $this->totalAmount = $totalAmount;
    }
}
