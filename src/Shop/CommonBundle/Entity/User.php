<?php

namespace Shop\CommonBundle\Entity;

use Symfony\Component\Security\Core\User\UserInterface;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Doctrine\ORM\PersistentCollection;

/**
 * Shop\CommonBundle\Entity\Category
 *
 * @ORM\Table(name="users")
 * @ORM\Entity(repositoryClass="Shop\CommonBundle\Entity\UserRepository")
 * @UniqueEntity(fields={"email"}, message="user.email.taken")
 */
class User implements UserInterface
{
    /**
     * @ORM\Column(name="email", type="string", length=120)
     * @Assert\NotBlank()
     * @var string
     */
    private $email;

    /**
     * @ORM\Column(name="first_name", type="string", length=80)
     * @Assert\NotBlank()
     * @var string
     */
    private $firstName;

    /**
     * @var integer $id
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(name="last_name", type="string", length=80)
     * @Assert\NotBlank()
     * @var string
     */
    private $lastName;

    /**
     * @ORM\Column(name="password", type="string", length=255)
     * @Assert\NotBlank()
     * @var string
     */
    private $password;

    /**
     * @ORM\ManyToMany(targetEntity="Role", inversedBy="users")
     * @ORM\JoinTable(name="roles_users", joinColumns={@ORM\JoinColumn(name="user_id", referencedColumnName="id")}, inverseJoinColumns={@ORM\JoinColumn(name="group_id", referencedColumnName="id")})
     * @var \Doctrine\ORM\PersistentCollection
     */
    private $roles;

    /**
     * @ORM\Column(name="salt", type="string", length=16)
     * @Assert\NotBlank()
     * @var string
     */
    private $salt;

    /**
     * {@inheritdoc}
     */
    public function eraseCredentials()
    {
        //nothing to do
    }

    /**
     * {@inheritdoc}
     */
    public function equals(UserInterface $user)
    {
        return ($user->getId() === $this->getId());
    }

    /**
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @return string
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

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
    public function getLastName()
    {
        return $this->lastName;
    }

    public function getName()
    {
        return $this->getFirstName() . ' ' . $this->getLastName();
    }

    /**
     * {@inheritdoc}
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * {@inheritdoc}
     */
    public function getRoles()
    {
        return $this->roles->toArray();
    }

    /**
     * {@inheritdoc}
     */
    public function getSalt()
    {
        // TODO: Implement getSalt() method.
    }

    /**
     * {@inheritdoc}
     */
    public function getUsername()
    {
        return $this->email;
    }

    /**
     * @param string $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }

    /**
     * @param string $firstName
     */
    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;
    }

    /**
     * @param string $lastName
     */
    public function setLastName($lastName)
    {
        $this->lastName = $lastName;
    }

    /**
     * @param string $password
     */
    public function setPassword($password)
    {
        $this->password = $password;
    }

    /**
     * @param string $salt
     */
    public function setSalt($salt)
    {
        $this->salt = $salt;
    }
}
