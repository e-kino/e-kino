<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class RegisterController extends AbstractController
{
    /**
     * @Route("/register", methods={"POST"} name="ekino_register")
     * @param Request $request
     * @return JsonResponse
     */
    public function register(Request $request)
    {
        //todo TB

        //todo get json from request
        //todo create new user and return it
    }
    /**
     * @Route("/register", methods={"GET"} name="ekino_register_get")
     * @return JsonResponse
     */
    public function registerGet()
    {
        return new JsonResponse([
            'error' => [
                'code' => 405,
                'message' => "Method not allowed you ugly buster"
            ]
        ]);
    }
}
