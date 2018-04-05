<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Movie
 *
 * @ORM\Table(name="movie")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\MovieRepository")
 */
class Movie
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="IdIMDB", type="string", length=20, unique=true)
     */
    private $idIMDB;

    /**
     * @var string
     *
     * @ORM\Column(name="Poster", type="text", nullable=true)
     */
    private $poster;


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return Movie
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set idIMDB
     *
     * @param string $idIMDB
     *
     * @return Movie
     */
    public function setIdIMDB($idIMDB)
    {
        $this->idIMDB = $idIMDB;

        return $this;
    }

    /**
     * Get idIMDB
     *
     * @return string
     */
    public function getIdIMDB()
    {
        return $this->idIMDB;
    }

    /**
     * Set poster
     *
     * @param string $poster
     *
     * @return Movie
     */
    public function setPoster($poster)
    {
        $this->poster = $poster;

        return $this;
    }

    /**
     * Get poster
     *
     * @return string
     */
    public function getPoster()
    {
        return $this->poster;
    }
}

