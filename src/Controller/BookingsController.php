<?php

namespace App\Controller;

use App\Entity\Booking;
use App\Entity\Showing;
use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class BookingsController extends AbstractController
{
    /**
     * @Route("/bookings", methods={"POST"}, name="ekino_create_bookings")
     * @param Request $request
     * @return JsonResponse
     * @throws \Doctrine\ORM\NonUniqueResultException
     * @throws \LogicException
     */
    public function createBooking(Request $request)
    {
        session_start();

        $userData = json_decode($request->getContent());

        $entityManager = $this->getDoctrine()->getManager();

        $showing = $this->getDoctrine()
            ->getRepository(Showing::class)
            ->find($userData->showingId);

        if (isset($_SESSION['user'])) {
            $sessionUser = $_SESSION['user'];
            $user = $this->getDoctrine()
                ->getRepository(User::class)
                ->findByEmail($sessionUser->getEmail());
        } else {
            $user = new User();
            $user->setDateAdd(new \DateTime());
            $user->setRoleId(0);
            $user->setEmail(uniqid('temp_', true));
            $entityManager->persist($user);
            $entityManager->flush();
        }

        $bookings = [];

        $dateBooking = \DateTime::createFromFormat('Y-m-d H:i', $userData->dateBooking);

        foreach ($userData->seats as $seat) {
            $booking = new Booking();
            $booking->setDateAdd(new \DateTime());
            $booking->setDateBooking($dateBooking);
            $booking->setSeatNumber($seat);
            $booking->setStatus(false);
            $booking->setUser($user);
            $booking->setShowing($showing);
            $bookings[] = $booking;
        }

        foreach ($bookings as $booking) {
            $entityManager->persist($booking);
        }

        $entityManager->flush();

        return new JsonResponse([
            "bookings" => $bookings
        ]);
    }

    /**
     * @Route("/bookings/user", name="ekino_get_user_bookings")
     * @param $userId
     * @return JsonResponse
     * @throws \LogicException
     */
    public function getUserBookings()
    {
        session_start();

        if (!isset($_SESSION['user'])) {
            return new JsonResponse([
                'bookings' => []
            ]);
        }

        /** @var User $user */
        $user = $_SESSION['user'];

        $bookings = $this->getDoctrine()
            ->getRepository(Booking::class)
            ->findByUser($user)
        ;

        return new JsonResponse([
            'bookings' => array_reverse($bookings)
        ]);
    }
    /**
     * @Route("/bookings/all", methods={"GET"}, name="ekino_get_all_bookings")
     * @return JsonResponse
     * @throws \LogicException
     */
    public function getAll()
    {
        
       
        $bookingsRepo= $this->getDoctrine()
            ->getRepository(Booking::class);

        $bookingsAll = $bookingsRepo->findAll();
        //$bookingsAll = $bookingsRepo->createQueryBuilder('b')->select('b.id as ID')->getQuery();
        
         if (empty($bookingsAll)) {
            return new JsonResponse(['error' => [
                'code' => 400,
                'message' => "Nie znaleziono rezerwacji"
            ]]);
        }

        return new JsonResponse([
            'bookings' => $bookingsAll
        ]);
        
        session_start();
        if (!isset($_SESSION['user'])) {
            return new JsonResponse([
                'bookings' => []
            ]);
        }     
    }
}
