<?php

namespace App\Controller;

use App\Entity\Movie;
use App\Repository\MovieRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class MoviesController extends AbstractController
{
    /**
     * @Route("/movies/{name}", name="ekino_get_movies_by_name")
     * @param $name
     * @return JsonResponse
     * @throws \Doctrine\ORM\NonUniqueResultException
     * @throws \LogicException
     */
    public function getByName($name)
    {
        /** @var MovieRepository $movieRepository */
        $movieRepository = $this->getDoctrine()
                                ->getRepository(Movie::class);

        $movieForAGivenName = $movieRepository->findByName($name);

        return new JsonResponse([
            'movies' => $movieForAGivenName
        ]);
    }

    /**
     * @Route("/movies", methods={"POST"}, name="ekino_create_movies")
     */
    public function createMovie()
    {
        //todo DW
        //todo
    }

    /**
     * @Route("/movies/{id}", methods={"DELETE"}, name="ekino_delete_movies")
     * @param $id
     */
    public function deleteMovie($id)
    {
        //todo DW
        //todo
    }

    /**
     * @Route("/movies", name="ekino_get_all_movies")
     * @return JsonResponse
     * @throws \LogicException
     */
    public function getAll()
    {
        /** @var MovieRepository $movieRepository */
        $movieRepository = $this->getDoctrine()
            ->getRepository(Movie::class);

        $movies = $movieRepository->findAll();

        if (empty($movies)) {
            return new JsonResponse(['error' => [
                'code' => 400,
                'message' => "Nie znaleziono filmow"
            ]]);
        }

        return new JsonResponse([
            'movies' => $movies
        ]);
    }
}
