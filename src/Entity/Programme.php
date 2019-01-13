<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Programme
 *
 * @ORM\Table(name="programme")
 * @ORM\Entity(repositoryClass="App\Repository\ProgrammeRepository")
 */
class Programme implements \JsonSerializable
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
     * @ORM\Column(name="date_start", type="datetime", nullable=true)
     */
    private $dateStart;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="date_end", type="datetime", nullable=true)
     */
    private $dateEnd;

    /**
     * @var Showing[]|ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="App\Entity\Showing", mappedBy="programme")
     */
    private $showings;

    public function __construct()
    {
        $this->showings = new ArrayCollection();
    }

    public function jsonSerialize()
    {
        return [
            'id' => $this->id,
            'dateAdd' => $this->dateAdd->format('Y-m-d H:i:s'),
            'dateStart' => $this->dateStart->format('Y-m-d H:i:s'),
            'dateEnd' => $this->dateEnd->format('Y-m-d H:i:s'),
        ];
    }

    /**
     * @return Showing[]|Collection
     */
    public function getShowings(): Collection
    {
        return $this->showings;
    }
}
