<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Showing
 *
 * @ORM\Table(name="showing", indexes={@ORM\Index(name="fk_showing_film1_idx", columns={"movie_id"}), @ORM\Index(name="fk_showing_programme1_idx", columns={"programme_id"})})
 * @ORM\Entity
 */
class Showing implements \JsonSerializable
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
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
     * @ORM\Column(name="time_show", type="time", nullable=true)
     */
    private $timeShow;

    /**
     * @var Movie
     *
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     * @ORM\OneToOne(targetEntity="Movie")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="movie_id", referencedColumnName="id")
     * })
     */
    private $movie;

    /**
     * @var Programme
     *
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     * @ORM\OneToOne(targetEntity="Programme")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="programme_id", referencedColumnName="id")
     * })
     */
    private $programme;

    public function jsonSerialize()
    {
        return [
            'id' => $this->id,
            'dateAdd' => $this->dateAdd->format('Y-m-d H:i:s'),
            'timeShow' => $this->timeShow->format('H:i'),
            'movie' => $this->movie,
            'programme' => $this->programme
        ];
    }

    /**
     * @return Movie
     */
    public function getMovie(): Movie
    {
        return $this->movie;
    }

    /**
     * @return Programme
     */
    public function getProgramme(): Programme
    {
        return $this->programme;
    }

    /**
     * @param \DateTime|null $dateAdd
     */
    public function setDateAdd(?\DateTime $dateAdd): void
    {
        $this->dateAdd = $dateAdd->format('Y-m-d H:i:s');
    }

    /**
     * @param \DateTime|null $timeShow
     */
    public function setTimeShow(?\DateTime $timeShow): void
    {
        $this->timeShow = $timeShow->format('Y-m-d H:i:s');
    }

    /**
     * @param Movie $movie
     */
    public function setMovie(Movie $movie): void
    {
        $this->movie = $movie;
    }

    /**
     * @param Programme $programme
     */
    public function setProgramme(Programme $programme): void
    {
        $this->programme = $programme;
    }
}
