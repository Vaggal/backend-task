<?php

namespace App\Entity;

use App\Entity\Colour;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\CarRepository;
use Doctrine\ORM\Mapping\ManyToOne;
use Doctrine\ORM\Mapping\JoinColumn;

/**
 * @ORM\Entity(repositoryClass=CarRepository::class)
 */
class Car
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $make;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $model;

    /**
     * @ORM\Column(type="date")
     */
    private $build_date;

    /**
     * @ManyToOne(targetEntity="Colour")
     * @JoinColumn(name="colour_id", referencedColumnName="id")
     */
    private $colour;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMake(): ?string
    {
        return $this->make;
    }

    public function setMake(string $make): self
    {
        $this->make = $make;

        return $this;
    }

    public function getModel(): ?string
    {
        return $this->model;
    }

    public function setModel(string $model): self
    {
        $this->model = $model;

        return $this;
    }

    public function getBuildDate(): ?\DateTimeInterface
    {
        return $this->build_date;
    }

    public function setBuildDate(\DateTimeInterface $build_date): self
    {
        $this->build_date = $build_date;

        return $this;
    }

    public function getColour()
    {
        return $this->colour;
    }

    public function setColour($colour): self
    {
        $this->colour = $colour;

        return $this;
    }
}
