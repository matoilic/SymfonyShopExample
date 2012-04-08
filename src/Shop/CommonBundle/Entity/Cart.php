<?php

namespace Shop\CommonBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Gedmo\Mapping\Annotation as Gedmo;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Shop\CommonBundle\Entity\CartItem;
use Shop\CommonBundle\Entity\Product;

/**
 * Shop\CommonBundle\Entity\Order
 *
 * @ORM\Table(name="carts")
 * @ORM\Entity(repositoryClass="Shop\CommonBundle\Repository\CartRepository")
 */
class Cart
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
     * @var \Doctrine\ORM\PersistentCollection
     *
     * @ORM\OneToMany(targetEntity="CartItem", mappedBy="cart", cascade={"persist"})
     */
    private $items;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="updated_at", type="datetime")
     * @Gedmo\Timestampable(on="update")
     * @Assert\NotBlank()
     */
    private $updatedAt;

    public function __construct()
    {
        $this->items = new ArrayCollection();
    }

    /**
     * @param \Shop\CommonBundle\Entity\CartItem $item
     */
    public function addItem(CartItem $item)
    {
        if($this->containsProduct($item->getProduct())) {
            throw new \Exception('Cart contains product #' . $item->getProduct()->getId() . ' already');
        }

        $this->items->add($item);
    }

    /**
     * @param \Shop\CommonBundle\Entity\Product $product
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
     * @param \Shop\CommonBundle\Entity\Product $product
     * @return null|\Shop\CommonBundle\Entity\CartItem
     */
    public function findItemForProduct(Product $product)
    {
        foreach($this->items as $item) {
            if($item->getProduct()->getId() == $product->getId()) {
                return $item;
            }
        }

        return null;
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return array
     */
    public function getItems()
    {
        return $this->items->toArray();
    }

    /**
     * @return float
     */
    public function getTotalAmount()
    {
        $total = 0.0;
        foreach($this->getItems() as $item) {
            $total += $item->getTotalAmount();
        }

        return $total;
    }

    /**
     * @return \DateTime
     */
    public function getUpdatedAt()
    {
        return (clone $this->updatedAt);
    }

    /**
     * @param \Shop\CommonBundle\Entity\CartItem $item
     */
    public function removeItem(CartItem $item)
    {
        $this->items->remove($item);
    }
}
