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

    /**
     * @Route("/programmes/remove/{id}", name="ekino_remove_programme_by_id")
     * @param $id
     * @return JsonResponse
     * @throws \LogicException
     */
    public function removeById($id)
    {
        /** @var ProgrammeRepository $programmeRepository */
        $programmeRepository = $this->getDoctrine()
                                    ->getRepository(Programme::class);

        $programmeToRemove = $programmeRepository->find($id);

        $entityManager = $this->getDoctrine()
                                ->getManager();

        try{
            $entityManager -> remove($programmeToRemove);

            $entityManager -> flush();  
        }
        catch (\Exception $exception){
            return new JsonResponse(['error' =>  "Nie mozna usunac podanego programu." + $exception],
                400);
        }

        return new JsonResponse([
            'message' => "Pomyslnie usunieto program o podanym ID"
        ]);
    }
}
