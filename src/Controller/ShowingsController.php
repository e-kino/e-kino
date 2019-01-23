<?php

namespace App\Controller;

use App\Entity\Programme;
use App\Repository\ProgrammeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class ShowingsController extends AbstractController
{
    /**
     * @Route("/showings/{date}", name="ekino_get_showings_by_date")
     * @param $date
     * @return JsonResponse
     * @throws \Doctrine\ORM\NonUniqueResultException
     * @throws \LogicException
     */
    public function getByDate($date)
    {
        /** @var ProgrammeRepository $programmeRepository */
        $programmeRepository = $this->getDoctrine()
            ->getRepository(Programme::class);

        $currentProgramme = $programmeRepository->findByDate($date);

        $showings = [];
        if ($currentProgramme) {
            $showings = $currentProgramme->getShowings()->toArray();
        }

        return new JsonResponse([
            'showings' => $showings
        ]);
    }

    /**
     * @Route("/showings", methods={"POST"}, name="ekino_create_showing")
     */
    public function createShowing()
    {
        //todo
        //todo DW

    }

    /**
     * @Route("/showings/{id}", methods={"DELETE"}, name="ekino_delete_showing")
     * @param $id
     * @return JsonResponse
     */
    public function deleteShowing($id)
    {
        $showingToRemove = $this->getDoctrine()
            ->getRepository(Showing::class)
            ->find($id);

        $entityManager = $this->getDoctrine()
            ->getManager();

        try{
            $entityManager -> remove($showingToRemove);

            $entityManager -> flush();
        }
        catch (\Exception $exception){
            return new JsonResponse(['error' =>  "Nie mozna usunac podanego spektaklu.".$exception],
                400);
        }

        return new JsonResponse([
            'message' => "Pomyslnie usunieto spektakl o podanym ID"
        ]);
    }
}
