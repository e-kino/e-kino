<?php

namespace App\Controller;

use App\Entity\Programme;
use App\Repository\ProgrammeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class ProgrammeController extends AbstractController
{
    /**
     * @Route("/programmes", name="ekino_get_all_programmes")
     * @return JsonResponse
     * @throws \LogicException
     */
    public function getAll()
    {
        /** @var ProgrammeRepository $programmeRepository */
        $programmeRepository = $this->getDoctrine()
            ->getRepository(Programme::class);

        $programmes = $programmeRepository->findAll();

        if (empty($programmes)) {
            return new JsonResponse(['error' => [
                'code' => 400,
                'message' => "Nie znaleziono programow"
            ]]);
        }

        return new JsonResponse([
            'programmes' => $programmes
        ]);
    }

    /**
     * @Route("/programmes/{id}", name="ekino_get_programme_by_id")
     * @param $id
     * @return JsonResponse
     * @throws \LogicException
     */
    public function getById($id)
    {
        /** @var ProgrammeRepository $programmeRepository */
        $programmeRepository = $this->getDoctrine()
            ->getRepository(Programme::class);

        $programme = $programmeRepository->find($id);

        if (empty($programme)) {
            return new JsonResponse(['error' => [
                'code' => 400,
                'message' => "Nie znaleziono programu"
            ]]);
        }

        return new JsonResponse([
            'programmes' => $programme
        ]);
    }
}
