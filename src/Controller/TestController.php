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

    #[Route('/test', name: 'app_test')]
    public function index(): Response
    {
        return $this->render('test/index.html.twig', [
            'controller_name' => 'TestController',
        ]);
    }

    #[Route('/api/test', name: 'api_test')]
    public function test(): Response 
    {

        var_dump($this->security->getUser()->getEmail());

        $response = new Response(
            'Content',
            Response::HTTP_OK,
        );

        return  $response;
    }
}
