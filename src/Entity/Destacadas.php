<?php

namespace App\Entity;

use App\Repository\DestacadasRepository;
use Doctrine\ORM\Mapping as ORM;

use App\Entity\Movies;

/**
 * @ORM\Entity(repositoryClass=DestacadasRepository::class)
 */
class Destacadas
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\OneToOne(targetEntity=Movies::class, inversedBy="destacadas", cascade={"persist", "remove"})
     */
    private $movies;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $title;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $text;

    public function __toString(): string
    {
        return (string) $this->getMovies();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMovies(): ?movies
    {
        return $this->movies;
    }

    public function setMovies(movies $movies): self
    {
        $this->movies = $movies;

        return $this;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(?string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getText(): ?string
    {
        return $this->text;
    }

    public function setText(?string $text): self
    {
        $this->text = $text;

        return $this;
    }
}
