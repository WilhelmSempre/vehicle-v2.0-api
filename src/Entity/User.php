<?php
declare(strict_types=1);

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as Serializer;
use JMS\Serializer\Annotation\Accessor;
use JMS\Serializer\Annotation\AccessType;

#[AccessType([], "public_method")]
#[Serializer\XmlRoot([], "user")]
class User
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: "integer")]
    #[Serializer\Type([], "int")]
    #[Accessor([], "getId", "setId")]
    #[Serializer\XmlElement([], false)]
    private ?int $id;

    #[ORM\Column(type: "string", length: 255)]
    #[Serializer\Type([], "string")]
    #[Accessor([], "getEmail", "setEmail")]
    #[Serializer\XmlElement([], false)]
    private ?string $email;

    #[ORM\Column(type: "string", length: 255)]
    #[Serializer\Type([], "string")]
    #[Accessor([], "getPassword", "setPassword")]
    #[Serializer\XmlElement([], false)]
    private ?string $password;

    #[ORM\Column(type: "string", length: 255)]
    #[Serializer\Type([], "string")]
    #[Accessor([], "getName", "setName")]
    #[Serializer\XmlElement([], false)]
    private ?string $name;

    #[ORM\Column(type: "string", length: 255)]
    #[Serializer\Type([], "string")]
    #[Accessor([], "getSurname", "setSurname")]
    #[Serializer\XmlElement([], false)]
    private ?string $surname;

    #[ORM\Column(type: "datetime")]
    #[Serializer\Type([], "string")]
    #[Accessor([], "getCreatedAt", "setCreatedAt")]
    #[Serializer\XmlElement([], false)]
    private ?\DateTimeInterface $createdAt;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(?int $id): self
    {
        $this->id = $id;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(?string $password): self
    {
        $this->password = $password;

        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getSurname(): ?string
    {
        return $this->surname;
    }

    public function setSurname(?string $surname): self
    {
        $this->surname = $surname;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }
}
