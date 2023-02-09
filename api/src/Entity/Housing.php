<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\HousingRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;


#[ORM\Entity(repositoryClass: HousingRepository::class)]
#[ApiResource]
class Housing {
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $address = null;

    #[ORM\Column(length: 255)]
    private ?string $address2 = null;

    #[ORM\Column(length: 255)]
    private ?string $zipcode = null;

    #[ORM\Column(length: 255)]
    private ?string $city = null;

    #[ORM\Column (nullable: true)]
    private ?float $lat = null;

    #[ORM\Column (nullable: true)]
    private ?float $lng = null;

    #[ORM\Column(length: 255 , nullable: true)]
    private ?string $door = null;

    #[ORM\Column]
    private ?int $floor = null;

    #[ORM\Column(type: "datetime", nullable: true, options: ["default" => "CURRENT_TIMESTAMP"])]
    private ?\DateTimeImmutable $createdAt;

    #[ORM\Column(type: "datetime", nullable: true, options: ["default" => "CURRENT_TIMESTAMP"])]
    private ?\DateTimeImmutable $updatedAt;

    #[ORM\Column(type: "datetime", nullable: true)]
    private ?\DateTimeImmutable $deletedAt;

    #[ORM\OneToOne(targetEntity: HousingProperties::class, cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(name: 'properties_id', referencedColumnName: 'id', nullable: false)]
    private ?HousingProperties $properties = null;

    #[ORM\ManyToOne(inversedBy: 'housings')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $owner = null;

    #[ORM\OneToOne(mappedBy: 'housing', cascade: ['persist', 'remove'])]
    private ?Documents $documents = null;

    #[ORM\OneToMany(mappedBy: 'housing', targetEntity: Payments::class)]
    private Collection $payments;

    #[ORM\OneToMany(mappedBy: 'housing', targetEntity: UserContract::class)]
    private Collection $userContracts;

    #[ORM\OneToMany(mappedBy: 'housing', targetEntity: Appointment::class)]
    private Collection $appointments;

    public function __construct() {
        $this->payments = new ArrayCollection();
        $this->userContracts = new ArrayCollection();
        $this->appointments = new ArrayCollection();
    }

    public function getId(): ?int {
        return $this->id;
    }

    public function getAddress(): ?string {
        return $this->address;
    }

    public function setAddress(string $address): self {
        $this->address = $address;

        return $this;
    }

    public function getAddress2(): ?string {
        return $this->address2;
    }

    public function setAddress2(string $address2): self {
        $this->address2 = $address2;

        return $this;
    }

    public function getZipcode(): ?string {
        return $this->zipcode;
    }

    public function setZipcode(string $zipcode): self {
        $this->zipcode = $zipcode;

        return $this;
    }

    public function getCity(): ?string {
        return $this->city;
    }

    public function setCity(string $city): self {
        $this->city = $city;

        return $this;
    }

    public function getLat(): ?float {
        return $this->lat;
    }

    public function setLat(float $lat): self {
        $this->lat = $lat;

        return $this;
    }

    public function getLng(): ?float {
        return $this->lng;
    }

    public function setLng(float $lng): self {
        $this->lng = $lng;

        return $this;
    }

    public function getDoor(): ?string {
        return $this->door;
    }

    public function setDoor(string $door): self {
        $this->door = $door;

        return $this;
    }

    public function getFloor(): ?int {
        return $this->floor;
    }

    public function setFloor(int $floor): self {
        $this->floor = $floor;

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

    public function getProperties(): ?HousingProperties {
        return $this->properties;
    }

    public function setProperties(HousingProperties $properties): self {
        $this->properties = $properties;

        return $this;
    }

    public function getOwner(): ?User {
        return $this->owner;
    }

    public function setOwner(?User $owner): self {
        $this->owner = $owner;

        return $this;
    }

    public function getDocuments(): ?Documents {
        return $this->documents;
    }

    public function setDocuments(Documents $documents): self {
        // set the owning side of the relation if necessary
        if ($documents->getHousing() !== $this) {
            $documents->setHousing($this);
        }

        $this->documents = $documents;

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
            $payment->setHousing($this);
        }

        return $this;
    }

    public function removePayment(Payments $payment): self {
        if ($this->payments->removeElement($payment)) {
            // set the owning side to null (unless already changed)
            if ($payment->getHousing() === $this) {
                $payment->setHousing(null);
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
            $userContract->setHousing($this);
        }

        return $this;
    }

    public function removeUserContract(UserContract $userContract): self {
        if ($this->userContracts->removeElement($userContract)) {
            // set the owning side to null (unless already changed)
            if ($userContract->getHousing() === $this) {
                $userContract->setHousing(null);
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
            $appointment->setHousing($this);
        }

        return $this;
    }

    public function removeAppointment(Appointment $appointment): self {
        if ($this->appointments->removeElement($appointment)) {
            // set the owning side to null (unless already changed)
            if ($appointment->getHousing() === $this) {
                $appointment->setHousing(null);
            }
        }

        return $this;
    }
}
