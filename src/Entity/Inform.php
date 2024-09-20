<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\InformRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: InformRepository::class)]
#[ApiResource]
class Inform
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $alpha = null;

    #[ORM\Column(length: 255)]
    private ?string $betta = null;

    #[ORM\ManyToOne(inversedBy: 'informs')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Users $admin = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAlpha(): ?string
    {
        return $this->alpha;
    }

    public function setAlpha(string $alpha): static
    {
        $this->alpha = $alpha;

        return $this;
    }

    public function getBetta(): ?string
    {
        return $this->betta;
    }

    public function setBetta(string $betta): static
    {
        $this->betta = $betta;

        return $this;
    }

    public function getAdmin(): ?Users
    {
        return $this->admin;
    }

    public function setAdmin(?Users $admin): static
    {
        $this->admin = $admin;

        return $this;
    }
}
