<?php

namespace Shop\CommonBundle\Repository;

use Shop\CommonBundle\Entity\Product;

class ProductRepository extends Repository
{
    /**
     * @return array
     */
    public function findAllPublished()
    {
        $query = $this->_em->createQuery("
            select p from Shop\CommonBundle\Entity\Product p
            where p.salesStart <= :now and (p.salesEnd is null or p.salesEnd > :now)
            order by p.salesStart desc
        ");

        $query->setParameter('now', new \DateTime());

        return $query->getResult();
    }

    public function findFeatured()
    {
        $query = $this->_em->createQuery("
            select p from Shop\CommonBundle\Entity\Product p
            where p.salesStart <= :now and (p.salesEnd is null or p.salesEnd > :now) and p.isFeatured = true
            order by p.salesStart desc
        ");

        $query->setParameter('now', new \DateTime());

        return $query->getResult();
    }

    /**
     * @param int $count
     * @return array
     */
    public function findNewest($count)
    {
        $query = $this->_em->createQuery("
            select p from Shop\CommonBundle\Entity\Product p
            where p.salesStart <= :now and (p.salesEnd is null or p.salesEnd > :now)
            order by p.salesStart desc
        ");

        $query->setMaxResults($count);
        $query->setParameter('now', new \DateTime());

        return $query->getResult();
    }

    /**
     * @param int $productId
     * @return Product|null;
     */
    public function findPublished($productId)
    {
        $query = $this->_em->createQuery("
            select p from Shop\CommonBundle\Entity\Product p
            where p.id = :id and p.salesStart <= :now and (p.salesEnd is null or p.salesEnd > :now)
        ");

        $query->setParameter('now', new \DateTime());
        $query->setParameter('id', $productId);
        $query->setMaxResults(1);

        $result = $query->getResult();

        return (count($result) > 0) ? $result[0] : null;
    }
}