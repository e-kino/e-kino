<?php

namespace App\Controller;

use App\Entity\Movie;
use App\Entity\Programme;
use App\Entity\Showing;
use App\Repository\MovieRepository;
use App\Repository\ProgrammeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
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
     * @param Request $request
     * @return JsonResponse
     * @throws \Exception
     */
    public function createShowing(Request $request)
    {
        $post = json_decode($request->getContent(), true);

        $showing = new Showing();
        $dateAdd = $post['dateAdd'];
        $time_show = $post['timeShow'];

        $movie = $this->getDoctrine()
                        ->getRepository(Movie::class)
                        ->find($post['movie']['id']);

        $programme =$this->getDoctrine()
                        ->getRepository(Programme::class)
                        ->find(['programme']['id']);

        $showing->setDateAdd(new \DateTime($dateAdd));
        $showing->setTimeShow(new \DateTime($time_show));
        $showing->setMovie($movie);
        $showing->setProgramme($programme);

        $entityManager = $this->getDoctrine()
                                ->getManager();

        $entityManager->persist($showing);

        $entityManager->flush();

        return new JsonResponse([
            'message' => "Pomyslnie dodano nowy spektakl."
        ]);
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
