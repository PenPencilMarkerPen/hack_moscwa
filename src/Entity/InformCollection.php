<?php

namespace App\Entity;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\ApiResource as MetadataApiResource;
use ApiPlatform\Metadata\Post;
use App\Controller\InformController;
use Symfony\Component\Serializer\Annotation\Groups;


#[ApiResource(
    operations: [
        new Post(
            uriTemplate: '/inform_collection',
            controller: InformController::class,
            denormalizationContext: ['groups' => ['inform:create']]
        )
    ]
)]
class InformCollection
{
    #[Groups(['inform:create'])]
    public array $informs;

    public function getInforms(): array
    {
        return $this->informs;
    }

    public function setInforms(array $informs): void
    {
        $this->informs = $informs;
    }
}