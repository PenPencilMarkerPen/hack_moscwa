<?php
// src/Controller/InformController.php

namespace App\Controller;

use App\Entity\Inform;
use App\Entity\InformCollection;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\HttpKernel\Exception\HttpException;

class InformController extends AbstractController
{

    public function __construct(private EntityManagerInterface $entityManager, 
        private Security $security)
    {
        $this->entityManager = $entityManager;
        $this->security = $security;
    }

    public function __invoke(Request $request, InformCollection $data): Response
    {
        $user = $this->security->getUser();

        if (!$user)
            throw new AuthenticationException('User is not authenticated');  


        foreach ($data->getInforms() as $itemData) {
            $inform = new Inform();
            $inform->setAlpha($itemData['alpha']);
            $inform->setBetta($itemData['betta']);
            $inform->setAdmin($user); 
            $inform->setDateTime(time());
            $inform->setSession($user->getSessions()->last()); 
            $this->entityManager->persist($inform);
        }

        $this->entityManager->flush();

        return new Response('Informs created successfully', Response::HTTP_CREATED);
    }

    private function getUserByToken(string $token)
    {
        // Получите пользователя по токену
        // Пример: $this->userRepository->findOneBy(['token' => $token]);
    }
}
