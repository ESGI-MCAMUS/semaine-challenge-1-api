<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\HousingPropertiesRepository;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Doctrine\Orm\Filter\SearchFilter;
use ApiPlatform\Metadata\ApiFilter;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Put;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;

#[ORM\Entity(repositoryClass: HousingPropertiesRepository::class)]
#[ApiResource(paginationClientEnabled: true, operations: [
    new Post(),
    new Get(),
    new GetCollection(),
    new Patch(),
    new Put(),
])]
#[ApiFilter(SearchFilter::class, properties: [
    'type' => 'exact',
    'rooms' => 'exact',
    'hasGarden' => 'exact',
    'hasParking' => 'exact',
    'hasPool' => 'exact',
    'hasCave' => 'exact',
    'hasAttic' => 'exact',
    'hasBalcony' => 'exact',
    'nearPublicTransport' => 'exact',
    'classification' => 'exact'
])]
class HousingProperties {
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $surface = null;

    #[ORM\Column(length: 255)]
    private ?string $type = null;

    #[ORM\Column]
    private ?int $rooms = null;

    #[ORM\Column]
    private ?bool $hasGarden = null;

    #[ORM\Column]
    private ?bool $hasParking = null;

    #[ORM\Column]
    private ?bool $hasPool = null;

    #[ORM\Column]
    private ?bool $hasCave = null;

    #[ORM\Column]
    private ?bool $hasAttic = null;

    #[ORM\Column]
    private ?bool $hasBalcony = null;

    #[ORM\Column]
    private ?bool $nearPublicTransport = null;

    #[ORM\Column(length: 255)]
    private ?string $classification = null;

    #[ORM\Column(type: "datetime", nullable: true, options: ["default" => "CURRENT_TIMESTAMP"])]
    private ?\DateTimeImmutable $createdAt;

    #[ORM\Column(type: "datetime", nullable: true, options: ["default" => "CURRENT_TIMESTAMP"])]
    private ?\DateTimeImmutable $updatedAt;

    #[ORM\Column(type: "datetime", nullable: true)]
    private ?\DateTimeImmutable $deletedAt;

    public function getId(): ?int {
        return $this->id;
    }

    public function getSurface(): ?int {
        return $this->surface;
    }

    public function setSurface(int $surface): self {
        $this->surface = $surface;

        return $this;
    }

    public function getType(): ?string {
        return $this->type;
    }

    public function setType(string $type): self {
        $this->type = $type;

        return $this;
    }

    public function getRooms(): ?int {
        return $this->rooms;
    }

    public function setRooms(int $rooms): self {
        $this->rooms = $rooms;

        return $this;
    }

    public function isHasGarden(): ?bool {
        return $this->hasGarden;
    }

    public function setHasGarden(bool $hasGarden): self {
        $this->hasGarden = $hasGarden;

        return $this;
    }

    public function isHasParking(): ?bool {
        return $this->hasParking;
    }

    public function setHasParking(bool $hasParking): self {
        $this->hasParking = $hasParking;

        return $this;
    }

    public function isHasPool(): ?bool {
        return $this->hasPool;
    }

    public function setHasPool(bool $hasPool): self {
        $this->hasPool = $hasPool;

        return $this;
    }

    public function isHasCave(): ?bool {
        return $this->hasCave;
    }

    public function setHasCave(bool $hasCave): self {
        $this->hasCave = $hasCave;

        return $this;
    }

    public function isHasAttic(): ?bool {
        return $this->hasAttic;
    }

    public function setHasAttic(bool $hasAttic): self {
        $this->hasAttic = $hasAttic;

        return $this;
    }

    public function isHasBalcony(): ?bool {
        return $this->hasBalcony;
    }

    public function setHasBalcony(bool $hasBalcony): self {
        $this->hasBalcony = $hasBalcony;

        return $this;
    }

    public function isNearPublicTransport(): ?bool {
        return $this->nearPublicTransport;
    }

    public function setNearPublicTransport(bool $nearPublicTransport): self {
        $this->nearPublicTransport = $nearPublicTransport;

        return $this;
    }

    public function getClassification(): ?string {
        return $this->classification;
    }

    public function setClassification(string $classification): self {
        $this->classification = $classification;

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
