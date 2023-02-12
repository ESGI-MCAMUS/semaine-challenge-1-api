<?php
# api/src/Entity/User.php

namespace App\Entity;

use ApiPlatform\Metadata\ApiFilter;
use ApiPlatform\Metadata\ApiProperty;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Put;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\UserRepository;
use App\State\UserPasswordHasher;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;
use App\Controller\VerifyEmail;

#[ApiResource(
    operations: [
        new GetCollection(),
        new Post(processor: UserPasswordHasher::class),
        new Post(
            routeName: 'verify_email',
            name: 'verifyEmail',
        ),
        new Post(
            routeName: 'filter_messages',
            name: 'filterMessages',
        ),
        new Post(
            routeName: 'ask_reset_password',
            name: 'askResetPassword',
        ),
        new Post(
            routeName: 'reset_password',
            name: 'resetPassword',
        ),
        new Get(security: 'is_granted("ROLE_ADMIN") or object == user'),
        new Put(),
        new Patch(),
        new Delete(),
    ],
    normalizationContext: ['groups' => ['user:read']],
    denormalizationContext: ['groups' => ['user:create', 'user:update']],
    paginationEnabled: false,
)]
#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\Table(name: '`user`')]
#[UniqueEntity('email')]
class User implements UserInterface, PasswordAuthenticatedUserInterface {
    #[Groups(['user:read'])]
    #[ORM\Id]
    #[ORM\Column(type: 'integer')]
    #[ORM\GeneratedValue]
    private ?int $id = null;

    #[Assert\NotBlank]
    #[Assert\Email]
    #[Groups(['user:read', 'user:create', 'user:update'])]
    #[ORM\Column(length: 180, unique: true)]
    private ?string $email = null;

    #[ORM\Column]
    private ?string $password = null;

    #[Assert\NotBlank(groups: ['user:create'])]
    #[Groups(['user:create', 'user:update'])]
    private ?string $plainPassword = null;

    #[ORM\Column(type: 'json')]
    private array $roles = ['ROLE_USER'];


    #[ORM\Column(type: "boolean", nullable: true)]
    #[Groups(['user:read', 'user:update'])]
    private ?bool $isActive = false;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    #[Groups(['user:read', 'user:create', 'user:update'])]
    #[Assert\NotBlank(groups: ['user:create'])]
    #[Assert\Date(groups: ['user:create'])]
    private ?\DateTimeInterface $birthdate = null;

    #[ORM\Column(length: 255)]
    #[Groups(['user:read', 'user:create', 'user:update'])]
    #[Assert\NotBlank(groups: ['user:create'])]
    private ?string $firstname = null;

    #[ORM\Column(length: 255)]
    #[Groups(['user:read', 'user:create', 'user:update'])]
    #[Assert\NotBlank(groups: ['user:create'])]
    private ?string $lastname = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $emailToken = null;

    #[ORM\Column(type: "datetime", nullable: true, options: ["default" => "CURRENT_TIMESTAMP"])]
    #[Groups(['user:read'])]
    private $createdAt;

    #[ORM\Column(type: "datetime", nullable: true, options: ["default" => "CURRENT_TIMESTAMP"])]
    #[Groups(['user:read'])]
    private $updatedAt;

    #[ORM\Column(type: "datetime", nullable: true)]
    #[Groups(['user:read'])]
    private $deletedAt;

    #[ORM\OneToMany(mappedBy: 'publisher', targetEntity: RealEstateAd::class)]
    #[Groups(['user:read'])]
    private Collection $realEstateAds;

    #[ORM\OneToMany(mappedBy: 'owner', targetEntity: Housing::class)]
    #[Groups(['user:read'])]
    private Collection $housings;

    #[ORM\OneToMany(mappedBy: 'documents_owner', targetEntity: Documents::class)]
    #[Groups(['user:read'])]
    private Collection $documents;

    #[ORM\OneToMany(mappedBy: 'debited_user', targetEntity: Payments::class)]
    #[Groups(['user:read'])]
    private Collection $payments;

    #[ORM\OneToMany(mappedBy: 'contract_owner', targetEntity: UserContract::class)]
    #[Groups(['user:read'])]
    private Collection $userContracts;

    #[ORM\OneToMany(mappedBy: 'visitor', targetEntity: Appointment::class)]
    #[Groups(['user:read'])]
    private Collection $appointments;

    #[ORM\OneToMany(mappedBy: 'fk_user', targetEntity: FavoriteAd::class)]
    #[Groups(['user:read'])]
    private Collection $favoriteAds;


    public function __construct() {
        $this->realEstateAds = new ArrayCollection();
        $this->housings = new ArrayCollection();
        $this->documents = new ArrayCollection();
        $this->payments = new ArrayCollection();
        $this->userContracts = new ArrayCollection();
        $this->appointments = new ArrayCollection();
        $this->favoriteAds = new ArrayCollection();
    }

    public function getId(): ?int {
        return $this->id;
    }

    public function getEmail(): ?string {
        return $this->email;
    }

