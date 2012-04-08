<?php

namespace Shop\CommonBundle\Presenter;

use Shop\CommonBundle\Entity\Product;
use Shop\CommonBundle\Entity\ProductText;

class ProductPresenter
{
    /**
     * @var string
     */
    private $locale;

    /**
     * @var Product
     */
    private $product;

    /**
     * @var ProductText
     */
    private $text;

    /**
     * @param Product $product
     * @param string $locale
     * @param PresenterFactory $presenterFactory
     */
    public function __construct(Product $product, $locale, PresenterFactory $presenterFactory)
    {
        $this->locale = $locale;
        $this->product = $product;
        $this->text = $product->translate($locale);
        $this->category = $presenterFactory->present($product->getCategory());
    }

    /**
     * @return \Shop\CommonBundle\Entity\Category
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return $this->text->getDescription();
    }

    /**
     * @return integer
     */
    public function getId()
    {
        return $this->product->getId();
    }

    /**
     * @return string
     */
    public function getImage()
    {
        return $this->product->getImage();
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->text->getName();
    }

    /**
     * @return float
     */
    public function getPrice()
    {
        return $this->product->getPrice();
    }

    /**
     * @return \DateTime
     */
    public function getSalesEnd()
    {
        return $this->product->getSalesEnd();
    }

    /**
     * @return \DateTime
     */
    public function getSalesStart()
    {
        return $this->product->getSalesStart();
    }

    /**
     * @return int
     */
    public function getStock()
    {
        return $this->product->getStock();
    }

    /**
     * @return array
     */
    public function getTexts()
    {
        return $this->product->getTexts();
    }

    /**
     * @return float
     */
    public function getTotalRevenue()
    {
        return $this->product->getTotalRevenue();
    }

    /**
     * @return int
     */
    public function getTotalSales()
    {
        return $this->product->getTotalSales();
    }
}
