<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * boite_mail
 *
 * @ORM\Table(name="boite_mail")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\boite_mailRepository")
 */
class boite_mail
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
     * @var int
     *
     * @ORM\Column(name="id_expediteur", type="integer")
     */
    private $idExpediteur;

    /**
     * @var int
     *
     * @ORM\Column(name="id_destinataire", type="integer")
     */
    private $idDestinataire;

    /**
     * @var string
     *
     * @ORM\Column(name="pseudo_destinataire", type="string", length=15)
     */
    private $pseudoDestinataire;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_message", type="datetime")
     */
    private $dateMessage;

    /**
     * @var bool
     *
     * @ORM\Column(name="lu", type="boolean")
     */
    private $lu;

    /**
     * @var string
     *
     * @ORM\Column(name="objet", type="string", length=125)
     */
    private $objet;

    /**
     * @var string
     *
     * @ORM\Column(name="message", type="string", length=255)
     */
    private $message;


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
     * Set idExpediteur
     *
     * @param integer $idExpediteur
     *
     * @return boite_mail
     */
    public function setIdExpediteur($idExpediteur)
    {
        $this->idExpediteur = $idExpediteur;

        return $this;
    }

    /**
     * Get idExpediteur
     *
     * @return int
     */
    public function getIdExpediteur()
    {
        return $this->idExpediteur;
    }

    /**
     * Set idDestinataire
     *
     * @param integer $idDestinataire
     *
     * @return boite_mail
     */
    public function setIdDestinataire($idDestinataire)
    {
        $this->idDestinataire = $idDestinataire;

        return $this;
    }

    /**
     * Get idDestinataire
     *
     * @return int
     */
    public function getIdDestinataire()
    {
        return $this->idDestinataire;
    }

    /**
     * Set pseudoDestinataire
     *
     * @param string $pseudoDestinataire
     *
     * @return boite_mail
     */
    public function setPseudoDestinataire($pseudoDestinataire)
    {
        $this->pseudoDestinataire = $pseudoDestinataire;

        return $this;
    }

    /**
     * Get pseudoDestinataire
     *
     * @return string
     */
    public function getPseudoDestinataire()
    {
        return $this->pseudoDestinataire;
    }

    /**
     * Set dateMessage
     *
     * @param \DateTime $dateMessage
     *
     * @return boite_mail
     */
    public function setDateMessage($dateMessage)
    {
        $this->dateMessage = $dateMessage;

        return $this;
    }

    /**
     * Get dateMessage
     *
     * @return \DateTime
     */
    public function getDateMessage()
    {
        return $this->dateMessage;
    }

    /**
     * Set lu
     *
     * @param boolean $lu
     *
     * @return boite_mail
     */
    public function setLu($lu)
    {
        $this->lu = $lu;

        return $this;
    }

    /**
     * Get lu
     *
     * @return bool
     */
    public function getLu()
    {
        return $this->lu;
    }

    /**
     * Set objet
     *
     * @param string $objet
     *
     * @return boite_mail
     */
    public function setObjet($objet)
    {
        $this->objet = $objet;

        return $this;
    }

    /**
     * Get objet
     *
     * @return string
     */
    public function getObjet()
    {
        return $this->objet;
    }

    /**
     * Set message
     *
     * @param string $message
     *
     * @return boite_mail
     */
    public function setMessage($message)
    {
        $this->message = $message;

        return $this;
    }

    /**
     * Get message
     *
     * @return string
     */
    public function getMessage()
    {
        return $this->message;
    }
}

