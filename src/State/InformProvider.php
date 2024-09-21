<?php

namespace App\State;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProviderInterface;
use App\Dto\Inform\InformOutputDto\InformOutputDto;
use App\Dto\Inform\InformOutputDto\InformOutputGetDataTransformer;
use App\Entity\Inform;
use App\State\CollectionProviderInterface;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\Security\Core\Exception\AuthenticationException;

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
            throw new AuthenticationException('User is not authenticated');        

        $informs = $this->collectionProvider->provide($operation, $uriVariables, $context);

    
        $filteredInforms = array_filter(
            $informs,
            fn (Inform $inform): bool => $inform->getAdmin() === $user 
        );

        return array_map(
            fn (Inform $inform): InformOutputDto => $this->informOutputGetDataTransformer->transform($inform),
            $filteredInforms
        );
    }
}
