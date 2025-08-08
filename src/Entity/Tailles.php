<?php

namespace App\Entity;

use App\Repository\TaillesRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TaillesRepository::class)]
class Tailles
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $libeles_tailles = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLibelesTailles(): ?string
    {
        return $this->libeles_tailles;
    }

    public function setLibelesTailles(string $libeles_tailles): static
    {
        $this->libeles_tailles = $libeles_tailles;

        return $this;
    }
}
