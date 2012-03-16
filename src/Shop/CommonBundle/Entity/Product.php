<?php

namespace Shop\CommonBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use DateTime;

/**
 * Shop\CommonBundle\Entity\Product
 *
 * @ORM\Table(name="products")
 * @ORM\Entity(repositoryClass="Shop\CommonBundle\Entity\ProductRepository")
 */
class Product
{
    /**
     * @var Category
     *
     * @ORM\ManyToOne(targetEntity="Category", inversedBy="products")
     * @ORM\JoinColumn(name="category_id", referencedColumnName="id")
     * @Assert\NotBlank()
     */
    private $category;

    /**
     * @var text $description
     *
     * @ORM\Column(name="description", type="text")
     * @Assert\NotBlank()
     */
    private $description;

    /**
     * @var integer $id
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string $image
     *
     * @ORM\Column(name="image", type="string", length=255)
     */
    private $image;

    /**
     * @var string $name
     *
     * @ORM\Column(name="name", type="string", length=255)
     * @Assert\NotBlank()
     */
    private $name;

    /**
     * @var float
     *
     * @ORM\Column(name="price", type="decimal", precision=20, scale=2)
     * @Assert\NotBlank()
     */
    private $price;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="sales_end", type="date")
     */
    private $salesEnd;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="sales_start", type="date")
     * @Assert\NotBlank()
     */
    private $salesStart;

    /**
     * @var int
     *
     * @ORM\Column(name="stock", type="integer")
     * @Assert\NotBlank()
     */
    private $stock;

    /**
     * @var float
     *
     * @ORM\Column(name="total_revenue", type="decimal", precision=20, scale=2)
     */
    private $totalRevenue = 0;

    /**
     * @var int
     *
     * @ORM\Column(name="total_sales", type="integer")
     */
    private $totalSales = 0;

    /**
     * @return Category
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * Get description
     *
     * @return text
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Get image
     *
     * @return string
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return float
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * @return \DateTime
     */
    public function getSalesEnd()
    {
        return $this->salesEnd;
    }

    /**
     * @return \DateTime
     */
    public function getSalesStart()
    {
        return $this->salesStart;
    }

    /**
     * @return int
     */
    public function getStock()
    {
        return $this->stock;
    }

    /**
     * @return float
     */
    public function getTotalRevenue()
    {
        return $this->totalRevenue;
    }

    /**
     * @return int
     */
    public function getTotalSales()
    {
        return $this->totalSales;
    }

    /**
     * @param Category $category
     */
    public function setCategory(Category $category)
    {
        $this->category = $category;
    }

    /**
     * Set description
     *
     * @param text $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     * Set image
     *
     * @param string $image
     */
    public function setImage($image)
    {
        $this->image = $image;
    }

    /**
     * Set name
     *
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @param float $price
     */
    public function setPrice($price)
    {
        $this->price = $price;
    }

    /**
     * @param \DateTime $salesEnd
     */
    public function setSalesEnd(DateTime $salesEnd)
    {
        $this->salesEnd = $salesEnd;
    }

    /**
     * @param \DateTime $salesStart
     */
    public function setSalesStart(DateTime $salesStart)
    {
        $this->salesStart = $salesStart;
    }

    /**
     * @param int $stock
     */
    public function setStock($stock)
    {
        $this->stock = $stock;
    }

    /**
     * @param float $totalRevenue
     */
    public function setTotalRevenue($totalRevenue)
    {
        $this->totalRevenue = $totalRevenue;
    }

    /**
     * @param int $totalSales
     */
    public function setTotalSales($totalSales)
    {
        $this->totalSales = $totalSales;
    }
}