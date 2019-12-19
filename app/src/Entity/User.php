<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 */
class User implements \JsonSerializable
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $pseudo;

    /**
     * @ORM\Column(type="datetime")
     */
    private $date_naissance;

    /**
     * @ORM\Column(type="datetime")
     */
    private $date_inserted;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Movie", mappedBy="user")
     */
    private $movies;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $email;

    public function __construct()
    {
        $this->movies = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPseudo(): ?string
    {
        return $this->pseudo;
    }

    public function setPseudo(string $pseudo): self
    {
        $this->pseudo = $pseudo;

        return $this;
    }

    public function getDateNaissance(): ?\DateTimeInterface
    {
        return $this->date_naissance;
    }

    public function setDateNaissance(\DateTimeInterface $date_naissance): self
    {
        $this->date_naissance = $date_naissance;

        return $this;
    }

    public function getDateInserted(): ?\DateTimeInterface
    {
        return $this->date_inserted;
    }

    public function setDateInserted(\DateTimeInterface $date_inserted): self
    {
        $this->date_inserted = $date_inserted;

        return $this;
    }

    /**
     * @return Collection|Movie[]
     */
    public function getMovies(): Collection
    {
        return $this->movies;
    }

    public function addMovie(Movie $movie): self
    {
        if (!$this->movies->contains($movie)) {
            $this->movies[] = $movie;
            $movie->addUser($this);
        }

        return $this;
    }

    public function removeMovie(Movie $movie): self
    {
        if ($this->movies->contains($movie)) {
            $this->movies->removeElement($movie);
            $movie->removeUser($this);
        }

        return $this;
    }

    public function hasMovie($movie)
    {
        $arrIdsMovies = [];
        foreach ($this->getMovies() as $objMovie) {
            $arrIdsMovies[] = $objMovie->getId();
        }
        if (in_array($movie->getId(), $arrIdsMovies)) {
            return true;
        }

        return false;
    }

    public function toArray()
    {
        return [
            'id' => $this->getId(),
            'pseudo' => $this->getPseudo(),
            'date_naissance' => $this->getDateNaissance(),
            'date_inserted' => $this->getDateInserted(),
        ];
    }

    public function jsonSerialize()
    {
        return json_encode($this->toArray());
    }

    public function __toString()
    {
        return ''.$this->jsonSerialize();
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }
}
