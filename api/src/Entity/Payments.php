<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\PaymentsRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PaymentsRepository::class)]
#[ApiResource]
class Payments {
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'payments')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $debited_user = null;

    #[ORM\ManyToOne(inversedBy: 'payments')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Housing $housing = null;

    #[ORM\Column]
    private ?float $price = null;

    #[ORM\Column(length: 255)]
    private ?string $status = null;

    #[ORM\Column(type: "datetime", options: ["default" => "CURRENT_TIMESTAMP"])]
    private ?\DateTimeImmutable $createdAt;

    #[ORM\Column(type: "datetime", options: ["default" => "CURRENT_TIMESTAMP"])]
    private ?\DateTimeImmutable $updatedAt;

    #[ORM\Column(nullable: true, type: "datetime")]
    private ?\DateTimeImmutable $deletedAt;

    public function getId(): ?int {
        return $this->id;
    }

    public function getDebitedUser(): ?User {
        return $this->debited_user;
    }

    public function setDebitedUser(?User $debited_user): self {
        $this->debited_user = $debited_user;

        return $this;
    }

    public function getHousing(): ?Housing {
        return $this->housing;
    }

    public function setHousing(?Housing $housing): self {
        $this->housing = $housing;

        return $this;
    }

    public function getPrice(): ?float {
        return $this->price;
    }

    public function setPrice(float $price): self {
        $this->price = $price;

        return $this;
    }

    public function getStatus(): ?string {
        return $this->status;
    }

    public function setStatus(string $status): self {
        $this->status = $status;

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