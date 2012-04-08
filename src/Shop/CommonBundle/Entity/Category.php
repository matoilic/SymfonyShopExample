<?php

namespace Shop\CommonBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;
use Shop\CommonBundle\Configuration\PresentedBy;

/**
 * Shop\CommonBundle\Entity\Category
 *
 * @ORM\Table(name="categories")
 * @ORM\Entity(repositoryClass="Shop\CommonBundle\Repository\CategoryRepository")
 * @PresentedBy("Shop\CommonBundle\Presenter\CategoryPresenter")
 */
class Category
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
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\OneToMany(targetEntity="Product", mappedBy="category")
     */
    private $products;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\OneToMany(targetEntity="CategoryText", mappedBy="category", cascade={"persist"})
     */
    private $texts;

    public function __construct()
    {
        $this->products = new ArrayCollection();
        $this->texts = new ArrayCollection();
    }

    public function __toString()
    {
        return $this->getDeTranslation()->getName();
    }

    /**
     * @param Product $product
     */
    public function addProduct(Product $product)
    {
        $this->products->add($product);
    }

    /**
     * @param CategoryText $text
     */
    public function addText(CategoryText $text)
    {
        $this->texts->add($text);
    }

    /**
     * @return CategoryText
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
     * @return array
     */
    public function getProducts()
    {
        return $this->products->toArray();
    }

    /**
     * @return array
     */
    public function getTexts()
    {
        return $this->texts->toArray();
    }

    /**
     * @param Product $product
     */
    public function removeProduct(Product $product)
    {
        $this->products->add($product);
    }

    /**
     * @param string $locale
     * @return CategoryText
     */
    public function translate($locale)
    {
        foreach($this->texts as $text) {
            if($text->getLocale() == $locale) {
                return $text;
            }
        }

        $text = new CategoryText();
        $text->setLocale($locale);
        $text->setCategory($this);
        $this->texts->add($text);

        return $text;
    }
}