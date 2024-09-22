<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Post;
use App\Dto\Inform\InformOutputDto\InformOutputDto;
use App\Repository\InformRepository;
use App\State\InformProvider;
use App\State\InformStateProcessor;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Doctrine\Common\Collections\Collection;



#[ORM\Entity(repositoryClass: InformRepository::class)]
#[ApiResource(
    paginationEnabled: false,
    operations: [
        new GetCollection(
            output: InformOutputDto::class,
            provider: InformProvider::class,
        ),
        new Post(
            processor: InformStateProcessor::class,
            inputFormats: ['json' => ['application/ld+json']],
        ),
    ],
    normalizationContext: ['groups' => ['inform:read']],
    denormalizationContext: ['groups' => ['inform:create', 'inform:update']],
)]
class Inform
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['inform:read'])]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups(['inform:read', 'inform:create'])]
    private ?string $alpha = null;

    #[ORM\Column(length: 255)]
    #[Groups(['inform:read', 'inform:create'])]
    private ?string $betta = null;

    #[ORM\ManyToOne(inversedBy: 'informs')]
    #[Groups(['inform:read'])]
    #[ORM\JoinColumn(nullable: false)]
    private ?Users $admin = null;

    #[ORM\ManyToOne(inversedBy: 'informs')]
    private ?Session $session = null;

    #[ORM\Column()]
    private ?string $dateTime = null;


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

    public function getSession(): ?Session
    {
        return $this->session;
    }

    public function setSession(?Session $session): static
    {
        $this->session = $session;

        return $this;
    }

    public function getDateTime(): string
    {
        return $this->dateTime;
    }

    public function setDateTime(string $dateTime = null): static
    {
        $this->dateTime = $dateTime;

        return $this;
    }

}
