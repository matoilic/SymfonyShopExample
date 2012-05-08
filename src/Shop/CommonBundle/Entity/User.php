<?php

namespace Shop\CommonBundle\Entity;

use Symfony\Component\Security\Core\User\UserInterface;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * Shop\CommonBundle\Entity\Category
 *
 * @ORM\Table(name="users")
 * @ORM\Entity(repositoryClass="Shop\CommonBundle\Repository\UserRepository")
 */
class User extends AbstractUser
{

}
