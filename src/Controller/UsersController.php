<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class UsersController extends AbstractController
{
    /**
     * @Route("/users/role/{roleId}", name="ekino_get_users_by_role")
     * @param $roleId
     * @return JsonResponse
     * @throws \LogicException
     */
    public function getUsersByRole($roleId)
    {
        /** @var UserRepository $userRepository */
        $userRepository = $this->getDoctrine()
                                ->getRepository(User::class);

        $usersWithAGivenRole = $userRepository->findByRoleId($roleId);

        return new JsonResponse([
            'users' => $usersWithAGivenRole
        ]);
    }

    /**
     * @Route("/users/email/{email}", name="ekino_get_user_by_email")
     * @param $email
     * @return JsonResponse
     * @throws \LogicException
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function getUserByEmail($email)
    {
        /** @var UserRepository $userRepository */
        $userRepository = $this->getDoctrine()
                                ->getRepository(User::class);

        $user = $userRepository->findByEmail($email);

        return new JsonResponse([
            'users' => $user
        ]);
    }

    /**
     * @Route("/users/{id}", name="ekino_get_user_by_id")
     * @param $id
     * @return JsonResponse
     * @throws \LogicException
     */
    public function getById($id)
    {
        /** @var UserRepository $userRepository */
        $userRepository = $this->getDoctrine()
                                ->getRepository(User::class);

        $user = $userRepository->find($id);

        if (empty($user)) {
            return new JsonResponse(['error' => [
                'code' => 400,
                'message' => "Nie znaleziono uzytkownika"
            ]]);
        }

        return new JsonResponse([
            'users' => $user
        ]);
    }

    /**
     * @Route("/users/remove/{id}", name="ekino_remove_user_by_id")
     * @param $id
     * @return JsonResponse
     * @throws \LogicException
     */
    public function removeById($id)
    {
        /** @var UserRepository $userRepository */
        $userRepository = $this->getDoctrine()
                                ->getRepository(User::class);

        $userToRemove = $userRepository->find($id);

        $entityManager = $this->getDoctrine()
                                ->getManager();

        try{
            $entityManager -> remove($userToRemove);

            $entityManager -> flush();
        }
        catch (\Exception $exception){
            return new JsonResponse(['error' =>  "Nie mozna usunac podanego uzytkownika." + $exception],
                400);
        }

        return new JsonResponse([
            'message' => "Pomyslnie usunieto uzytkownika o podanym ID"
        ]);
    }
}
