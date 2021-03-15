<?php

namespace App\Entity;

use App\Repository\ContactRequestRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ContactRequestRepository::class)
 */
class ContactRequest
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $authorLastname;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $authorFirstname;

    /**
     * @ORM\Column(type="string", length=320)
     */
    private $authorEmail;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $subject;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $content;

    /**
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    public function __toString()
    {
	    return $this->getContent();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAuthorLastname(): ?string
    {
        return $this->authorLastname;
    }

    public function setAuthorLastname(string $authorLastname): self
    {
        $this->authorLastname = $authorLastname;

        return $this;
    }

    public function getAuthorFirstname(): ?string
    {
        return $this->authorFirstname;
    }

    public function setAuthorFirstname(string $authorFirstname): self
    {
        $this->authorFirstname = $authorFirstname;

        return $this;
    }

    public function getAuthorEmail(): ?string
    {
        return $this->authorEmail;
    }

    public function setAuthorEmail(string $authorEmail): self
    {
        $this->authorEmail = $authorEmail;

        return $this;
    }

    public function getSubject(): ?string
    {
        return $this->subject;
    }

    public function setSubject(string $subject): self
    {
        $this->subject = $subject;

        return $this;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(string $content): self
    {
        $this->content = $content;

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
