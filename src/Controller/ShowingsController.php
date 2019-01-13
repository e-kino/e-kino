<?php

namespace App\Controller;

use App\Entity\Programme;
use App\Entity\Showing;
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

        $currentProgramme = $programmeRepository->findCurrentProgramme();

        return new JsonResponse([
            'programme' => $currentProgramme,
            'showings' => $currentProgramme->getShowings()->toArray()
        ]);
    }
}
