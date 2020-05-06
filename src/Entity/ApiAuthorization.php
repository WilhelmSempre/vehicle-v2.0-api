<?php

namespace App\Entity;

use JMS\Serializer\Annotation as Serializer;
use JMS\Serializer\Annotation\Accessor;
use JMS\Serializer\Annotation\AccessType;

/**
 * @AccessType("public_method")
 * @Serializer\XmlRoot("status")
 *
 * Class ApiAuthorization
 * @package App\Entity
 *
 * @author Rafał Głuszak <rafal.gluszak@gmail.com>
 */
class ApiAuthorization
{

    /**
     * @Serializer\Type("string")
     * @Accessor(getter="getStatus",setter="setStatus")
     * @Serializer\XmlElement(cdata=false)
     *
     * @var string|null
     */
    private $status;

    /**
     * @Serializer\Type("string")
     * @Accessor(getter="getMessage",setter="setMessage")
     * @Serializer\XmlElement(cdata=false)
     *
     * @var string|null
     */
    private $message;

    /**
     * @param string $status
     * @return ApiAuthorization
     */
    public function setStatus(string $status): self
    {
        $this->status = $status;

        return $this;
    }

    /**
     * @param string $message
     * @return ApiAuthorization
     */
    public function setMessage(string $message): self
    {
        $this->message = $message;

        return $this;
    }

    /**
     * @return string
     */
    public function getStatus(): ?string
    {
        return $this->status;
    }

    /**
     * @return string
     */
    public function getMessage(): ?string
    {
        return $this->message;
    }
}