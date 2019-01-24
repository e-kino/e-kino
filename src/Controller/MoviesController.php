<?php

namespace App\Controller;

use App\Entity\Movie;
use App\Repository\MovieRepository;
use DateTime;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class MoviesController extends AbstractController
{
    /**
     * @Route("/movies/name/{name}", methods={"GET"}, name="ekino_get_movies_by_name")
     * @param $name
     * @return JsonResponse
     * @throws \LogicException
     */
    public function getByName($name)
    {
        $movieRepository = $this->getDoctrine()
                                ->getRepository(Movie::class);

        $movieForAGivenName = $movieRepository->findByName($name);

        if (is_null($movieForAGivenName)) {
            return new JsonResponse([
                'error' =>  "Nie znaleziono filmu"
            ],400);
        }

        return new JsonResponse([
            'movies' => $movieForAGivenName
        ]);
    }

    /**
     * @Route("/movies/{id}", methods={"GET"}, name="ekino_get_movies_by_id")
     * @param $id
     * @return JsonResponse
     * @throws \LogicException
     */
    public function getById($id)
    {
        $movie = $this->getDoctrine()
                        ->getRepository(Movie::class)
                        ->find($id);

        if (!$movie) {
            return new JsonResponse([
                'error' =>  "Nie znaleziono filmu"
            ],400);
        }

        return new JsonResponse([
            'movies' => $movie
        ]);
    }

    /**
     * @Route("/movies/{id}", methods={"DELETE"}, name="ekino_delete_movies")
     * @param $id
     * @return JsonResponse
     * @throws \LogicException
     */
    public function deleteMovie($id)
    {
        /** @var MovieRepository $movieRepository */
        $movieRepository = $this->getDoctrine()
                                ->getRepository(Movie::class);
        $movie = $movieRepository->find($id);
        print_r($movie);
        var_dump($movie);
        $entityManager = $this->getDoctrine()
            ->getManager();

        try {
            $entityManager->remove($movie);

            $entityManager->flush();
        } catch (\Exception $exception) {
            return new JsonResponse(['error' => "Nie mozna usunac podanego filmu." . $exception],
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
            return new JsonResponse([
                'error' => [
                    'code' => 400,
                    'message' => "Nie znaleziono filmow"
                ]
            ]);
        }

        return new JsonResponse([
            'movies' => $movies
        ]);
    }

    /**
     * @Route("/movies/add", methods={"POST"}, name="ekino_create_movies")
     * @param Request $request
     * @return JsonResponse
     * @throws \Exception
     */
    public function createMovie(Request $request)
    {
        $movie = new Movie();
        $post = json_decode($request->getContent(), true);
        $name = $post['name'];
        $description = $post['description'];
        $age = $post['age'];
        $dateAdd = $post['date_add'];

        $movie->setDateAdd(new DateTime($dateAdd));
        $movie->setAge($age);
        $movie->setDescription($description);
        $movie->setName($name);

        $entityManager = $this->getDoctrine()
                                ->getManager();

        $entityManager->persist($movie);

        $entityManager->flush();

        return new JsonResponse([
            'message' => "Pomyslnie dodano nowy film."
        ]);
    }
}
