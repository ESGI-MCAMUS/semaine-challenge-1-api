<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\DocumentsRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: DocumentsRepository::class)]
#[ApiResource]
class Documents {
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private array $documents = [];

    #[ORM\OneToOne(inversedBy: 'documents', cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    private ?Housing $housing = null;

    #[ORM\ManyToOne(inversedBy: 'documents')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $documents_owner = null;

    #[ORM\Column(type: "datetime", nullable: true, options: ["default" => "CURRENT_TIMESTAMP"])]
    private $createdAt;

    #[ORM\Column(type: "datetime", nullable: true, options: ["default" => "CURRENT_TIMESTAMP"])]
    private $updatedAt;

    #[ORM\Column(nullable: true, type: "datetime")]
    private $deletedAt;

    public function getId(): ?int {
        return $this->id;
    }

    public function getDocuments(): array {
        return $this->documents;
    }

    public function setDocuments(array $documents): self {
        $this->documents = $documents;

        return $this;
    }

    public function getHousing(): ?Housing {
        return $this->housing;
    }

    public function setHousing(Housing $housing): self {
        $this->housing = $housing;

        return $this;
    }

    public function getDocumentsOwner(): ?User {
        return $this->documents_owner;
    }

    public function setDocumentsOwner(?User $documents_owner): self {
        $this->documents_owner = $documents_owner;

        return $this;
    }

    public function getCreatedAt() {
        return $this->createdAt;
    }

    public function setCreatedAt($createdAt): self {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUpdatedAt() {
        return $this->updatedAt;
    }

    public function setUpdatedAt($updatedAt): self {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    public function getDeletedAt() {
        return $this->deletedAt;
    }

    public function setDeletedAt($deletedAt): self {
        $this->deletedAt = $deletedAt;

        return $this;
    }
}
