<?php

namespace App\State;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProviderInterface;
use App\Dto\Inform\InformOutputDto\InformOutputDto;
use App\Dto\Inform\InformOutputDto\InformOutputGetDataTransformer;
use App\Entity\Inform;
use App\State\CollectionProviderInterface;

class InformProvider implements CollectionProviderInterface
{
    public function __construct(
        private ProviderInterface $collectionProvider,
        private InformOutputGetDataTransformer $informOutputGetDataTransformer,
    )
    {}


    public function provide(Operation $operation, array $uriVariables = [], array $context = []): object|array|null
    {
        

        return array_map(
        	fn (Inform $infrom): InformOutputDto => $this->informOutputGetDataTransformer->transform($infrom),
        	iterator_to_array(($this->collectionProvider->provide($operation, $uriVariables, $context))->getIterator())
    	);
    }
}
