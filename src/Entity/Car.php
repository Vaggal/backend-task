<?php

namespace App\Entity;

use App\Entity\Colour;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\CarRepository;
use Doctrine\ORM\Mapping\ManyToOne;
use Doctrine\ORM\Mapping\JoinColumn;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\ConstraintViolation;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\ConstraintViolationList;

/**
 * @ORM\Entity(repositoryClass=CarRepository::class)
 */
class Car
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"car"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"car"})
     */
    private $make;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"car"})
     */
    private $model;

    /**
     * @ORM\Column(type="date")
     * @Groups({"car"})
     */
    private $build_date;

    /**
     * @ManyToOne(targetEntity="Colour")
     * @JoinColumn(name="colour_id", referencedColumnName="id")
     * @Groups({"car"})
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

    public function getColour(): Colour
    {
        return $this->colour;
    }

    public function setColour(Colour $colour): self
    {
        $this->colour = $colour;

        return $this;
    }

    public function validateDate(): ConstraintViolationList
    {
        $violations = new ConstraintViolationList();
        $carDate = $this->build_date;
        $now = new \DateTime();
        if ($carDate->diff($now)->y >= 4) {
            $violations->add(new ConstraintViolation(
                "The car's build date cannot be older than 4 years",
                "",
                [],
                $carDate,
                "build_date",
                $carDate
            ));
        }
        return $violations;
    }
}
