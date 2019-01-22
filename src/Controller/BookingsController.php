<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class BookingsController extends AbstractController
{
    /**
     * @Route("/bookings", methods={"POST"}, name="ekino_get_showings_by_date")
     */
    public function createBooking()
    {
        //todo TB
    }

    /**
     * @Route("/bookings/user/{userId}", methods={"POST"}, name="ekino_get_user_bookings")
     * @param $userId
     */
    public function getUserBookings($userId)
    {
        //todo TB
    }

    public function getAll()
    {
        //todo TB
    }
}
