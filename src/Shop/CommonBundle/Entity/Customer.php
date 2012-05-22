<?php

namespace Shop\CommonBundle\Entity;

use Symfony\Component\Security\Core\User\UserInterface;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * Shop\CommonBundle\Entity\Customer
 *
 * @ORM\Table(name="customers")
 * @ORM\Entity(repositoryClass="Shop\CommonBundle\Repository\CustomerRepository")
 * @UniqueEntity(fields={"email"}, message="user.email.taken")
 */
class Customer implements UserInterface, \Serializable
{
    /**
     * @var Address
     *
     * @ORM\ManyToOne(targetEntity="Address", cascade={"all"})
     * @ORM\JoinColumn(name="address_id", referencedColumnName="id")
     * @Assert\NotBlank()
     */
    protected $address;

    /**
     * @ORM\Column(name="email", type="string", length=120)
     * @Assert\NotBlank()
     * @var string
     */
    protected $email;

    /**
     * @ORM\Column(name="first_name", type="string", length=80)
     * @Assert\NotBlank()
     * @var string
     */
    protected $firstName;

    /**
     * @var integer $id
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(name="last_name", type="string", length=80)
     * @Assert\NotBlank()
     * @var string
     */
    protected $lastName;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\OneToMany(targetEntity="Order", mappedBy="customer")
     */
    protected $orders;

    /**
     * @ORM\Column(name="password", type="string", length=90)
     * @var string
     */
    protected $password;

    /**
     * @var string
     */
    protected $plainPassword;

    /**
     * @ORM\Column(name="salt", type="string", length=32)
     * @var string
     */
    protected $salt;

    /**
     * @var int
     *
     * @ORM\Column(name="total_orders", type="integer")
     */
    protected $totalOrders = 0;

    /**
     * @var float
     *
     * @ORM\Column(name="total_revenue", type="decimal", precision=20, scale=2)
     */
    protected $totalRevenue = 0;

    public function __construct()
    {
        $this->orders = new ArrayCollection();
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
     * @return \Shop\CommonBundle\Entity\Address
     */
    public function getAddress()
    {
        return $this->address;
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

    /**
     * @return string
     */
    public function getName()
    {
        return $this->getFirstName() . ' ' . $this->getLastName();
    }

    /**
     * @return array
     */
    public function getOrders()
    {
        return $this->orders->toArray();
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
        return array('ROLE_IS_AUTHENTICATED');
    }

    /**
     * {@inheritdoc}
     */
    public function getSalt()
    {
        return $this->salt;
    }

    /**
     * @return int
     */
    public function getTotalOrders()
    {
        return $this->totalOrders;
    }

    /**
     * @return float
     */
    public function getTotalRevenue()
    {
        return $this->totalRevenue;
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
     * (PHP 5 &gt;= 5.1.0)<br/>
     * String representation of object
     * @link http://php.net/manual/en/serializable.serialize.php
     * @return string the string representation of the object or null
     */
    public function serialize()
    {
        return serialize(array(
            $this->email,
            $this->firstName,
            $this->id,
            $this->lastName,
            $this->password,
            $this->salt,
            $this->totalOrders,
            $this->totalRevenue
        ));
    }


    /**
     * @param \Shop\CommonBundle\Entity\Address $address
     */
    public function setAddress($address)
    {
        if($address != null) {
            $address->setFirstName($this->getFirstName());
            $address->setLastName($this->getLastName());
        }

        $this->address = $address;
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

        if($this->getAddress() !== null) {
            $this->getAddress()->setFirstName($firstName);
        }
    }

    /**
     * @param string $lastName
     */
    public function setLastName($lastName)
    {
        $this->lastName = $lastName;

        if($this->getAddress() !== null) {
            $this->getAddress()->setLastName($lastName);
        }
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

    /**
     * @param int $totalOrders
     */
    public function setTotalOrders($totalOrders)
    {
        $this->totalOrders = $totalOrders;
    }

    /**
     * @param float $totalRevenue
     */
    public function setTotalRevenue($totalRevenue)
    {
        $this->totalRevenue = $totalRevenue;
    }

    /**
     * (PHP 5 &gt;= 5.1.0)<br/>
     * Constructs the object
     * @link http://php.net/manual/en/serializable.unserialize.php
     * @param string $serialized <p>
     * The string representation of the object.
     * </p>
     * @return mixed the original value unserialized.
     */
    public function unserialize($serialized)
    {
        list(
            $this->email,
            $this->firstName,
            $this->id,
            $this->lastName,
            $this->password,
            $this->salt,
            $this->totalOrders,
            $this->totalRevenue
        ) = unserialize($serialized);

        return $serialized;
    }


}
