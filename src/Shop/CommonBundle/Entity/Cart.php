<?php

namespace Shop\CommonBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Gedmo\Mapping\Annotation as Gedmo;
use Doctrine\ORM\PersistentCollection;

/**
 * Shop\CommonBundle\Entity\Order
 *
 * @ORM\Table(name="carts")
 * @ORM\Entity(repositoryClass="Shop\CommonBundle\Entity\CartRepository")
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
     * @ORM\OneToMany(targetEntity="CartItem", mappedBy="cart")
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

    /**
     * @param CartItem $item
     */
    public function addItem(CartItem $item)
    {
        if($this->containsProduct($item->getProduct())) {
            throw new \Exception('Cart contains product #' . $item->getProduct()->getId() . ' already');
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
     * @return int
     */
    public function getId()
    {
        return $this->id;
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
    public function getUpdatedAt()
    {
        return (clone $this->updatedAt);
    }

    /**
     * @param CartItem $item
     */
    public function removeItem(CartItem $item)
    {
        $this->items->remove($item);
    }
}
