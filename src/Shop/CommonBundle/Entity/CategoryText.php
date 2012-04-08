<?php

namespace Shop\CommonBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Shop\CommonBundle\Entity\CategoryText
 *
 * @ORM\Table(name="category_texts")
 * @ORM\Entity()
 */
class CategoryText
{
    /**
     * @var Category
     *
     * @ORM\ManyToOne(targetEntity="Category", inversedBy="texts")
     * @ORM\JoinColumn(name="category_id", referencedColumnName="id")
     * @ORM\Id
     * @Assert\NotBlank()
     */
    private $category;

    /**
     * @var string $locale
     *
     * @ORM\Column(name="locale", type="string", length=2)
     * @ORM\Id
     * @Assert\NotBlank()
     */
    private $locale;

    /**
     * @var string $name
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @return \Shop\CommonBundle\Entity\Product
     */
    public function getCategory()
    {
        return $this->product;
    }

    /**
     * @return string
     */
    public function getLocale()
    {
        return $this->locale;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param \Shop\CommonBundle\Entity\Category $category
     */
    public function setCategory($category)
    {
        $this->category = $category;
    }

    /**
     * @param string $locale
     */
    public function setLocale($locale)
    {
        $this->locale = $locale;
    }

    /**
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }
}
