<?php

namespace App\Entity;

use App\Repository\MoviesRepository;
use Doctrine\ORM\Mapping as ORM;

use App\Entity\Destacadas;

/**
 * @ORM\Entity(repositoryClass=MoviesRepository::class)
 */
class Movies
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
    private $nombre;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $productora;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $anno;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $poster;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $fanart;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $descripcion;

    /**
     * @ORM\Column(type="text")
     */
    private $url;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $idioma_subtitulo;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $duracion;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $director;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $genero;

    /**
     * @ORM\OneToOne(targetEntity=Destacadas::class, mappedBy="movies", cascade={"persist", "remove"})
     */
    private $destacadas;

    /**
     * @ORM\Column(type="boolean", length=255, nullable=true)
     */
    private $relevante;

    /**
     * @ORM\Column(type="boolean", length=255, nullable=true)
     */
    private $activate;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $tmdbid;

    public function __toString(): string
    {
        return $this->nombre;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNombre(): ?string
    {
        return $this->nombre;
    }

    public function setNombre(string $nombre): self
    {
        $this->nombre = $nombre;

        return $this;
    }

    public function getProductora(): ?string
    {
        return $this->productora;
    }

    public function setProductora(?string $productora): self
    {
        $this->productora = $productora;

        return $this;
    }

    public function getAnno(): ?string
    {
        return $this->anno;
    }

    public function setAnno(?string $anno): self
    {
        $this->anno = $anno;

        return $this;
    }

    public function getPoster(): ?string
    {
        return $this->poster;
    }

    public function setPoster(?string $poster): self
    {
        $this->poster = $poster;

        return $this;
    }

    public function getFanart(): ?string
    {
        return $this->fanart;
    }

    public function setFanart(?string $fanart): self
    {
        $this->fanart = $fanart;

        return $this;
    }

    public function getDescripcion(): ?string
    {
        return $this->descripcion;
    }

    public function setDescripcion(?string $descripcion): self
    {
        $this->descripcion = $descripcion;

        return $this;
    }

    public function getUrl(): ?string
    {
        return $this->url;
    }

    public function setUrl(string $url): self
    {
        $this->url = $url;

        return $this;
    }

    public function getIdiomaSubtitulo(): ?string
    {
        return $this->idioma_subtitulo;
    }

    public function setIdiomaSubtitulo(?string $idioma_subtitulo): self
    {
        $this->idioma_subtitulo = $idioma_subtitulo;

        return $this;
    }

    public function getDuracion(): ?int
    {
        return $this->duracion;
    }

    public function setDuracion(?int $duracion): self
    {
        $this->duracion = $duracion;

        return $this;
    }

    public function getDirector(): ?string
    {
        return $this->director;
    }

    public function setDirector(?string $director): self
    {
        $this->director = $director;

        return $this;
    }

    public function getGenero(): ?string
    {
        return $this->genero;
    }

    public function setGenero(?string $genero): self
    {
        $this->genero = $genero;

        return $this;
    }

    public function getDestacadas(): ?Destacadas
    {
        return $this->destacadas;
    }

    public function setDestacadas(Destacadas $destacadas): self
    {
        // set the owning side of the relation if necessary
        if ($destacadas->getMovies() !== $this) {
            $destacadas->setMovies($this);
        }

        $this->destacadas = $destacadas;

        return $this;
    }

    public function getRelevante(): ?string
    {
        return $this->relevante;
    }

    public function setRelevante(?string $relevante): self
    {
        $this->relevante = $relevante;

        return $this;
    }

    public function getTmdbid(): ?int
    {
        return $this->tmdbid;
    }

    public function setTmdbid(?int $tmdbid): self
    {
        $this->tmdbid = $tmdbid;

        return $this;
    }

    public function getActivate(): ?int
    {
        return $this->activate;
    }

    public function setActivate(?int $activate): self
    {
        $this->activate = $activate;

        return $this;
    }
}