    public function setEmail(string $email): self {
        $this->email = $email;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string {
        return $this->password;
    }

    public function setPassword(string $password): self {
        $this->password = $password;

        return $this;
    }

    public function getPlainPassword(): ?string {
        return $this->plainPassword;
    }

    public function setPlainPassword(?string $painPassword): self {
        $this->plainPassword = $painPassword;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array {
        $roles = $this->roles;

        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self {
        $this->roles = $roles;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials(): void {
        $this->plainPassword = null;
    }

    public function getBirthdate(): ?\DateTimeInterface {
        return $this->birthdate;
    }

    public function setBirthdate(\DateTimeInterface $birthdate): self {
        $this->birthdate = $birthdate;

        return $this;
    }

    public function getFirstname(): ?string {
        return $this->firstname;
    }

    public function setFirstname(string $firstname): self {
        $this->firstname = $firstname;

        return $this;
    }

    public function getLastname(): ?string {
        return $this->lastname;
    }

    public function setLastname(string $lastname): self {
        $this->lastname = $lastname;

        return $this;
    }

    public function getToken(): ?string {
        return $this->emailToken;
    }

    public function setToken(?string $emailToken): self {
        $this->emailToken = $emailToken;

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

    /**
     * @return Collection<int, RealEstateAd>
     */
    public function getRealEstateAds(): Collection {
        return $this->realEstateAds;
    }

    public function addRealEstateAd(RealEstateAd $realEstateAd): self {
        if (!$this->realEstateAds->contains($realEstateAd)) {
            $this->realEstateAds->add($realEstateAd);
            $realEstateAd->setPublisher($this);
        }

        return $this;
    }

    public function removeRealEstateAd(RealEstateAd $realEstateAd): self {
        if ($this->realEstateAds->removeElement($realEstateAd)) {
            // set the owning side to null (unless already changed)
            if ($realEstateAd->getPublisher() === $this) {
                $realEstateAd->setPublisher(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Housing>
     */
    public function getHousings(): Collection {
        return $this->housings;
    }

    public function addHousing(Housing $housing): self {
        if (!$this->housings->contains($housing)) {
            $this->housings->add($housing);
            $housing->setOwner($this);
        }

        return $this;
    }

    public function removeHousing(Housing $housing): self {
        if ($this->housings->removeElement($housing)) {
            // set the owning side to null (unless already changed)
            if ($housing->getOwner() === $this) {
                $housing->setOwner(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Documents>
     */
    public function getDocuments(): Collection {
        return $this->documents;
    }

    public function addDocument(Documents $document): self {
        if (!$this->documents->contains($document)) {
            $this->documents->add($document);
            $document->setDocumentsOwner($this);
        }

        return $this;
    }

    public function removeDocument(Documents $document): self {
        if ($this->documents->removeElement($document)) {
            // set the owning side to null (unless already changed)
            if ($document->getDocumentsOwner() === $this) {
                $document->setDocumentsOwner(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Payments>
     */
    public function getPayments(): Collection {
        return $this->payments;
    }

    public function addPayment(Payments $payment): self {
        if (!$this->payments->contains($payment)) {
            $this->payments->add($payment);
            $payment->setDebitedUser($this);
        }

        return $this;
    }

    public function removePayment(Payments $payment): self {
        if ($this->payments->removeElement($payment)) {
            // set the owning side to null (unless already changed)
            if ($payment->getDebitedUser() === $this) {
                $payment->setDebitedUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, UserContract>
     */
    public function getUserContracts(): Collection {
        return $this->userContracts;
    }

    public function addUserContract(UserContract $userContract): self {
        if (!$this->userContracts->contains($userContract)) {
            $this->userContracts->add($userContract);
            $userContract->setContractOwner($this);
        }

        return $this;
    }

    public function removeUserContract(UserContract $userContract): self {
        if ($this->userContracts->removeElement($userContract)) {
            // set the owning side to null (unless already changed)
            if ($userContract->getContractOwner() === $this) {
                $userContract->setContractOwner(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Appointment>
     */
    public function getAppointments(): Collection {
        return $this->appointments;
    }

    public function addAppointment(Appointment $appointment): self {
        if (!$this->appointments->contains($appointment)) {
            $this->appointments->add($appointment);
            $appointment->setVisitor($this);
        }

        return $this;
    }

    public function removeAppointment(Appointment $appointment): self {
        if ($this->appointments->removeElement($appointment)) {
            // set the owning side to null (unless already changed)
            if ($appointment->getVisitor() === $this) {
                $appointment->setVisitor(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, FavoriteAd>
     */
    public function getFavoriteAds(): Collection {
        return $this->favoriteAds;
    }

    public function addFavoriteAd(FavoriteAd $favoriteAd): self {
        if (!$this->favoriteAds->contains($favoriteAd)) {
            $this->favoriteAds->add($favoriteAd);
            $favoriteAd->setFkUser($this);
        }

        return $this;
    }

    public function removeFavoriteAd(FavoriteAd $favoriteAd): self {
        if ($this->favoriteAds->removeElement($favoriteAd)) {
            // set the owning side to null (unless already changed)
            if ($favoriteAd->getFkUser() === $this) {
                $favoriteAd->setFkUser(null);
            }
        }

        return $this;
    }

    public function getIsActive(): ?bool {
        return $this->isActive;
    }

    public function setIsActive(bool $isActive): self {
        $this->isActive = $isActive;

        return $this;
    }
}
