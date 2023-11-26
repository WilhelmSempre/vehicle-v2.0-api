<?php
declare(strict_types=1);

namespace App\Entity;

use JMS\Serializer\Annotation as Serializer;
use JMS\Serializer\Annotation\Accessor;
use JMS\Serializer\Annotation\AccessType;

#[AccessType([], "public_method")]
#[Serializer\XmlRoot([], "result")]
class Result
{

    #[Serializer\Type([], "string")]
    #[Accessor([], "getStatus", "setStatus")]
    #[Serializer\XmlElement([], false)]
    private ?string $status;

    #[Serializer\Type([], "string")]
    #[Accessor([], "getMessage", "setMessage")]
    #[Serializer\XmlElement([], false)]
    private ?string $message;

    public function setStatus(string $status): self
    {
        $this->status = $status;

        return $this;
    }

    public function setMessage(string $message): self
    {
        $this->message = $message;

        return $this;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function getMessage(): ?string
    {
        return $this->message;
    }
}
