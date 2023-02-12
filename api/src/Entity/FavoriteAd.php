<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\FavoriteAdRepository;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Doctrine\Orm\Filter\SearchFilter;
use ApiPlatform\Metadata\ApiFilter;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;



#[ORM\Entity(repositoryClass: FavoriteAdRepository::class)]
#[ApiResource(
    operations: [
        new Post(),
        new Get(),
        new GetCollection(),
    ]
)]
#[ApiFilter(SearchFilter::class, properties: ['fk_user' => 'exact'])]
class FavoriteAd {
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'favoriteAds')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $fk_user = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?RealEstateAd $realEstateAd = null;

    #[ORM\Column(nullable: true, type: "datetime", options: ["default" => "CURRENT_TIMESTAMP"])]
    private $createdAt;

    #[ORM\Column(nullable: true, type: "datetime", options: ["default" => "CURRENT_TIMESTAMP"])]
    private $updatedAt;

    #[ORM\Column(nullable: true, type: "datetime")]
    private $deletedAt;

    public function getId(): ?int {
        return $this->id;
    }

    public function getFkUser(): ?User {
        return $this->fk_user;
    }

    public function setFkUser(?User $fk_user): self {
        $this->fk_user = $fk_user;

        return $this;
    }

    public function getRealEstateAd(): ?RealEstateAd {
        return $this->realEstateAd;
    }

    public function setRealEstateAd(?RealEstateAd $realEstateAd): self {
        $this->realEstateAd = $realEstateAd;

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

    public function setDeletedAt(\DateTimeImmutable $deletedAt): self {
        $this->deletedAt = $deletedAt;

        return $this;
    }
}
