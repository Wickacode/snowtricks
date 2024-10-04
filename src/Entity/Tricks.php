<?php

namespace App\Entity;

use App\Repository\TricksRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

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
}
