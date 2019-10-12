<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CompetenceRepository")
 */
class Competence
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $nom;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $description;


    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $dateCreation;


    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $token;

    /** liste des missions
     *  @ORM\ManyToMany(targetEntity="App\Entity\Mission", inversedBy="competences")
     * @ORM\JoinTable(name="competences_missions",
     *      joinColumns={@ORM\JoinColumn(name="mission_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="competence_id", referencedColumnName="id")}
     *      )
     */
    private $missions;

    /** liste des users
     *  @ORM\ManyToMany(targetEntity="App\Entity\User", inversedBy="competences")
     * @ORM\JoinTable(name="competences_users",
     *      joinColumns={@ORM\JoinColumn(name="user_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="competence_id", referencedColumnName="id")}
     *      )
     */
    private $users;

    /**
     * Competence constructor.
     */
    public function __construct()
    {
        $this->dateCreation = new \DateTime();

    }


    public function getId(): ?int
    {
        return $this->id;
    }


}
