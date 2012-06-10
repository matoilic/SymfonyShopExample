<?php

namespace Shop\CommonBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Shop\CommonBundle\Configuration\PresentedBy;
use DateTime;

/**
 * Shop\CommonBundle\Entity\Product
 *
 * @ORM\Table(name="products")
 * @ORM\Entity(repositoryClass="Shop\CommonBundle\Repository\ProductRepository")
 * @ORM\HasLifecycleCallbacks
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
     * @var string used to handle the deletion of the image
     */
    private $_image;

    /**
     * @var UploadedFile
     *
     * @Assert\File(maxSize="6000000")
     */
    private $imageHandle;

    /**
     * @var bool
     *
     * @ORM\Column(name="is_featured", type="boolean")
     */
    private $isFeatured = false;

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
     * @param int $quantity
     */
    public function addStock($quantity)
    {
        $this->stock += $quantity;
    }

    /**
     * @param ProductText $text
     */
    public function addText(ProductText $text)
    {
        $this->texts->add($text);
    }

    /**
     * @param float $amount
     */
    public function addTotalRevenue($amount)
    {
        $this->totalRevenue = $amount;
    }

    /**
     * @param int $quantity
     */
    public function addTotalSales($quantity)
    {
        $this->totalSales += $quantity;
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
     * @return string
     */
    public function getImageDirectory()
    {
        return __DIR__ . '/../../../../web/' . $this->getImageWebDirectory();
    }

    /**
     * @return string
     */
    public function getImagePath()
    {
        if(count($this->getImage()) == 0) return null;
        $this->getImagePath() . $this->getImageWebPath();
    }

    /**
     * @return string
     */
    public function getImageWebDirectory()
    {
        return 'uploads/products/';
    }

    /**
     * @return string
     */
    public function getImageWebPath()
    {
        if(count($this->getImage()) == 0) return null;
        return $this->getImageWebDirectory() . $this->id . '-' . $this->getImage();
    }

    /**
     * @return UploadedFile
     */
    public function getImageHandle()
    {
        return $this->imageHandle;
    }

    /**
     * @return bool
     */
    public function getIsFeatured()
    {
        return $this->isFeatured;
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
     * @ORM\PostPersist()
     * @ORM\PostUpdate()
     */
    public function handleUpload()
    {
        if ($this->imageHandle === null) {
            return;
        }

        @mkdir($this->getImageDirectory(), 0755, true);
        $this->imageHandle->move($this->getImageDirectory(), $this->id . '-' . $this->getImage());

        unset($this->imageHandle);
    }

    /**
     * @ORM\PreRemove()
     */
    public function prepareImageDeletion()
    {
        $this->_image = $this->getImagePath();
    }

    /**
     * @ORM\PrePersist()
     * @ORM\PreUpdate()
     */
    public function preUpload()
    {
        if ($this->imageHandle !== null) {
            $this->setImage($this->imageHandle->getClientOriginalName());
        }
    }

    /**
     * @ORM\PostRemove()
     */
    public function removeImage()
    {
        if ($this->_image) {
            unlink($this->_image);
        }
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
     * @param ProductText $newText
     */
    public function setDeTranslation(ProductText $newText)
    {
        $this->updateTranslation('de', $newText);
    }

    /**
     * @param ProductText $newText
     */
    public function setEnTranslation(ProductText $newText)
    {
        $this->updateTranslation('en', $newText);
    }

    /**
     * Set image
     *
     * @param string $image
     */
    public function setImage($image)
    {
        $this->image = htmlentities($image);
    }

    /**
     * @param UploadedFile $handle
     */
    public function setImageHandle(UploadedFile $handle)
    {
        $this->imageHandle = $handle;
    }

    /**
     * @param bool $isFeatured
     */
    public function setIsFeatured($isFeatured)
    {
        $this->isFeatured = $isFeatured;
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

    /**
     * @param string $locale
     * @param ProductText $newText
     */
    public function updateTranslation($locale, ProductText $newText)
    {
        $text = $this->translate($locale);
        $text->setName($newText->getName());
        $text->setDescription($newText->getDescription());
    }
}