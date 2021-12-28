<?php

namespace App\Entity;

use App\Repository\ThemoviedbRepository;
use App\Repository\MoviesRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ThemoviedbRepository::class)
 */
class Themoviedb
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
    private $title;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $release_date;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $backdrop_path;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $poster_path;

    /**
     * @ORM\OneToOne(targetEntity=Movies::class, inversedBy="themoviedb", cascade={"persist", "remove"})
     */
    private $idmovie;


    public function __toString(): string
    {
        return $this->getIdmovie();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getReleaseDate(): ?string
    {
        return $this->release_date;
    }

    public function setReleaseDate(string $release_date): self
    {
        $this->release_date = $release_date;

        return $this;
    }

    public function getBackdropPath(): ?string
    {
        return $this->backdrop_path;
    }

    public function setBackdropPath(string $backdrop_path): self
    {
        $this->backdrop_path = $backdrop_path;

        return $this;
    }

    public function getPosterPath(): ?string
    {
        return $this->poster_path;
    }

    public function setPosterPath(string $poster_path): self
    {
        $this->poster_path = $poster_path;

        return $this;
    }

    public function getIdmovie(): ?movies
    {
        return $this->idmovie;
    }

    public function setIdmovie(movies $idmovie): self
    {
        $this->idmovie = $idmovie;

        return $this;
    }
}
