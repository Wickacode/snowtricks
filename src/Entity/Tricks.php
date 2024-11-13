<?php

namespace App\Entity;

use App\Repository\TricksRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\String\Slugger\AsciiSlugger;

#[ORM\Entity(repositoryClass: TricksRepository::class)]
class Tricks
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 250)]
    private ?string $titleTrick = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $contentTrick = null;

    #[ORM\Column(length: 250)]
    private ?string $mainImg = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $dateCreateTrick = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $dateUpdateTrick = null;

    #[ORM\Column]
    private ?bool $isActiveTrick = null;

    #[ORM\Column(length: 250)]
    private ?string $slug = null;

    #[ORM\ManyToOne(inversedBy: 'tricks')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $users = null;

    #[ORM\ManyToOne(inversedBy: 'tricks')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Categories $categories = null;

    /**
     * @var Collection<int, Medias>
     */
    #[ORM\OneToMany(targetEntity: Medias::class, mappedBy: 'tricks', orphanRemoval: true, cascade: ['persist'] )]
    private Collection $medias;

    /**
     * @var Collection<int, Comments>
     */
    #[ORM\OneToMany(targetEntity: Comments::class, mappedBy: 'tricks', orphanRemoval: true, cascade: ['persist'])]
    private Collection $comments;

    public function __construct()
    {
        $this->medias = new ArrayCollection();
        $this->comments = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitleTrick(): ?string
    {
        return $this->titleTrick;
    }

    public function setTitleTrick(string $titleTrick): static
    {
        $this->titleTrick = $titleTrick;
        $slugger = new AsciiSlugger('fr');
        $this->slug = $slugger->slug($titleTrick);

        return $this;
    }

    public function getContentTrick(): ?string
    {
        return $this->contentTrick;
    }

    public function setContentTrick(string $contentTrick): static
    {
        $this->contentTrick = $contentTrick;

        return $this;
    }

    public function getMainImg(): ?string
    {
        return $this->mainImg;
    }

    public function setMainImg(string $mainImg): static
    {
        $this->mainImg = $mainImg;

        return $this;
    }

    public function getDateCreateTrick(): ?\DateTimeInterface
    {
        return $this->dateCreateTrick;
    }

    public function setDateCreateTrick(\DateTimeInterface $dateCreateTrick): static
    {
        $this->dateCreateTrick = $dateCreateTrick;

        return $this;
    }

    public function getDateUpdateTrick(): ?\DateTimeInterface
    {
        return $this->dateUpdateTrick;
    }

    public function setDateUpdateTrick(\DateTimeInterface $dateUpdateTrick): static
    {
        $this->dateUpdateTrick = $dateUpdateTrick;

        return $this;
    }

    public function isActiveTrick(): ?bool
    {
        return $this->isActiveTrick;
    }

    public function setActiveTrick(bool $isActiveTrick): static
    {
        $this->isActiveTrick = $isActiveTrick;

        return $this;
    }

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): static
    {
        $this->slug = $slug;

        return $this;
    }

    public function getUsers(): ?User
    {
        return $this->users;
    }

    public function setUsers(?User $users): static
    {
        $this->users = $users;

        return $this;
    }

    public function getCategories(): ?Categories
    {
        return $this->categories;
    }

    public function setCategories(?Categories $categories): static
    {
        $this->categories = $categories;

        return $this;
    }

    /**
     * @return Collection<int, Medias>
     */
    public function getMedias(): Collection
    {
        return $this->medias;
    }

    public function addMedia(Medias $media): static
    {
        if (!$this->medias->contains($media)) {
            $this->medias->add($media);
            $media->setTricks($this);
        }

        return $this;
    }

    public function removeMedia(Medias $media): static
    {
        if ($this->medias->removeElement($media)) {
            // set the owning side to null (unless already changed)
            if ($media->getTricks() === $this) {
                $media->setTricks(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Comments>
     */
    public function getComments(): Collection
    {
        return $this->comments;
    }

    public function addComment(Comments $comment): static
    {
        if (!$this->comments->contains($comment)) {
            $this->comments->add($comment);
            $comment->setTricks($this);
        }

        return $this;
    }

    public function removeComment(Comments $comment): static
    {
        if ($this->comments->removeElement($comment)) {
            // set the owning side to null (unless already changed)
            if ($comment->getTricks() === $this) {
                $comment->setTricks(null);
            }
        }

        return $this;
    }
}
