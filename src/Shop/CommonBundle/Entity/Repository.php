<?php

namespace Shop\CommonBundle\Entity;

use Doctrine\ORM\EntityRepository;

abstract class Repository extends EntityRepository
{
    public function __destruct() {
        $this->getEntityManager()->flush();
    }

    /**
     * Detaches an entity from the Repository. Unsaved changes made to the entity if any
     * (including removal of the entity), will not be persisted to the database.
     * Entities which previously referenced the detached entity will continue to
     * reference it.
     *
     * @param object $entity The entity to detach.
     */
    public function detach($entity)
    {
        $this->getEntityManager()->detach($entity);
    }

    /**
     * Makes the given instance persistent.
     *
     * @param object $entity The instance to make managed and persistent.
     */
    public function persist($entity)
    {
        $this->getEntityManager()->persist($entity);
    }

    /**
     * Makes the given instance persistent and writes it immediately to the database.
     *
     * @param object $entity The instance to make managed and persistent.
     */
    public function persistImmediately($entity)
    {
        $this->persist($entity);
        $this->getEntityManager()->flush();
    }

    /**
     * Refreshes the persistent state of an entity from the database,
     * overriding any local changes that have not yet been persisted.
     *
     * @param object $entity The entity to refresh.
     */
    public function refresh($entity)
    {
        $this->getEntityManager()->refresh($entity);
    }

    /**
     * Removes an entity instance.
     *
     * A removed entity will be removed from the database..
     *
     * @param object $entity The entity instance to remove.
     */
    public function remove($entity)
    {
        $this->getEntityManager()->remove($entity);
    }
}
