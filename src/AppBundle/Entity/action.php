<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * action
 *
 * @ORM\Table(name="action")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\actionRepository")
 */
class action
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
     * @ORM\Column(name="nom", type="string", length=255)
     */
    private $nom;

    /**
     * @var int
     *
     * @ORM\Column(name="win_gold", type="integer")
     */
    private $win_Gold;

    /**
     * @var int
     *
     * @ORM\Column(name="win_vie", type="integer")
     */
    private $win_Vie;

    /**
     * @var int
     *
     * @ORM\Column(name="win_attaque", type="integer")
     */
    private $win_Attaque;

    /**
     * @var int
     *
     * @ORM\Column(name="win_defense", type="integer")
     */
    private $win_Defense;

    /**
     * @var int
     *
     * @ORM\Column(name="win_mana", type="integer")
     */
    private $win_Mana;

    /**
     * @var int
     *
     * @ORM\Column(name="win_score", type="integer")
     */
    private $win_Score;

    /**
     * @var int
     *
     * @ORM\Column(name="vie_monstre", type="integer")
     */
    private $vie_Monstre;

    /**
     * @var int
     *
     * @ORM\Column(name="attaque_monstre", type="integer")
     */
    private $attaque_Monstre;

    /**
     * @var string
     *
     * @ORM\Column(name="type", type="string", length=15)
     */
    private $type;


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
     * Set nom
     *
     * @param string $nom
     *
     * @return action
     */
    public function setNom($nom)
    {
        $this->nom = $nom;

        return $this;
    }

    /**
     * Get nom
     *
     * @return string
     */
    public function getNom()
    {
        return $this->nom;
    }

    /**
     * Set win_Gold
     *
     * @param integer $win_Gold
     *
     * @return action
     */
    public function setWin_Gold($win_Gold)
    {
        $this->win_Gold = $win_Gold;

        return $this;
    }

    /**
     * Get win_Gold
     *
     * @return int
     */
    public function getWin_Gold()
    {
        return $this->win_Gold;
    }

    /**
     * Set win_Vie
     *
     * @param integer $win_Vie
     *
     * @return action
     */
    public function setWin_Vie($win_Vie)
    {
        $this->win_Vie = $win_Vie;

        return $this;
    }

    /**
     * Get win_Vie
     *
     * @return int
     */
    public function getWin_Vie()
    {
        return $this->win_Vie;
    }

    /**
     * Set win_Attaque
     *
     * @param integer $win_Attaque
     *
     * @return action
     */
    public function setWin_Attaque($win_Attaque)
    {
        $this->win_Attaque = $win_Attaque;

        return $this;
    }

    /**
     * Get win_Attaque
     *
     * @return int
     */
    public function getWin_Attaque()
    {
        return $this->win_Attaque;
    }

    /**
     * Set win_Defense
     *
     * @param integer $win_Defense
     *
     * @return action
     */
    public function setWin_Defense($win_Defense)
    {
        $this->win_Defense = $win_Defense;

        return $this;
    }

    /**
     * Get win_Defense
     *
     * @return int
     */
    public function getWin_Defense()
    {
        return $this->win_Defense;
    }

    /**
     * Set win_Mana
     *
     * @param integer $win_Mana
     *
     * @return action
     */
    public function setWin_Mana($win_Mana)
    {
        $this->win_Mana = $win_Mana;

        return $this;
    }

    /**
     * Get win_Mana
     *
     * @return int
     */
    public function getWin_Mana()
    {
        return $this->win_Mana;
    }

    /**
     * Set win_Score
     *
     * @param integer $win_Score
     *
     * @return action
     */
    public function setWin_Score($win_Score)
    {
        $this->win_Score = $win_Score;

        return $this;
    }

    /**
     * Get win_Score
     *
     * @return int
     */
    public function getWin_Score()
    {
        return $this->win_Score;
    }

    /**
     * Set vie_Monstre
     *
     * @param integer $vie_Monstre
     *
     * @return action
     */
    public function setVie_Monstre($vie_Monstre)
    {
        $this->vie_Monstre = $vie_Monstre;

        return $this;
    }

    /**
     * Get vie_Monstre
     *
     * @return int
     */
    public function getVie_Monstre()
    {
        return $this->vie_Monstre;
    }

    /**
     * Set attaque_Monstre
     *
     * @param integer $attaque_Monstre
     *
     * @return action
     */
    public function setAttaque_Monstre($attaque_Monstre)
    {
        $this->attaque_Monstre = $attaque_Monstre;

        return $this;
    }

    /**
     * Get attaque_Monstre
     *
     * @return int
     */
    public function getAttaque_Monstre()
    {
        return $this->attaque_Monstre;
    }

    /**
     * Set type
     *
     * @param string $type
     *
     * @return action
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type
     *
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }
}

