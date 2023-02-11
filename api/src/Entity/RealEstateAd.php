<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\RealEstateAdRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Doctrine\Orm\Filter\SearchFilter;
use ApiPlatform\Metadata\ApiFilter;

#[ORM\Entity(repositoryClass: RealEstateAdRepository::class)]
#[ApiResource(paginationItemsPerPage: 10, paginationClientEnabled: true)]
#[ApiFilter(SearchFilter::class, properties: [
    'title' => 'partial',
])]
class RealEstateAd {
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $type = null;

    #[ORM\Column]
    private ?float $price = null;

    #[ORM\Column(length: 255)]
    private ?string $title = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $description = null;

    #[ORM\Column]
    private array $photos = [];

    #[ORM\OneToOne(cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    private ?Housing $housing = null;

    #[ORM\ManyToOne(inversedBy: 'realEstateAds')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $publisher = null;

    #[ORM\Column]
    private ?bool $isVisible = null;

    #[ORM\Column(type: "datetime", nullable: true, options: ["default" => "CURRENT_TIMESTAMP"])]
    private  $createdAt;

    #[ORM\Column(type: "datetime", nullable: true, options: ["default" => "CURRENT_TIMESTAMP"])]
    private  $updatedAt;

    #[ORM\Column(type: "datetime", nullable: true)]
    private  $deletedAt;

    public function getId(): ?int {
        return $this->id;
    }

    public function getType(): ?string {
        return $this->type;
    }

    public function setType(string $type): self {
        $this->type = $type;

        return $this;
    }

    public function getPrice(): ?float {
        return $this->price;
    }

    public function setPrice(float $price): self {
        $this->price = $price;

        return $this;
    }

    public function getTitle(): ?string {
        return $this->title;
    }

    public function setTitle(string $title): self {
        $this->title = $title;

        return $this;
    }

    public function getDescription(): ?string {
        return $this->description;
    }

    public function setDescription(string $description): self {
        $this->description = $description;

        return $this;
    }

    public function getPhotos(): array {
        return $this->photos;
    }

    public function setPhotos(array $photos): self {
        $this->photos = $photos;

        return $this;
    }

    public function getHousing(): ?Housing {
        return $this->housing;
    }

    public function setHousing(Housing $housing): self {
        $this->housing = $housing;

        return $this;
    }

    public function getPublisher(): ?User {
        return $this->publisher;
    }

    public function setPublisher(?User $publisher): self {
        $this->publisher = $publisher;

        return $this;
    }

    public function isIsVisible(): ?bool {
        return $this->isVisible;
    }

    public function setIsVisible(bool $isVisible): self {
        $this->isVisible = $isVisible;

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
