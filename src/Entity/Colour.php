<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\ColourRepository;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=ColourRepository::class)
 */
class Colour
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"colour"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"car", "colour"})
     * @Assert\Choice({"red", "blue", "white", "black"})
     */
    private $name;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }
}
