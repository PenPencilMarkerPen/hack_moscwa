<?php

namespace App\State;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;
use App\Entity\Session;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Bundle\SecurityBundle\Security;


class SessionStateProcessor implements ProcessorInterface
{

    public function __construct(
        private ProcessorInterface $processor,
        private Security $security
    )
    {
        
    }

    public function process(mixed $data, Operation $operation, array $uriVariables = [], array $context = []): Session
    {

        $user = $this->security->getUser();

        if (!$user)
            throw new AuthenticationException('User is not authenticated');

        $data->setUsers($user);
        $data->setDateTime(new \DateTime('now'));
    
        return $this->processor->process($data, $operation, $uriVariables, $context);
    }
}
 