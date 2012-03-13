<?php

namespace Shop\CommonBundle\Entity;

use Symfony\Component\Security\Core\Role\RoleInterface;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Doctrine\ORM\PersistentCollection;

/**
 * Shop\CommonBundle\Entity\Category
 *
 * @ORM\Table(name="roles")
 * @ORM\Entity(repositoryClass="Shop\CommonBundle\Entity\RoleRepository")
 * @UniqueEntity(fields={"name"}, message="role.name.taken")
 */
class Role implements RoleInterface
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
     * @ORM\Column(name="name", type="string", length=20)
     * @Assert\NotBlank()
     * @var string
     */
    private $name;

    /**
     * @ORM\ManyToMany(targetEntity="User", inversedBy="roles")
     * @ORM\JoinTable(name="roles_users", joinColumns={@ORM\JoinColumn(name="role_id", referencedColumnName="id")}, inverseJoinColumns={@ORM\JoinColumn(name="user_id", referencedColumnName="id")})
     * @var \Doctrine\ORM\PersistentCollection
     */
    private $users;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Returns the role.
     *
     * This method returns a string representation whenever possible.
     *
     * When the role cannot be represented with sufficient precision by a
     * string, it should return null.
     *
     * @return string|null A string representation of the role, or null
     */
    public function getRole()
    {
        return $this->name;
    }

    /**
     * @return array
     */
    public function getUsers()
    {
        return $this->users->toArray();
    }

    /**
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @param  $users
     */
    public function setUsers($users)
    {
        $this->users = $users;
    }
}
