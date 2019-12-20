<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * joueurs
 *
 * @ORM\Table(name="joueurs")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\joueursRepository")
 */
class joueurs implements UserInterface
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
     * @ORM\Column(name="nom", type="string", length=15)
     */
    private $nom;

    /**
     * @var string
     *
     * @ORM\Column(name="prenom", type="string", length=15)
     */
    private $prenom;

    /**
     * @var string
     *
     * @ORM\Column(name="mail", type="string", length=255)
     */
    private $mail;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="birthday", type="datetime")
     */
    private $birthday;

    /**
     * @var string
     *
     * @ORM\Column(name="password", type="string", length=255)
     */
    private $password;

    /**
     * @var int
     *
     * @ORM\Column(name="nb_personnage", type="integer")
     */
    private $nb_personnage;

    /**
     * @var string
     *
     * @ORM\Column(name="avatar", type="string", length=255)
     */
    private $avatar;


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
     * @return joueurs
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
     * Set prenom
     *
     * @param string $prenom
     *
     * @return joueurs
     */
    public function setPrenom($prenom)
    {
        $this->prenom = $prenom;

        return $this;
    }

    /**
     * Get prenom
     *
     * @return string
     */
    public function getPrenom()
    {
        return $this->prenom;
    }

    /**
     * Set mail
     *
     * @param string $mail
     *
     * @return joueurs
     */
    public function setMail($mail)
    {
        $this->mail = $mail;

        return $this;
    }

    /**
     * Get mail
     *
     * @return string
     */
    public function getMail()
    {
        return $this->mail;
    }

    /**
     * Set birthday
     *
     * @param \DateTime $birthday
     *
     * @return joueurs
     */
    public function setBirthday($birthday)
    {
        $this->birthday = $birthday;

        return $this;
    }

    /**
     * Get birthday
     *
     * @return \DateTime
     */
    public function getBirthday()
    {
        return $this->birthday;
    }

    /**
     * Set password
     *
     * @param string $password
     *
     * @return joueurs
     */
    public function setPassword($password)
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Get password
     *
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Set nbPersonnage
     *
     * @param integer $nb_personnage
     *
     * @return joueurs
     */
    public function setNb_personnage($nb_personnage)
    {
        $this->nb_personnage = $nb_personnage;

        return $this;
    }

    /**
     * Get nbPersonnage
     *
     * @return int
     */
    public function getNb_personnage()
    {
        return $this->nb_personnage;
    }

    /**
     * Set avatar
     *
     * @param string $avatar
     *
     * @return joueurs
     */
    public function setAvatar($avatar)
    {
        $this->avatar = $avatar;

        return $this;
    }

    /**
     * Get avatar
     *
     * @return string
     */
    public function getAvatar()
    {
        return $this->avatar;
    }
    
    public function getRoles()
    {
        return array('ROLE_USER');
    }
    
    public function getSalt()
    {
        return null;
    }
    
    public function getUsername()
    {
        return $this->mail;
    }
    
    public function eraseCredentials()
    {
    }
    
    public function getUser()
    {
        return $this;
    }
    
    private $file;

    public function getFile()
    {
        return $this->file;
    }

    public function setFile(UploadedFile $file=null)
    {
        $this->file=$file;
    }   

    public function upload()
    {
        $file = $this->getFile();
        $fileName = md5(uniqid()).'.'.$file->guessExtension();
        $this->file->move('img_user/' ,$fileName);
        $this->avatar=$fileName;
    }
}

