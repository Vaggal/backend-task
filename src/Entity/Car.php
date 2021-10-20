<?php

namespace App\Entity;

use App\Repository\CarRepository;
use Doctrine\ORM\Mapping as ORM;

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
     * @ORM\Column(type="integer")
     */
    private $colour_id;

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

    public function getColourId(): ?int
    {
        return $this->colour_id;
    }

    public function setColourId(int $colour_id): self
    {
        $this->colour_id = $colour_id;

        return $this;
    }
}
