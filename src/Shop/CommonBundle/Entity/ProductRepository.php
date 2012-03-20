<?php

namespace Shop\CommonBundle\Entity;

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
        ");

        $query->setParameter('now', new \DateTime());

        return $query->getArrayResult();
    }
}