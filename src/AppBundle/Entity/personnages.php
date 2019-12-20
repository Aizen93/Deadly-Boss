<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * personnages
 *
 * @ORM\Table(name="personnages")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\personnagesRepository")
 */
class personnages
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
     * @ORM\Column(name="pseudo", type="string", length=15)
     */
    private $pseudo;

    /**
     * @var int
     *
     * @ORM\Column(name="joueur", type="integer")
     */
    private $joueur;

    /**
     * @var int
     *
     * @ORM\Column(name="gold", type="integer")
     */
    private $gold;

    /**
     * @var int
     *
     * @ORM\Column(name="vie", type="integer")
     */
    private $vie;

    /**
     * @var int
     *
     * @ORM\Column(name="attaque", type="integer")
     */
    private $attaque;

    /**
     * @var int
     *
     * @ORM\Column(name="defense", type="integer")
     */
    private $defense;

    /**
     * @var int
     *
     * @ORM\Column(name="mana", type="integer")
     */
    private $mana;

    /**
     * @var string
     *
     * @ORM\Column(name="classe", type="string", length=15)
     */
    private $classe;

    /**
     * @var int
     *
     * @ORM\Column(name="score", type="integer")
     */
    private $score;


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
     * Set pseudo
     *
     * @param string $pseudo
     *
     * @return personnages
     */
    public function setPseudo($pseudo)
    {
        $this->pseudo = $pseudo;

        return $this;
    }

    /**
     * Get pseudo
     *
     * @return string
     */
    public function getPseudo()
    {
        return $this->pseudo;
    }

    /**
     * Set joueur
     *
     * @param integer $joueur
     *
     * @return personnages
     */
    public function setJoueur($joueur)
    {
        $this->joueur = $joueur;

        return $this;
    }

    /**
     * Get joueur
     *
     * @return int
     */
    public function getJoueur()
    {
        return $this->joueur;
    }

    /**
     * Set gold
     *
     * @param integer $gold
     *
     * @return personnages
     */
    public function setGold($gold)
    {
        $this->gold = $gold;

        return $this;
    }

    /**
     * Get gold
     *
     * @return int
     */
    public function getGold()
    {
        return $this->gold;
    }

    /**
     * Set vie
     *
     * @param integer $vie
     *
     * @return personnages
     */
    public function setVie($vie)
    {
        $this->vie = $vie;

        return $this;
    }

    /**
     * Get vie
     *
     * @return int
     */
    public function getVie()
    {
        return $this->vie;
    }

    /**
     * Set attaque
     *
     * @param integer $attaque
     *
     * @return personnages
     */
    public function setAttaque($attaque)
    {
        $this->attaque = $attaque;

        return $this;
    }

    /**
     * Get attaque
     *
     * @return int
     */
    public function getAttaque()
    {
        return $this->attaque;
    }

    /**
     * Set defense
     *
     * @param integer $defense
     *
     * @return personnages
     */
    public function setDefense($defense)
    {
        $this->defense = $defense;

        return $this;
    }

    /**
     * Get defense
     *
     * @return int
     */
    public function getDefense()
    {
        return $this->defense;
    }

    /**
     * Set mana
     *
     * @param integer $mana
     *
     * @return personnages
     */
    public function setMana($mana)
    {
        $this->mana = $mana;

        return $this;
    }

    /**
     * Get mana
     *
     * @return int
     */
    public function getMana()
    {
        return $this->mana;
    }

    /**
     * Set classe
     *
     * @param string $classe
     *
     * @return personnages
     */
    public function setClasse($classe)
    {
        $this->classe = $classe;

        return $this;
    }

    /**
     * Get classe
     *
     * @return string
     */
    public function getClasse()
    {
        return $this->classe;
    }

    /**
     * Set score
     *
     * @param integer $score
     *
     * @return personnages
     */
    public function setScore($score)
    {
        $this->score = $score;

        return $this;
    }

    /**
     * Get score
     *
     * @return int
     */
    public function getScore()
    {
        return $this->score;
    }
}

