<?php

namespace App\State;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;
use App\Entity\Users;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserPasswordHasher implements ProcessorInterface
{
    public function __construct( 
        private ProcessorInterface $processor,
    private UserPasswordHasherInterface $passwordHasher)
    {}


    public function process(mixed $data, Operation $operation, array $uriVariables = [], array $context = []): Users
    {
        $hashedPassword = $this->passwordHasher->hashPassword(
            $data,
            $data->getPassword()
        );



        $data->setPassword($hashedPassword);
        $data->setRoles(['ROLE_USER']);

        return $this->processor->process($data, $operation, $uriVariables, $context);

    }
}
