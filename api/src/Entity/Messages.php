<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\MessagesRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MessagesRepository::class)]
#[ApiResource]
class Messages {
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $sender = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $receiver = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $message = null;

    #[ORM\Column(type: "datetime", options: ["default" => "CURRENT_TIMESTAMP"])]
    private ?\DateTimeImmutable $createdAt;

    #[ORM\Column(type: "datetime", options: ["default" => "CURRENT_TIMESTAMP"])]
    private ?\DateTimeImmutable $updatedAt;

    #[ORM\Column(nullable: true, type: "datetime")]
    private ?\DateTimeImmutable $deletedAt;

    public function getId(): ?int {
        return $this->id;
    }

    public function getSender(): ?User {
        return $this->sender;
    }

    public function setSender(?User $sender): self {
        $this->sender = $sender;

        return $this;
    }

    public function getReceiver(): ?User {
        return $this->receiver;
    }

    public function setReceiver(?User $receiver): self {
        $this->receiver = $receiver;

        return $this;
    }

    public function getMessage(): ?string {
        return $this->message;
    }

    public function setMessage(string $message): self {
        $this->message = $message;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): self {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeImmutable {
        return $this->updatedAt;
    }

    public function setUpdatedAt(\DateTimeImmutable $updatedAt): self {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    public function getDeletedAt(): ?\DateTimeImmutable {
        return $this->deletedAt;
    }

    public function setDeletedAt(?\DateTimeImmutable $deletedAt): self {
        $this->deletedAt = $deletedAt;

        return $this;
    }
}