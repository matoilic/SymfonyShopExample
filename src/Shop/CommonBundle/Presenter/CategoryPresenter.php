<?php

namespace Shop\CommonBundle\Presenter;

use Shop\CommonBundle\Entity\Category;
use Shop\CommonBundle\Entity\CategoryText;

class CategoryPresenter
{
    /**
     * @var Category
     */
    private $category;

    /**
     * @var string
     */
    private $locale;

    /**
     * @var CategoryText
     */
    private $text;

    /**
     * @param Category $category
     * @param string $locale
     * @param PresenterFactory $presenterFactory
     */
    public function __construct(Category $category, $locale, PresenterFactory $presenterFactory)
    {
        $this->locale = $locale;
        $this->category = $category;
        $this->text = $category->translate($locale);
    }

    /**
     * @return integer
     */
    public function getId()
    {
        return $this->category->getId();
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->text->getName();
    }

    /**
     * @return array
     */
    public function getProducts()
    {
        return $this->category->getProducts();
    }

    /**
     * @return array
     */
    public function getTexts()
    {
        return $this->category->getTexts();
    }
}
