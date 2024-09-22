<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class TestController extends AbstractController
{

    public function __construct(
        private Security $security)
    {
    }

    #[Route('/', name: 'app_test')]
    public function index(): Response
    {
        $user = $this->security->getUser();

        if (!$user)
            return $this->redirectToRoute('app_login');


          return $this->redirectToRoute('app_profile');
    }
}
