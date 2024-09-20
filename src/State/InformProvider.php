<?php

namespace App\State;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProviderInterface;
use App\Dto\Inform\InformOutputDto\InformOutputDto;
use App\Dto\Inform\InformOutputDto\InformOutputGetDataTransformer;
use App\Entity\Inform;
use App\State\CollectionProviderInterface;
use Symfony\Bundle\SecurityBundle\Security;


class InformProvider implements CollectionProviderInterface
{
    public function __construct(
        private ProviderInterface $collectionProvider,
        private InformOutputGetDataTransformer $informOutputGetDataTransformer,
        private Security $security
    )
    {}


    public function provide(Operation $operation, array $uriVariables = [], array $context = []): object|array|null
    {

        $user = $this->security->getUser();
        if (!$user)
            return [];
        
        $informs = $this->collectionProvider->provide($operation, $uriVariables, $context);

        $filteredInforms = array_filter(
            iterator_to_array($informs->getIterator()),
            fn (Inform $inform): bool => $inform->getAdmin() === $user 
        );

        return array_map(
            fn (Inform $inform): InformOutputDto => $this->informOutputGetDataTransformer->transform($inform),
            $filteredInforms
        );
    }
}
