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
     * @ORM\Column(name="password", type="string", length=90)
     * @var string
     */
    private $password;

    /**
     * @var string
     */
    private $plainPassword;

    /**
     * @ORM\Column(name="salt", type="string", length=32)
     * @var string
     */
    private $salt;

    public function __construct()
    {
        $this->setSalt(base_convert(sha1(uniqid(mt_rand(), true)), 16, 36));
    }

    /**
     * {@inheritdoc}
     */
    public function eraseCredentials()
    {
        $this->plainPassword = null;
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
     * @return string
     */
    public function getPlainPassword()
    {
        return $this->plainPassword;
    }

    /**
     * {@inheritdoc}
     */
    public function getRoles()
    {
        return array();
    }

    /**
     * {@inheritdoc}
     */
    public function getSalt()
    {
        return $this->salt;
    }

    /**
     * {@inheritdoc}
     */
    public function getUsername()
    {
        return $this->email;
    }

    /**
     * @param string $password
     * @return bool
     */
    public function hasPassword($password)
    {
        return $this->getPassword() === $password;
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
     * @param string $plainPassword
     */
    public function setPlainPassword($plainPassword)
    {
        $this->plainPassword = $plainPassword;
    }

    /**
     * @param string $salt
     */
    protected function setSalt($salt)
    {
        $this->salt = $salt;
    }
}
