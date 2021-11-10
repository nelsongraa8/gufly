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
     * @ORM\Column(type="integer", nullable=true)
     */
    private $tmdbid;

    /**
     * @ORM\Column(type="boolean", length=255, nullable=true)
     */
    private $activate;

    /**
     * @ORM\Column(type="boolean", length=255, nullable=true)
     */
    private $relevante;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $nombre;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $anno;

    /**
     * @ORM\Column(type="text")
     */
    private $url;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $url_subtitulo;

    /**
     * @ORM\OneToOne(targetEntity=Themoviedb::class, mappedBy="idmovie", cascade={"persist", "remove"})
     */
    private $themoviedb;

    public function __toString(): string
    {
        return $this->id;
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

    public function getAnno(): ?string
    {
        return $this->anno;
    }

    public function setAnno(?string $anno): self
    {
        $this->anno = $anno;

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

    public function getUrlSubtitulo(): ?string
    {
        return $this->url_subtitulo;
    }

    public function setUrlSubtitulo(?string $url_subtitulo): self
    {
        $this->url_subtitulo = $url_subtitulo;

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

    public function getThemoviedb(): ?Themoviedb
    {
        return $this->themoviedb;
    }

    public function setThemoviedb(Themoviedb $themoviedb): self
    {
        // set the owning side of the relation if necessary
        if ($themoviedb->getIdmovie() !== $this) {
            $themoviedb->setIdmovie($this);
        }

        $this->themoviedb = $themoviedb;

        return $this;
    }
}
