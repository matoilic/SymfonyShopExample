<?php

namespace Shop\CommonBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;
use Shop\CommonBundle\Configuration\PresentedBy;
use DateTime;

/**
 * Shop\CommonBundle\Entity\Product
 *
 * @ORM\Table(name="products")
 * @ORM\Entity(repositoryClass="Shop\CommonBundle\Repository\ProductRepository")
 * @PresentedBy("Shop\CommonBundle\Presenter\ProductPresenter")
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
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\OneToMany(targetEntity="ProductText", mappedBy="product", orphanRemoval=true, cascade={"all"})
     */
    private $texts;

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


    public function __construct()
    {
        $this->texts = new ArrayCollection();
    }

    /**
     * @param ProductText $text
     */
    public function addText(ProductText $text)
    {
        $this->texts->add($text);
    }

    /**
     * @return Category
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * @return ProductText
     */
    public function getDeTranslation()
    {
        return $this->translate('de');
    }

    /**
     * @return ProductText
     */
    public function getEnTranslation()
    {
        return $this->translate('en');
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
     * @return array
     */
    public function getTexts()
    {
        return $this->texts->toArray();
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
     * @param ProductText $text
     */
    public function removeText(ProductText $text)
    {
        $this->texts->removeElement($text);
    }

    /**
     * @param Category $category
     */
    public function setCategory(Category $category)
    {
        $this->category = $category;
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
     * @param float $price
     */
    public function setPrice($price)
    {
        $this->price = $price;
    }

    /**
     * @param \DateTime $salesEnd
     */
    public function setSalesEnd(DateTime $salesEnd = null)
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

    /**
     * @param string $locale
     * @return ProductText
     */
    public function translate($locale)
    {
        foreach($this->texts as $text) {
            if($text->getLocale() == $locale) {
                return $text;
            }
        }

        $text = new ProductText();
        $text->setLocale($locale);
        $text->setProduct($this);
        $this->texts->add($text);

        return $text;
    }
}