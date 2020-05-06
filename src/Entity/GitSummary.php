<?php

namespace App\Entity;

use JMS\Serializer\Annotation as Serializer;
use JMS\Serializer\Annotation\Accessor;
use JMS\Serializer\Annotation\AccessType;

/**
 * @AccessType("public_method")
 * @Serializer\XmlRoot("git")
 *
 * Class GitSummary
 * @package App\Entity
 *
 * @author Rafał Głuszak <rafal.gluszak@gmail.com>
 */
class GitSummary
{
    /**
     * @Serializer\Type("string")
     * @Accessor(getter="getBranchName",setter="setBranchName")
     * @Serializer\XmlElement(cdata=false)
     *
     * @var string|null
     */
    private $branchName;

    /**
     * @Serializer\Type("string")
     * @Accessor(getter="getLastCommitMessage",setter="setLastCommitMessage")
     * @Serializer\XmlElement(cdata=false)
     *
     * @var string|null
     */
    private $lastCommitMessage;

    /**
     * @Serializer\Type("string")
     * @Accessor(getter="getLastCommitAuthor",setter="setLastCommitAuthor")
     * @Serializer\XmlElement(cdata=false)
     *
     * @var string|null
     */
    private $lastCommitAuthor;

    /**
     * @Serializer\Type("string")
     * @Accessor(getter="getLastCommitDate",setter="setLastCommitDate")
     * @Serializer\XmlElement(cdata=false)
     *
     * @var string|null
     */
    private $lastCommitDate;

    /**
     * @Serializer\Type("string")
     * @Accessor(getter="getLastCommitHash",setter="setLastCommitHash")
     * @Serializer\XmlElement(cdata=false)
     *
     * @var string|null
     */
    private $lastCommitHash;

    /**
     * @return string|null
     */
    public function getBranchName(): ?string
    {
        return $this->branchName;
    }

    /**
     * @param string|null $branchName
     * @return GitSummary
     */
    public function setBranchName(?string $branchName): self
    {
        $this->branchName = $branchName;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getLastCommitAuthor(): ?string
    {
        return $this->lastCommitAuthor;
    }

    /**
     * @param string|null $lastCommitAuthor
     * @return GitSummary
     */
    public function setLastCommitAuthor(?string $lastCommitAuthor): self
    {
        $this->lastCommitAuthor = $lastCommitAuthor;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getLastCommitDate(): ?string
    {
        return $this->lastCommitDate;
    }

    /**
     * @param string|null $lastCommitDate
     * @return GitSummary
     */
    public function setLastCommitDate(?string $lastCommitDate): self
    {
        $this->lastCommitDate = $lastCommitDate;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getLastCommitMessage(): ?string
    {
        return $this->lastCommitMessage;
    }

    /**
     * @param string|null $lastCommitMessage
     * @return GitSummary
     */
    public function setLastCommitMessage(?string $lastCommitMessage): self
    {
        $this->lastCommitMessage = $lastCommitMessage;

        return $this;
    }

    /**
     * @param string|null $lastCommitHash
     * @return GitSummary
     */
    public function setLastCommitHash(?string $lastCommitHash): self
    {
        $this->lastCommitHash = $lastCommitHash;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getLastCommitHash(): ?string
    {
        return $this->lastCommitHash;
    }
}