<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\SessionRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use ApiPlatform\Metadata\Post;
use App\State\SessionStateProcessor;

#[ORM\Entity(repositoryClass: SessionRepository::class)]
#[ApiResource(
    operations:[
        new Post(processor: SessionStateProcessor::class, validationContext: ['groups' => ['Default', 'session:create']]),
    ],
    normalizationContext: ['groups' => ['user:read']],
    denormalizationContext: ['groups' => ['user:create', 'user:update']],
)]
class Session
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?string $date_time = null;

    #[ORM\ManyToOne(inversedBy: 'sessions')]
    private ?Users $users = null;

    /**
     * @var Collection<int, Inform>
     */
    #[ORM\OneToMany(targetEntity: Inform::class, mappedBy: 'session')]
    private Collection $informs;

    public function __construct()
    {
        $this->informs = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDateTime(): ?string
    {
        return $this->date_time;
    }

    public function setDateTime(string $date_time ): static
    {
        $this->date_time = $date_time;

        return $this;
    }

    public function getUsers(): ?Users
    {
        return $this->users;
    }

    public function setUsers(?Users $users): static
    {
        $this->users = $users;

        return $this;
    }

    /**
     * @return Collection<int, Inform>
     */
    public function getInforms(): Collection
    {
        return $this->informs;
    }

    public function addInform(Inform $inform): static
    {
        if (!$this->informs->contains($inform)) {
            $this->informs->add($inform);
            $inform->setSession($this);
        }

        return $this;
    }

    public function removeInform(Inform $inform): static
    {
        if ($this->informs->removeElement($inform)) {
            // set the owning side to null (unless already changed)
            if ($inform->getSession() === $this) {
                $inform->setSession(null);
            }
        }

        return $this;
    }
}
