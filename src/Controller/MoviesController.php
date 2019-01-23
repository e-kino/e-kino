<?php

namespace App\Controller;

use App\Entity\Movie;
use App\Repository\MovieRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
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
     * @param Request $request
     * @return JsonResponse
     * @throws \LogicException
     */
    public function createMovie(Request $request)
    {
        $movie = new Movie();
        $name = $request -> get('name');
        $description = $request -> get('description');
        $age = $request -> get('age');
        $dateAdd = $request ->get('date_add');

        if(empty($name) || empty($description) ||
           empty($age) || empty($dateAdd))
        {
            return new JsonResponse([
                'error' => "Podano puste pole dla filmu."
            ], 400);
        }

        $movie->setName($name);
        $movie->setDescription($description);
        $movie->setAge($age);
        $movie->setDateAdd($dateAdd);

        $entityManager = $this -> getDoctrine()
                                -> getManager();
        $entityManager->persist($movie);
        $entityManager->flush();

        return new JsonResponse([
                'message' => "Pomyslnie dodano nowy film."
            ]);
    }

    /**
     * @Route("/movies/{$id}", name="ekino_get_a_movie_by_id")
     * @param $id
     * @return JsonResponse
     * @throws \LogicException
     */
    public function getMovieById($id)
    {
        /** @var MovieRepository $movieRepository */
        $movieRepository = $this->getDoctrine()
                                ->getRepository(Movie::class);

        $movie = $movieRepository -> find($id);

        if(empty($movie)){
            return new JsonResponse(['error' => [
                'code' => 400,
                'message' => "Nie znaleziono filmu"
            ]]);
        }

        return new JsonResponse([
            'movie' => $movie
        ]);
    }

    /**
     * @Route("/movies/delete/{id}", name="ekino_delete_movies")
     * @param $id
     * @return JsonResponse
     * @throws \LogicException
     */
    public function deleteMovie($id)
    {
        /** @var MovieRepository $movieRepository */
        $movieRepository = $this->getDoctrine()
                                ->getRepository(Movie::class);

        $movie = $movieRepository -> find($id);

        $entityManager = $this -> getDoctrine()
                               -> getManager();

        try{
            $entityManager -> remove($movie);

            $entityManager -> flush();
        }
        catch (\Exception $exception){
            return new JsonResponse(['error' =>  "Nie mozna usunac podanego filmu.".$exception],
                400);
        }

        return new JsonResponse([
            'message' => "Pomyslnie usunieto film."
        ]);
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
