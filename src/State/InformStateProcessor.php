<?php

namespace App\State;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;
use App\Entity\Inform;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\Security\Core\Exception\AuthenticationException;



class InformStateProcessor implements ProcessorInterface
{
    public function __construct(
        private ProcessorInterface $processor,
        private Security $security
    )
    {
        
    }

    public function process(mixed $data, Operation $operation, array $uriVariables = [], array $context = []): Inform
    {
        $user = $this->security->getUser();

        
        if (!$user)
            throw new AuthenticationException('User is not authenticated');  

        $data->setAdmin($user);
        $data->setSession($user->getSessions()->last());


        return $this->processor->process($data, $operation, $uriVariables, $context);

    }
}
