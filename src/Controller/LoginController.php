<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class LoginController extends AbstractController
{
    /**
     * @Route("/login", methods={"POST"} name="ekino_login")
     * @param Request $request
     */
    public function login(Request $request)
    {
        //todo TB
        //todo get json from request
        //todo create new session
    }

    /**
     * @Route("/logout", methods={"POST"} name="ekino_logout")
     * @param Request $request
     */
    public function logout(Request $request)
    {
        //todo TB
        //todo destroy session
    }
}
