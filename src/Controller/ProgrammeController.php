<?php

namespace App\Controller;

use App\Entity\Programme;
use App\Repository\ProgrammeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
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
}
