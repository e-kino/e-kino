<?php

namespace App\Controller;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;

class LoginController extends AbstractController
{
    /**
     * @Route("/login", methods={"POST"}, name="ekino_login")
     * @param Request $request
     * @return JsonResponse
     */
    public function login(Request $request)
    {
        var_dump($request);
        //todo TB git test
        //todo get json from request
        //todo create new session
    }

    /**
     * @Route("/logout", methods={"POST"}, name="ekino_logout")
     * @param Request $request
     */
    public function logout(Request $request)
    {
        //todo TB
        //todo destroy session
    }
    protected function setSession($userData)
    {
        // SET SESSION 
    }
    /**
     * @Route("/login", methods={"GET"}, name="ekino_login")
     * @return JsonResponse
     */
    public function loginGet()
    {
        return new JsonResponse(['error' => [
                'code' => 405,
                'message' => "Method not allowed you ugly buster"
            ]]);
    }
    /**
     * @Route("/logout", methods={"GET"}, name="ekino_logout")
     * @return JsonResponse
     */
    public function logoutGet()
    {
        return new JsonResponse(['error' => [
                'code' => 405,
                'message' => "Method not allowed you ugly buster"
            ]]);
    }
}
