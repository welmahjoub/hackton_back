<?php

namespace App\Entity;


use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 */
class User
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    protected $id;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $dateConfirmation;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $dateCreation;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $estActif;

    /**
     * @var
     * @ORM\Column(type="string",nullable=true)
     */
    private $nom;

    /**
     * @var
     * @ORM\Column(type="string",nullable=true)
     */
    private $prenom;

    /**
     * @var
     * @ORM\Column(type="string")
     **/
    protected $email;

    /**
     * @var
     * @ORM\Column(type="string")
     **/
    protected $password;

    /**
     * @var
     * @ORM\Column(type="string",nullable=true)
     */
    private $token;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Competence", mappedBy="missions")
     */
    private $competences;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Mission", mappedBy="user")
     */
    private $missions;



    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id): void
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getNom()
    {
        return $this->nom;
    }

    /**
     * @param mixed $nom
     */
    public function setNom($nom): void
    {
        $this->nom = $nom;
    }

    /**
     * @return mixed
     */
    public function getPrenom()
    {
        return $this->prenom;
    }

    /**
     * @param mixed $prenom
     */
    public function setPrenom($prenom): void
    {
        $this->prenom = $prenom;
    }

    /**
     * @return mixed
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param mixed $email
     */
    public function setEmail($email): void
    {
        $this->email = $email;
    }

    /**
     * @return mixed
     */
    public function getToken()
    {
        return $this->token;
    }

    /**
     * @param mixed $token
     */
    public function setToken($token): void
    {
        $this->token = $token;
    }

    /**
     * @return mixed
     */
    public function getCompetences()
    {
        return $this->competences;
    }

    /**
     * @param mixed $competences
     */
    public function setCompetences($competences): void
    {
        $this->competences = $competences;
    }

    /**
     * @return mixed
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @param mixed $password
     */
    public function setPassword($password): void
    {
        $this->password = $password;
    }

    /**
     * @return mixed
     */
    public function getDateConfirmation()
    {
        return $this->dateConfirmation;
    }

    /**
     * @param mixed $dateConfirmation
     */
    public function setDateConfirmation($dateConfirmation): void
    {
        $this->dateConfirmation = $dateConfirmation;
    }

    /**
     * @return mixed
     */
    public function getDateCreation()
    {
        return $this->dateCreation;
    }

    /**
     * @param mixed $dateCreation
     */
    public function setDateCreation($dateCreation): void
    {
        $this->dateCreation = $dateCreation;
    }

    /**
     * @return mixed
     */
    public function getEstActif()
    {
        return $this->estActif;
    }

    /**
     * @param mixed $estActif
     */
    public function setEstActif($estActif): void
    {
        $this->estActif = $estActif;
    }

    /**
     * @return mixed
     */
    public function getMissions()
    {
        return $this->missions;
    }

    /**
     * @param mixed $missions
     */
    public function setMissions($missions): void
    {
        $this->missions = $missions;
    }


}
