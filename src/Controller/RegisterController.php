<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class RegisterController extends AbstractController
{
    /**
     * @Route("/register", methods={"POST"}, name="ekino_register")
     * @param Request $request
     */
    public function register(Request $request)
    {
        //todo TB

        //todo get json from request
        //todo create new user and return it
    }
}
