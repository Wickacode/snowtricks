<?php

namespace App\Entity;

use App\Repository\CommentsRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CommentsRepository::class)]
class Comments
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $contentCom = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $dateCreateCom = null;

    #[ORM\Column]
    private ?bool $isActiveCom = null;

    #[ORM\ManyToOne(inversedBy: 'comments')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Tricks $tricks = null;

    #[ORM\ManyToOne(inversedBy: 'comments')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $users = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getContentCom(): ?string
    {
        return $this->contentCom;
    }

    public function setContentCom(string $contentCom): static
    {
        $this->contentCom = $contentCom;

        return $this;
    }

    public function getDateCreateCom(): ?\DateTimeInterface
    {
        return $this->dateCreateCom;
    }

    public function setDateCreateCom(\DateTimeInterface $dateCreateCom): static
    {
        $this->dateCreateCom = $dateCreateCom;

        return $this;
    }

    public function isActiveCom(): ?bool
    {
        return $this->isActiveCom;
    }

    public function setActiveCom(bool $isActiveCom): static
    {
        $this->isActiveCom = $isActiveCom;

        return $this;
    }

    public function getTricks(): ?Tricks
    {
        return $this->tricks;
    }

    public function setTricks(?Tricks $tricks): static
    {
        $this->tricks = $tricks;

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
}
