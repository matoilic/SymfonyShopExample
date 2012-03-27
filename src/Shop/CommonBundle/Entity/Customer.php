<?php

namespace Shop\CommonBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Shop\CommonBundle\Entity\Customer
 *
 * @ORM\Table(name="customers")
 * @ORM\Entity(repositoryClass="Shop\CommonBundle\Entity\CustomerRepository")
 */
class Customer extends User
{
    /**
     * @var Address
     *
     * @ORM\ManyToOne(targetEntity="Address")
     * @ORM\JoinColumn(name="address_id", referencedColumnName="id")
     * @Assert\NotBlank()
     */
    private $address;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\OneToMany(targetEntity="Order", mappedBy="customer")
     */
    private $orders;

    /**
     * @var int
     *
     * @ORM\Column(name="total_orders", type="integer")
     */
    private $totalOrders = 0;

    /**
     * @var float
     *
     * @ORM\Column(name="total_revenue", type="decimal", precision=20, scale=2)
     */
    private $totalRevenue = 0;

    public function __construct()
    {
        $this->orders = new ArrayCollection();
    }

    /**
     * @return \Shop\CommonBundle\Entity\Address
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * @return array
     */
    public function getOrders()
    {
        return $this->orders->toArray();
    }

    /**
     * @return int
     */
    public function getTotalOrders()
    {
        return $this->totalOrders;
    }

    /**
     * @return float
     */
    public function getTotalRevenue()
    {
        return $this->totalRevenue;
    }

    /**
     * @param \Shop\CommonBundle\Entity\Address $address
     */
    public function setAddress($address)
    {
        $address->setFirstName($this->getFirstName());
        $address->setLastName($this->getLastName());

        $this->address = $address;
    }

    public function setFirstName($firstName)
    {
        parent::setFirstName($firstName);
        if($this->getAddress() !== null) {
            $this->getAddress()->setFirstName($firstName);
        }
    }

    public function setLastName($lastName)
    {
        parent::setLastName($lastName);
        if($this->getAddress() !== null) {
            $this->getAddress()->setLastName($lastName);
        }
    }

    /**
     * @param int $totalOrders
     */
    public function setTotalOrders($totalOrders)
    {
        $this->totalOrders = $totalOrders;
    }

    /**
     * @param float $totalRevenue
     */
    public function setTotalRevenue($totalRevenue)
    {
        $this->totalRevenue = $totalRevenue;
    }
}
