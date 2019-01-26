<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Booking
 *
 * @ORM\Table(name="booking", indexes={@ORM\Index(name="fk_booking_showing1_idx", columns={"showing_id"}), @ORM\Index(name="fk_booking_user1_idx", columns={"user_id"})})
 * @ORM\Entity(repositoryClass="App\Repository\BookingRepository")
 */
class Booking implements \JsonSerializable
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="date_add", type="datetime", nullable=true)
     */
    private $dateAdd;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="date_booking", type="datetime", nullable=true)
     */
    private $dateBooking;

    /**
     * @var int
     *
     * @ORM\Column(name="seat_number", type="integer", nullable=false)
     */
    private $seatNumber;

    /**
     * @var bool|null
     *
     * @ORM\Column(name="status", type="boolean", nullable=true)
     */
    private $status;

    /**
     * @var Showing
     *
     * @ORM\ManyToOne(targetEntity="Showing")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="showing_id", referencedColumnName="id")
     * })
     */
    private $showing;

    /**
     * @var User
     *
     * @ORM\OneToOne(targetEntity="User")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     * })
     */
    private $user;

    /**
     * @return int
     */
    public function getSeatNumber(): int
    {
        return $this->seatNumber;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId(int $id): void
    {
        $this->id = $id;
    }

    /**
     * @return \DateTime|null
     */
    public function getDateAdd(): ?\DateTime
    {
        return $this->dateAdd;
    }

    /**
     * @param \DateTime|null $dateAdd
     */
    public function setDateAdd(?\DateTime $dateAdd): void
    {
        $this->dateAdd = $dateAdd;
    }

    /**
     * @return \DateTime|null
     */
    public function getDateBooking(): ?\DateTime
    {
        return $this->dateBooking;
    }

    /**
     * @param \DateTime|null $dateBooking
     */
    public function setDateBooking(?\DateTime $dateBooking): void
    {
        $this->dateBooking = $dateBooking;
    }

    /**
     * @return bool|null
     */
    public function getStatus(): ?bool
    {
        return $this->status;
    }

    /**
     * @param bool|null $status
     */
    public function setStatus(?bool $status): void
    {
        $this->status = $status;
    }

    /**
     * @return Showing
     */
    public function getShowing(): Showing
    {
        return $this->showing;
    }

    /**
     * @param Showing $showing
     */
    public function setShowing(Showing $showing): void
    {
        $this->showing = $showing;
    }

    /**
     * @return User
     */
    public function getUser(): User
    {
        return $this->user;
    }

    /**
     * @param User|null $user
     */
    public function setUser(?User $user): void
    {
        $this->user = $user;
    }

    /**
     * @param int $seatNumber
     */
    public function setSeatNumber(int $seatNumber): void
    {
        $this->seatNumber = $seatNumber;
    }


    /**
     * Specify data which should be serialized to JSON
     * @link https://php.net/manual/en/jsonserializable.jsonserialize.php
     * @return mixed data which can be serialized by <b>json_encode</b>,
     * which is a value of any type other than a resource.
     * @since 5.4.0
     */
    public function jsonSerialize()
    {
        return [
            'id' => $this->getId(),
            'seatNumber' => $this->getSeatNumber(),
            'dateAdd' => $this->getDateAdd(),
            'dateBooking' => $this->getDateBooking()->format('Y-m-d H:i'),
            'user' => $this->getUser(),
            'status' => $this->getStatus(),
            'showing' => $this->getShowing()
        ];
    }
}
