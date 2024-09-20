<?php

namespace App\Dto\Inform\InformOutputDto;
use Symfony\Component\Serializer\Annotation\Groups;

class InformOutputDto
{

    #[Groups(['inform:read'])]
    private ?int $id = null;

    #[Groups(['inform:read'])]
    private ?string $alpha = null;

    #[Groups(['inform:read'])]
    private ?string $betta = null;


    public function __construct(
        int $id, 
        string $alpha,
        string $betta
    )
    {
        $this->id = $id;
        $this->alpha= $alpha;
        $this->betta= $betta;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAlpha(): ?string
    {
        return $this->alpha;
    }

    public function getBetta(): ?string
    {
        return $this->betta;
    }
}