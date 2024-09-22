<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Bundle\SecurityBundle\Security;


class ProfileController extends AbstractController
{
    public function __construct(
        private Security $security)
    {
    }

    #[Route('/profile', name: 'app_profile')]
    public function index(): Response
    {
        $user = $this->security->getUser();

        if (!$user)
            return $this->redirectToRoute('app_login');

        $sessionData = [];

        $sessions = $user->getSessions()->toArray();

        foreach (array_reverse($sessions) as $session) {

            $sessionData[] = [
                'date' => $session->getDateTime(),
                'informs' => $session->getInforms()->toArray(), 
            ];
        }


        return $this->render('profile/index.html.twig', [
            'controller_name' => 'ProfileController',
            'email' =>$user->getEmail(),
            'sessions' => $sessionData,
        ]);
    }
}
