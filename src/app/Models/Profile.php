<?php
namespace App\Models;
// TODO: Archivo Modelo Perfil ...
// *: Importamos las classes necesarias ...
use Doctrine\ORM\Mapping as ORM;
/**
 * Profile
 *
 * @ORM\Table(name="profiles", uniqueConstraints={@ORM\UniqueConstraint(name="UNIQ_EF687F2E7927C74", columns={"dni"})})
 * @ORM\Entity
 */

class Profile extends Image
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;
    /**
     * @var string
     *
     * @ORM\Column(name="dni", type="string", length=255, nullable=true)
     */
    private $dni;

    /**
     * @var string
     *
     * @ORM\Column(name="firstname", type="string", length=255, nullable=true)
     */
    private $firstname;
    /**
     * @var string
     *
     * @ORM\Column(name="lastname", type="string", length=255, nullable=true)
     */
    private $lastname;
    /**
     * @var int
     *
     * @ORM\Column(name="phone", type="integer", nullable=true)
     */
    private $phone;
    /**
     * @var int
     *
     * @ORM\Column(name="mobile", type="integer", nullable=true)
     */
    private $mobile;
    /**
     * @var string
     *
     * @ORM\Column(name="gender", type="string", length=255, nullable=true)
     */
    private $gender;
    /**
     * @var \DateTime
     *
     * @ORM\Column(name="birthday", type="datetime", nullable=true)
     */
    private $birthday;
    /**
     * One Profile has One User.
     * @ORM\OneToOne(targetEntity="User", inversedBy="profile")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     */
    private $user;
    /**
     * @var \DateTime
     * @ORM\Column(name="updated_at", type="datetime", nullable=true)
     */
    private $updatedAt;

    /**
     * @var \DateTime
     * @ORM\Column(name="created_at", type="datetime", nullable=true)
     */
    private $createdAt;
    public function __construct() {
        $this->setUpdatedAt();
        $this->setCreatedAt();
    }
    /**
     * Get the value of id
     *
     * @return  int
     */
    public function getId()
    {
        return $this->id;
    }
    /**
     * Get the value of dni
     *
     * @return  string
     */
    public function getDni()
    {
        return $this->dni;
    }

    /**
     * Set the value of dni
     *
     * @param  string  $dni
     *
     * @return  self
     */
    public function setDni(string $dni)
    {
        $this->dni = $dni;

        return $this;
    }

    /**
     * Get the value of firstname
     *
     * @return  string
     */
    public function getFirstname()
    {
        return $this->firstname;
    }

    /**
     * Set the value of firstname
     *
     * @param  string  $firstname
     *
     * @return  self
     */
    public function setFirstname(string $firstname)
    {
        $this->firstname = $firstname;

        return $this;
    }

    /**
     * Get the value of lastname
     *
     * @return  string
     */
    public function getLastname()
    {
        return $this->lastname;
    }

    /**
     * Set the value of lastname
     *
     * @param  string  $lastname
     *
     * @return  self
     */
    public function setLastname(string $lastname)
    {
        $this->lastname = $lastname;

        return $this;
    }

    /**
     * Get the value of phone
     *
     * @return  int
     */
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * Set the value of phone
     *
     * @param  int  $phone
     *
     * @return  self
     */
    public function setPhone(int $phone)
    {
        $this->phone = $phone;

        return $this;
    }

    /**
     * Get the value of mobile
     *
     * @return  int
     */
    public function getMobile()
    {
        return $this->mobile;
    }

    /**
     * Set the value of mobile
     *
     * @param  int  $mobile
     *
     * @return  self
     */
    public function setMobile(int $mobile)
    {
        $this->mobile = $mobile;

        return $this;
    }

    /**
     * Get the value of gender
     *
     * @return  string
     */
    public function getGender()
    {
        return $this->gender;
    }

    /**
     * Set the value of gender
     *
     * @param  string  $gender
     *
     * @return  self
     */
    public function setGender(string $gender)
    {
        $this->gender = $gender;

        return $this;
    }

    /**
     * Get the value of birthday
     *
     * @return  \DateTime
     */
    public function getBirthday()
    {
        return $this->birthday;
    }

    /**
     * Set the value of birthday
     *
     * @param  \DateTime  $birthday
     *
     * @return  self
     */
    public function setBirthday(\DateTime $birthday)
    {
        $this->birthday = $birthday;

        return $this;
    }
    /**
     * Get one Profile has One User.
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Set one Profile has One User.
     *
     * @return  self
     */
    public function setUser(User $user)
    {
        $this->user = $user;

        return $this;
    }
}
