<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use JMS\Serializer\Annotation as Serializer;
use JMS\Serializer\Annotation\Accessor;
use JMS\Serializer\Annotation\AccessType;

/**
 * Class User
 * @package App\Entity
 *
 * @ORM\Entity(repositoryClass=UserRepository::class)
 *
 * @AccessType("public_method")
 * @Serializer\XmlRoot("user")
 *
 * @author Rafał Głuszak <rafal.gluszak@gmail.com>
 */
class User
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     *
     * @Serializer\Type("int")
     * @Accessor(getter="getId",setter="setId")
     * @Serializer\XmlElement(cdata=false)
     */
    private ?int $id;

    /**
     * @ORM\Column(type="string", length=255)
     *
     * @Serializer\Type("string")
     * @Accessor(getter="getEmail",setter="setEmail")
     * @Serializer\XmlElement(cdata=false)
     */
    private ?string $email;

    /**
     * @ORM\Column(type="string", length=255)
     *
     * @Serializer\Type("string")
     * @Accessor(getter="getPassword",setter="setPassword")
     * @Serializer\XmlElement(cdata=false)
     */
    private ?string $password;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     *
     * @Serializer\Type("string")
     * @Accessor(getter="getName",setter="setName")
     * @Serializer\XmlElement(cdata=false)
     */
    private ?string $name;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     *
     * @Serializer\Type("string")
     * @Accessor(getter="getSurname",setter="setSurname")
     * @Serializer\XmlElement(cdata=false)
     */
    private ?string $surname;

    /**
     * @ORM\Column(type="datetime")
     * @Gedmo\Timestampable(on="create")
     *
     * @Serializer\Type("string")
     * @Accessor(getter="getCreatedAt",setter="setCreatedAt")
     * @Serializer\XmlElement(cdata=false)
     * @Serializer\Type("DateTime<'d-m-Y H:i:s'>")
     */
    private ?\DateTimeInterface $createdAt;

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @param int|null $id
     * @return $this
     */
    public function setId(?int $id): self
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getEmail(): ?string
    {
        return $this->email;
    }

    /**
     * @param string $email
     * @return $this
     */
    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getPassword(): ?string
    {
        return $this->password;
    }

    /**
     * @param string $password
     * @return $this
     */
    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * @param string|null $name
     * @return $this
     */
    public function setName(?string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getSurname(): ?string
    {
        return $this->surname;
    }

    /**
     * @param string|null $surname
     * @return $this
     */
    public function setSurname(?string $surname): self
    {
        $this->surname = $surname;

        return $this;
    }

    /**
     * @return \DateTimeInterface|null
     */
    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    /**
     * @param \DateTimeInterface $createdAt
     * @return $this
     */
    public function setCreatedAt(\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }
}
