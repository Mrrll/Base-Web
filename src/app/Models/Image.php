<?php
namespace App\Models;
// TODO: Archivo Modelo Image ...
// *: Importamos las classes necesarias ...
use Doctrine\ORM\Mapping as ORM;
/**
 * @ORM\Entity
 * @ORM\InheritanceType("JOINED")
 * @ORM\DiscriminatorColumn(name="discr", type="string")
 * @ORM\DiscriminatorMap({"profile" = "Profile", "image" = "Image"})
 */
class Image
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
     * @ORM\Column(name="url", type="string", length=255, nullable=true)
     */
    private $url;
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
     * Get the value of url
     *
     * @return  string
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * Set the value of url
     *
     * @param  string  $url
     *
     * @return  self
     */
    public function setUrl(string $url)
    {
        $this->url = $url;

        return $this;
    }

    /**
     * Get the value of updatedAt
     *
     * @return  \DateTime
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt->format('d-m-Y H:i:s');
    }

    /**
     * Set the value of updatedAt
     *
     * @param  \DateTime  $updatedAt
     *
     * @return  self
     */
    public function setUpdatedAt()
    {
        $this->updatedAt = new \DateTime('now');

        return $this;
    }

    /**
     * Get the value of createdAt
     *
     * @return  \DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt->format('d-m-Y H:i:s');
    }

    /**
     * Set the value of createdAt
     *
     * @param  \DateTime  $createdAt
     *
     * @return  self
     */
    public function setCreatedAt()
    {
        $this->createdAt = new \DateTime('now');;

        return $this;
    }
}
