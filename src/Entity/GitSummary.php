<?php
declare(strict_types=1);

namespace App\Entity;

use JMS\Serializer\Annotation as Serializer;
use JMS\Serializer\Annotation\Accessor;
use JMS\Serializer\Annotation\AccessType;

#[AccessType([], "public_method")]
#[Serializer\XmlRoot([], "git")]
class GitSummary
{
    #[Serializer\Type([], "string")]
    #[Accessor([], "getBranchName", "setBranchName")]
    #[Serializer\XmlElement([], false)]
    private ?string $branchName;

    #[Serializer\Type([], "string")]
    #[Accessor([], "getLastCommitMessage", "setLastCommitMessage")]
    #[Serializer\XmlElement([], false)]
    private ?string $lastCommitMessage;

    #[Serializer\Type([], "string")]
    #[Accessor([], "getLastCommitAuthor", "setLastCommitAuthor")]
    #[Serializer\XmlElement([], false)]
    private ?string $lastCommitAuthor;

    #[Serializer\Type([], "string")]
    #[Accessor([], "getLastCommitDate", "setLastCommitDate")]
    #[Serializer\XmlElement([], false)]
    private ?string $lastCommitDate;

    #[Serializer\Type([], "string")]
    #[Accessor([], "getLastCommitHash", "setLastCommitHash")]
    #[Serializer\XmlElement([], false)]
    private ?string $lastCommitHash;

    public function getBranchName(): ?string
    {
        return $this->branchName;
    }

    public function setBranchName(?string $branchName): self
    {
        $this->branchName = $branchName;

        return $this;
    }

    public function getLastCommitAuthor(): ?string
    {
        return $this->lastCommitAuthor;
    }

    public function setLastCommitAuthor(?string $lastCommitAuthor): self
    {
        $this->lastCommitAuthor = $lastCommitAuthor;

        return $this;
    }

    public function getLastCommitDate(): ?string
    {
        return $this->lastCommitDate;
    }

    public function setLastCommitDate(?string $lastCommitDate): self
    {
        $this->lastCommitDate = $lastCommitDate;

        return $this;
    }

    public function getLastCommitMessage(): ?string
    {
        return $this->lastCommitMessage;
    }

    public function setLastCommitMessage(?string $lastCommitMessage): self
    {
        $this->lastCommitMessage = $lastCommitMessage;

        return $this;
    }

    public function setLastCommitHash(?string $lastCommitHash): self
    {
        $this->lastCommitHash = $lastCommitHash;

        return $this;
    }

    public function getLastCommitHash(): ?string
    {
        return $this->lastCommitHash;
    }
}
