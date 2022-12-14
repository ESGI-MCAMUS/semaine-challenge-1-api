<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Post;
use App\Repository\JokeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation\Blameable;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\NotNull;
use Symfony\Component\Validator\Constraints\Type;

#[ApiResource(
    denormalizationContext: ['groups' => ['joke_write']],
    normalizationContext: ['groups' => ['joke_read']]
)]
#[Get(
    normalizationContext: ['groups' => ['joke_get', 'joke_read']]
)]
#[GetCollection(
    normalizationContext: ['groups' => ['joke_cget', 'joke_read']]
)]
#[Post(
    normalizationContext:  ['groups' => ['joke_post']],
    security: 'is_granted("ROLE_MODERATOR")'
)]
#[Patch(
    security: 'is_granted("ROLE_ADMIN") or object.getAuthor() == user'
)]
#[Delete]
#[ORM\Entity(repositoryClass: JokeRepository::class)]
#[UniqueEntity('text')]
class Joke
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column()]
    private ?int $id = null;

    #[ORM\Column(type: Types::TEXT)]
    #[Groups(['joke_read', 'joke_write'])]
    #[NotBlank(message: 'test')]
    #[Type('string')]
    #[Length(max: 255)]
    private ?string $text = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    #[Groups(['joke_get', 'joke_write'])]
    private ?string $answer = null;

    #[ORM\OneToMany(mappedBy: 'joke', targetEntity: Rate::class, cascade: ['persist', 'remove'])]
    private Collection $rates;

    #[ORM\ManyToMany(targetEntity: Category::class, inversedBy: 'jokes')]
    #[Groups('joke_get')]
    private Collection $categories;

    #[ORM\OneToMany(mappedBy: 'joke', targetEntity: Comment::class, cascade: ['remove'])]
    private Collection $comments;

    #[ORM\ManyToOne(inversedBy: 'jokes')]
    #[Blameable(on: 'create')]
    private ?User $author = null;

    #[ORM\Column(nullable: true)]
    private ?float $ratesTotal = null;

    #[Groups('joke_get')]
    private ?float $avarage = null;

    /**
     * @return float|null
     */
    public function getAvarage(): ?float
    {
        return $this->avarage;
    }

    /**
     * @param float|null $avarage
     * @return Joke
     */
    public function setAvarage(?float $avarage): Joke
    {
        $this->avarage = $avarage;
        return $this;
    }

    public function __construct()
    {
        $this->rates = new ArrayCollection();
        $this->categories = new ArrayCollection();
        $this->comments = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getText(): ?string
    {
        return $this->text;
    }

    public function setText(string $text): self
    {
        $this->text = $text;

        return $this;
    }

    public function getAnswer(): ?string
    {
        return $this->answer;
    }

    public function setAnswer(?string $answer): self
    {
        $this->answer = $answer;

        return $this;
    }

    /**
     * @return Collection<int, Rate>
     */
    public function getRates(): Collection
    {
        return $this->rates;
    }

    public function addRate(Rate $rate): self
    {
        if (!$this->rates->contains($rate)) {
            $this->rates[] = $rate;
            $rate->setJoke($this);
        }

        return $this;
    }

    public function removeRate(Rate $rate): self
    {
        if ($this->rates->removeElement($rate)) {
            // set the owning side to null (unless already changed)
            if ($rate->getJoke() === $this) {
                $rate->setJoke(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Category>
     */
    public function getCategories(): Collection
    {
        return $this->categories;
    }

    public function addCategory(Category $category): self
    {
        if (!$this->categories->contains($category)) {
            $this->categories[] = $category;
        }

        return $this;
    }

    public function removeCategory(Category $category): self
    {
        $this->categories->removeElement($category);

        return $this;
    }

    /**
     * @return Collection<int, Comment>
     */
    public function getComments(): Collection
    {
        return $this->comments;
    }

    public function addComment(Comment $comment): self
    {
        if (!$this->comments->contains($comment)) {
            $this->comments[] = $comment;
            $comment->setJoke($this);
        }

        return $this;
    }

    public function removeComment(Comment $comment): self
    {
        if ($this->comments->removeElement($comment)) {
            // set the owning side to null (unless already changed)
            if ($comment->getJoke() === $this) {
                $comment->setJoke(null);
            }
        }

        return $this;
    }

    public function getAuthor(): ?User
    {
        return $this->author;
    }

    public function setAuthor(?User $author): self
    {
        $this->author = $author;

        return $this;
    }

    public function getRatesTotal(): ?float
    {
        return $this->ratesTotal;
    }

    public function setRatesTotal(?float $ratesTotal): self
    {
        $this->ratesTotal = $ratesTotal;

        return $this;
    }
}
