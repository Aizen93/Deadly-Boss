<?php

namespace AppBundle\Controller;

use AppBundle\Entity\action;
use AppBundle\Entity\boite_mail;
use AppBundle\Entity\joueurs;
use AppBundle\Entity\personnages;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Security\Core\Encoder\PasswordEncoderInterface;

class DefaultController extends Controller
{
	/**
    * @Route("/inscription", name="createJoueur")
    */
    public function inscriptionAction (Request $request) {
		$form = $request->request->get('inscription');
		$nom = $request->request->get('nom');//est l'equivalent de $_Post['nom'] en Symfony
		$prenom = $request->request->get('prenom');
		$birthday = $request->request->get('dateN');
		$mail = $request->request->get('mail');
		$conf_mail = $request->request->get('mail2');
		$pwd = $request->request->get('pwd');
		$conf_pwd = $request->request->get('pwd2');
		$avatar = $request->files->get('avatar');
		//on verifie si on a bien soumis le formulaire
		if ((isset($form)) && ($form == 'inscription')) {
			//ici on verifie si on a bien remplie les champs mais comme tu peux le voir
			//la fontion VerifInscription on peut pas l'appeler ici dans le contolleur faut la mettre quelque part d'autre
			if ($this->verifInscription($nom,$prenom,$birthday,$mail,$conf_mail,$pwd,$conf_pwd)) {
				if($mail != $conf_mail){ 
					return $this->redirectToRoute('homepage', array('error2' => "Les mails sont différents"));
				}
				else{
					if($pwd != $conf_pwd){
						return $this->redirectToRoute('homepage', array('error2' => "Les mots de passe sont différents"));
					}
					else{
						//on teste si le mail n'existe pas dans notre BDD
						$repository = $this
						->getDoctrine()
						->getManager()
						->getRepository('AppBundle:joueurs');
						
						$test = $repository->findByMail($mail);
						if(null == $test){
							$joueur = new joueurs();
                            if($avatar != null) {
                                // Met l'image dans une variable fichier de joueur
                                $joueur->setFile($avatar);
                                $fileSize = $joueur->getFile()->getClientSize();
                                if($fileSize > 1000000 || $fileSize == null) {
                                    return $this->redirectToRoute('homepage', array('error2' => "Taille de l'image trop grande, veuillez mettre une image de 1Mo maximum"));
                                }
                                $extention = $joueur->getFile()->guessExtension();
                                if($extention != "jpg" && $extention != "png" 
                                    && $extention != "jpeg" && $extention != "gif") {
				                    return $this->redirectToRoute('homepage', array('error2' => "Mauvais format d'image, veuillez entrez une image dans un des formats suivants: .jpg .jpeg .png .gif"));
                                }
                                // donne un nouveau nom au fichier et met dans $avatar de joueur son nouveau nom
                                $joueur->upload();
                            } else {
                                $joueur->setAvatar('');
                            }
                            // fonction d'encodage du mot de passe
                            $encoder = $this->container->get('security.password_encoder');
                            $encoded = $encoder->encodePassword($joueur, $pwd);
                            
							//remplir la base de données
							$joueur->setNom($nom);
							$joueur->setPrenom($prenom);
							$joueur->setMail($mail);
							$joueur->setBirthday(new \DateTime($birthday));
							$joueur->setPassword($encoded);
							$joueur->setNb_personnage(0);
							
							$em = $this->getDoctrine()->getManager();
							$em->persist($joueur);
							$em->flush();
							//ici quand on est inscrit on fait une redirection vers la page personnage
							
						
							$bdd_mail = $repository->findByMail($mail);
							$id_joueur = $bdd_mail[0]->getId();
							$session = $this->get('session');
							$session->set('user', $mail);
							$session->set('id_joueur', $id_joueur);
							return $this->redirectToRoute('Perso');
						}
						else{
							return $this->redirectToRoute('homepage', array('error2' => "L'adresse mail existe déjà"));
						}
					}
				}
			}
			else{
				return $this->redirectToRoute('homepage', array('error2' => "Au moins un des champs est vide"));
			}
		}
		else {
			return $this->redirectToRoute('homepage', array('error2' => "Formulaire non remplie"));
		}
	}

	public function verifInscription ($nom, $prenom, $birthday, $mail, $conf_mail, $pwd, $conf_pwd) {
		
		if(!(isset($nom) && !empty($nom))){
			return false;
		}
		else if(!(isset($prenom) && !empty($prenom))){
			return false;
		}
		else if(!(isset($birthday) && !empty($birthday))){
			return false;
		}
		else if(!(isset($mail) && !empty($mail))){
			return false;
		}
		else if(!(isset($conf_mail) && !empty($conf_mail))){
			return false;
		}
		else if(!(isset($pwd) && !empty($pwd))){
			return false;
		}
		else if(!(isset($conf_pwd) && !empty($conf_pwd))){
			return false;
		}
		return true;
	}
    
    /**
     * @Route("/personnages", name="Perso")
     */
    public function viewPerso (Request $request) {
        $session = $this->get('session');
        $joueur = $session->get('id_joueur');
        
        if($session->has('id_message')) {
            $session->remove('id_message');
        }
        
        $j = $this->getDoctrine()
            ->getRepository('AppBundle:joueurs')
            ->findOneById($joueur);
        
        $avatar = $this->getDoctrine()
            ->getRepository('AppBundle:joueurs')
            ->findOneById($joueur);
        
        $perso = $this->getDoctrine()
            ->getRepository('AppBundle:personnages')
            ->findByJoueur($joueur);

        // créer le formulaire
        // $c : objet pour stocker le choix de l'utilisateur
        $c = (object) array('choix' => 0, 'pseudo' => '');

        $form = $this->createFormBuilder($c)
            ->add('choix', HiddenType::class)
            ->add('pseudo', TextType::class,array(
						'label_attr' => array('class' => 'cd-label'),
						'attr' => array('class' => 'user')
						))
            ->add('save', SubmitType::class, array('label' => 'Confirmer'))
            ->getForm();
      
        // tester si le formulaire est déjà rempli
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            
            $test = $this->getDoctrine()
            ->getRepository('AppBundle:personnages')
            ->findByPseudo($c->pseudo);
            
            $np = new personnages();
            // teste le type de personnage dont il s'agit et si le pseudo est unique
            if ($c->choix == 'race0' && $test == null) {                    
                $np->setPseudo($c->pseudo);
                $np->setJoueur($joueur);
                $np->setGold(10);
                $np->setVie(300);
                $np->setAttaque(100);
                $np->setDefense(50);
                $np->setMana(0);
                $np->setClasse('Humain');
                $np->setScore(0);
                
                // changer la table
                $em = $this->getDoctrine()->getManager();
                $em->persist($np);
                $em->flush();
                
                // incrémente le nombre de joueurs dans la table joueur
                $j->setNb_personnage(1+$j->getNb_personnage());
                // changer la table
                $em->persist($j);
                $em->flush();
                return $this->redirectToRoute('Perso', array('msg' => "Personnage ".$c->pseudo." crée avec succès"));
            } else if ($c->choix == 'race1' && $test == null) {
                $np->setPseudo($c->pseudo);
                $np->setJoueur($joueur);
                $np->setGold(10);
                $np->setVie(100);
                $np->setAttaque(300);
                $np->setDefense(0);
                $np->setMana(50);
                $np->setClasse('Elfe');
                $np->setScore(0);
                
                // changer la table
                $em = $this->getDoctrine()->getManager();
                $em->persist($np);
                $em->flush();
                
                // incrémente le nombre de joueurs dans la table joueur
                $j->setNb_personnage(1+$j->getNb_personnage());
                // changer la table
                $em->persist($j);
                $em->flush();
                return $this->redirectToRoute('Perso', array('msg' => "Personnage ".$c->pseudo." crée avec succès"));
            } else if ($c->choix == 'race2' && $test == null) {
                $np->setPseudo($c->pseudo);
                $np->setJoueur($joueur);
                $np->setGold(10);
                $np->setVie(200);
                $np->setAttaque(200);
                $np->setDefense(50);
                $np->setMana(0);
                $np->setClasse('Orc');
                $np->setScore(0);
                
                // changer la table
                $em = $this->getDoctrine()->getManager();
                $em->persist($np);
                $em->flush();
                
                // incrémente le nombre de joueurs dans la table joueur
                $j->setNb_personnage(1+$j->getNb_personnage());
                // changer la table
                $em->persist($j);
                $em->flush();
                return $this->redirectToRoute('Perso', array('msg' => "Personnage ".$c->pseudo." crée avec succès"));
            } else if ($c->choix == 'race3' && $test == null) {
                $np->setPseudo($c->pseudo);
                $np->setJoueur($joueur);
                $np->setGold(10);
                $np->setVie(400);
                $np->setAttaque(50);
                $np->setDefense(100);
                $np->setMana(0);
                $np->setClasse('Dwarf');
                $np->setScore(0);
                
                // changer la table
                $em = $this->getDoctrine()->getManager();
                $em->persist($np);
                $em->flush();
                
                // incrémente le nombre de joueurs dans la table joueur
                $j->setNb_personnage(1+$j->getNb_personnage());
                // changer la table
                $em->persist($j);
                $em->flush();
                return $this->redirectToRoute('Perso', array('msg' => "Personnage ".$c->pseudo." crée avec succès"));
            }

            return $this->redirectToRoute('Perso', array('msg2' => "Pseudo déjà utilisé"));
        }

        return $this->render('personnage.html.twig', array('perso' => $perso, 'avatar' => $avatar, 'form' => $form->createView()));
    }
	
	/**
     * @Route("/connexion", name="connect")
     */
    public function connectAction(Request $request){
        $form = $request->request->get('connexion');
		$mail = $request->request->get('mail');//est l'equivalent de $_Post['nom'] en Symfony
		$pwd = $request->request->get('pwd');
		if (isset($form) && ($form == 'connexion') && isset($mail) && isset($pwd) && !empty($mail) && !empty($pwd)) {
			$repository = $this
				->getDoctrine()
				->getManager()
				->getRepository('AppBundle:joueurs');
						
			$bdd_mail = $repository->findByMail($mail);
            
            // fonctions qui verifie le mot de passe entré
            // récupère le type du crypteur du mot de passe, ici c'est bcrypt
            $encoder = $this->container->get('security.password_encoder');
            $user = $repository->findOneByMail($mail);
            // Ici, il récupère l'objet UserInterface de l'objet joueurs pour verifier le mot de passe
            // isPasswordValid() prend comme argument l'utilisateur et le mot de passe entré dans le formulaire
            // et il vérifie si le mot de passe du formulaire correspond au mot de passe, si c'est le cas, il renvoi 1
            // sinon il renvoi null (ceci est une fonction propre à PasswordEncoderInterface)
            $encoded = $encoder->isPasswordValid($user->getUser(), $pwd);
			//$bdd_pwd = $repository->findOneBy(array('mail' => $mail, 'password' => $encoded));
			/*$bdd_pwd = $repository->createQueryBuilder('p')
			->select('password')
			->from('joueurs')
			->where('mail = ?'.$mail.'');*/
			if(null == $bdd_mail){
				return $this->redirectToRoute('homepage', array('error' => "L'adresse mail n'existe pas"));
			}
			else{
				if(null == $encoded){
					return $this->redirectToRoute('homepage', array('error' => 'Mot de passe incorrect'));
				}
				else{
					$id_joueur = $bdd_mail[0]->getId();
					$session = $this->get('session');
					$session->set('user', $mail);
					$session->set('id_joueur', $id_joueur);
					return $this->redirectToRoute('Perso');
				}
			}
		}
		else{
			return $this->redirectToRoute('homepage', array('error' => 'Veuillez remplire les champs obligatoire'));
		}
    }
	
	/**
     * @Route("/action?id={id}", name="actionPage")
     */
    public function viewAction ($id, Request $request) {
        $perso = $this->getDoctrine()
            ->getRepository('AppBundle:personnages')
            ->findOneById($id);
			
		$quete = $this->getDoctrine()
            ->getRepository('AppBundle:action')
            ->findByType(array('global','améliorer'));
		
		$quete_epuise = $this->getDoctrine()
            ->getRepository('AppBundle:action')
            ->findByType('epuisé');
			
		$quete_even = $this->getDoctrine()
            ->getRepository('AppBundle:action')
            ->findByType('Hautlevel');
			
		$id_perso = $perso->getId();
		$session = $this->get('session');
		$session->set('id_perso', $id_perso);
        
        $session->set('nb_message', count($this->getDoctrine()->getRepository('AppBundle:boite_mail')
            ->findBy(array('idDestinataire' => $id_perso, 'lu' => false))));
        
        return $this->render('action.html.twig', array('perso' => $perso, 'quete' => $quete, 'quete2' => $quete_epuise, 'quete3' => $quete_even));
    }
    
	/**
     * @Route("/doAction?id={id}?id_quete={id_quete}", name="Quete")
     */
    public function doQueteAction($id, $id_quete, Request $request){
		$perso = $this->getDoctrine()
            ->getRepository('AppBundle:personnages')
            ->findOneById($id);
		
		$quete = $this->getDoctrine()
            ->getRepository('AppBundle:action')
            ->findOneById($id_quete);
			
		$vie_hero = $perso->getVie();
		$attq_hero = $perso->getAttaque();
		$def_hero = $perso->getDefense();
		$mana_hero = $perso->getMana();
		$gold = $perso->getGold();
		$score = $perso->getScore();
		$vie_monstre = $quete->getVie_monstre();
		$attq_monstre = $quete->getAttaque_monstre();
		//$type = $quete->getType();
		if(($mana_hero == 0) && ($quete->getType() != 'epuisé')){
			return $this->redirectToRoute('actionPage', array('id' => $perso->getId(), 'perso' => $perso, 'msg2' => 'Vous n\'avez pas assez de mana pour lancer la quête !'));
		}
		else{
			$res = $this->Combat_log($vie_hero, $attq_hero, $def_hero, $mana_hero, $vie_monstre, $attq_monstre );
		}
		if($res == 1){
			//le hero a gagné il va gagner la recompense (ressources)
			$perso->setVie($vie_hero + $quete->getWin_vie());
			$perso->setAttaque($attq_hero + $quete->getWin_attaque());
			$perso->setDefense($def_hero + $quete->getWin_defense());
			if(($mana_hero + $quete->getWin_Mana()) <=0 ){
				$perso->setMana(0);
			}
			else{
				$perso->setMana($mana_hero + $quete->getWin_Mana());
			}
			$perso->setScore($score + $quete->getWin_score());
			if(($gold + $quete->getWin_gold())< 0){
				return $this->redirectToRoute('actionPage', array('id' => $perso->getId(), 'perso' => $perso, 'msg2' => 'Vous n\'avez pas assez d\'or pour éffectuer la transaction'));
			}
			else{
				$perso->setGold($gold + $quete->getWin_gold());
			}
			
			$em = $this->getDoctrine()->getManager();
			$em->persist($perso);
			$em->flush();
			
			//supprime l'Action de la table
			$repository = $this
				->getDoctrine()
				->getManager();
			$em = $repository->getRepository('AppBundle:action')->findOneById($id_quete);
			//si le Type quete est different de global ou epuisé on crée une autre plus puissante
            if (($em->getType()) != 'epuisé') {
			     $nouv_quete = new action();
                 $nouv_nom = $em->getNom();
			     $lvl = 1;
				 //On renomme la quete avec un level plus elevé
			     for($i=5; $i>0; $i--){
				    $lvl = substr($nouv_nom, -$i);
				    if(is_numeric($lvl)){
			           $nouv_nom = rtrim($em->getNom(),$lvl);
					   $lvl += 1;
					   break;
				    }
			     }
			     $nouv_quete->setNom($nouv_nom.' '.$lvl);
			     $nouv_quete->setWin_gold(($em->getWin_gold()) + (($em->getWin_gold())/2));
			     $nouv_quete->setWin_vie(($em->getWin_vie()) + (($em->getWin_vie())/2));
			     $nouv_quete->setWin_attaque((($em->getWin_attaque()) + (($em->getWin_attaque())/2)));
			     $nouv_quete->setWin_defense(($em->getWin_defense()) + (($em->getWin_defense())/2));
			     $nouv_quete->setWin_mana(($em->getWin_mana()) + (($em->getWin_mana())/2));
			     $nouv_quete->setWin_score(($em->getWin_score()) + (($em->getWin_score())/2));
			     $nouv_quete->setVie_monstre(($em->getVie_monstre()) + (($em->getVie_monstre())/2));
			     $nouv_quete->setAttaque_monstre(($em->getAttaque_monstre()) + (($em->getAttaque_monstre())/2));
			     $nouv_quete->setType('améliorer');
			     $em2 = $this->getDoctrine()->getManager();
			     $em2->persist($nouv_quete);
			     $em2->flush();
            }
			if((($em->getType()) != "global") && (($em->getType()) != "epuisé")){
				//puis on supprime l'ancienne quete
				$repository->remove($em);
				$repository->flush();
			}
			if($quete->getType() == 'epuisé'){
				return $this->redirectToRoute('actionPage', array('id' => $perso->getId(), 'perso' => $perso, 'msg' => 'Transaction effectuée avec succès'));
			}
			else{
				return $this->redirectToRoute('actionPage', array('id' => $perso->getId(), 'perso' => $perso, 'msg' => 'Vous avez gagné'));
			}
		}
		if($res == 0){
			//le hero a perdu il va perdre de la defense et du mana
			if(($def_hero - (($quete->getWin_defense())/2)) <= 0){
				$perso->setDefense(0);
			}
			else{
				$perso->setDefense($def_hero - (($quete->getWin_defense())/2));
			}
			if(($mana_hero + (($quete->getWin_mana())/2)) <= 0){
				$perso->setMana(0);
			}
			else{
				$perso->setMana($mana_hero + (($quete->getWin_mana())/2));
			}
			$roi = '';
			if((($mana_hero + (($quete->getWin_mana())/2)) <= 0) && ($gold <= 10)){
				$perso->setGold($gold+20);
				$roi = 'Le Roi de Liones vous as fait dons de 20 pièce d\'or pour vos efforts';
			}
			$em = $this->getDoctrine()->getManager();
			$em->persist($perso);
			$em->flush();
			
			return $this->redirectToRoute('actionPage', array('id' => $perso->getId(), 'perso' => $perso, 'msg2' => 'Vous avez perdu', 'roi' => $roi));
		}
		else{
			return $this->redirectToRoute('actionPage', array('id' => $perso->getId(), 'perso' => $perso, 'msg2' => 'Problème de variable'));
		}
	}
	
	public function Combat_log($vie_hero, $attq_hero, $def_hero, $mana_hero, $vie_monstre, $attq_monstre ){
			//hero attaque le monstre
			$attq_hero = $attq_hero + $mana_hero;
			$vie_monstre = $vie_monstre - $attq_hero;
			if($vie_monstre <= 0){
				//le hero a tuer le monstre
				return 1;
			}
			//le monstre attaque le hero
			$attq_monstre = $attq_monstre - $def_hero;
			$vie_hero = $vie_hero - $attq_monstre;
			if($vie_hero <= 0){
				//le monstre a tuer le hero
				return 0;
			}
			return $this->Combat_log($vie_hero, $attq_hero, $def_hero, $mana_hero, $vie_monstre, $attq_monstre );
	}
    
	/**
     * @Route("/classement", name="classement")
     */
    public function viewClassement(Request $request) {
        $session = $this->get('session');
        $perso = $this->getDoctrine()
            ->getRepository('AppBundle:personnages')
            ->findOneById($session->get('id_perso'));
        
        $list_persos = $this->getDoctrine()
            ->getRepository('AppBundle:personnages')
            ->findBy(array(), array('score' => 'DESC'));
        
        $session->set('nb_message', count($this->getDoctrine()->getRepository('AppBundle:boite_mail')
            ->findBy(array('idDestinataire' => $session->get('id_perso'), 'lu' => false))));
        
        return $this->render('classement.html.twig', array('perso' => $perso, 'list_persos' => $list_persos));
    }
    
    /**
     * @Route("/redirect_profil?id={id}", name="redirectProfil")
     */
    public function redirectProfil($id, Request $request) {
        $session = $this->get('session');
        $session->set('id_profil', $id);
        
        return $this->redirectToRoute('profil');
    }
    
    /**
     * @Route("/profil", name="profil")
     */
    public function viewProfil(Request $request) {
        $session = $this->get('session');
        
        $perso = $this->getDoctrine()
            ->getRepository('AppBundle:personnages')
            ->findOneById($session->get('id_perso'));
        
        $profil = $this->getDoctrine()
            ->getRepository('AppBundle:personnages')
            ->findOneById($session->get('id_profil'));
        
        $joueur = $this->getDoctrine()
            ->getRepository('AppBundle:joueurs')
            ->findOneById($profil->getJoueur());
        
        $session->set('nb_message', count($this->getDoctrine()->getRepository('AppBundle:boite_mail')
            ->findBy(array('idDestinataire' => $session->get('id_perso'), 'lu' => false))));
        
        return $this->render('profil.html.twig', array('perso' => $perso, 'profil' => $profil, 'joueur' => $joueur));
    }
    
    /**
     * @Route("/sending?id={id}", name="sendingMessage")
     */
    public function redirectSendMessage($id, Request $request) {
        $session = $this->get('session');
        $session->set('id_destinataire', $id);
        
        $session->set('nb_message', count($this->getDoctrine()->getRepository('AppBundle:boite_mail')
            ->findBy(array('idDestinataire' => $session->get('id_perso'), 'lu' => false))));
        
        return $this->redirectToRoute('sendMessage');
    }
    
    /**
     * @Route("/envoi_message", name="sendMessage")
     */
    public function sendMessage(Request $request) {
        $session = $this->get('session');
        
        $session->set('nb_message', count($this->getDoctrine()->getRepository('AppBundle:boite_mail')
            ->findBy(array('idDestinataire' => $session->get('id_perso'), 'lu' => false))));
        
        if($session->has('id_destinataire') == false || $session->get('id_destinataire') == '') {
            return $this->redirectToRoute('classement', array('msg2' => "Veuillez choisir le personnage à qui vous voulez envoyer un message"));
        }
        $perso = $this->getDoctrine()
            ->getRepository('AppBundle:personnages')
            ->findOneById($session->get('id_perso'));
        $destinataire = $this->getDoctrine()
            ->getRepository('AppBundle:personnages')
            ->findOneById($session->get('id_destinataire'));
        
        // créer le formulaire
        // $c : objet pour stocker le choix de l'utilisateur
        $c = (object) array('objet' => '', 'message' => '');

        $form = $this->createFormBuilder($c)
            ->add('objet', TextType::class, array(
						'label_attr' => array('class' => 'cd-label'),
						'attr' => array('class' => 'user')
						))
            ->add('message', TextareaType::class)
            ->add('save', SubmitType::class, array('label' => 'Envoyer'))
            ->getForm();
      
        // tester si le formulaire est déjà rempli
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $bm = new boite_mail();
            
            $bm->setIdExpediteur($perso->getId());
            $bm->setIdDestinataire($destinataire->getId());
            $bm->setDateMessage(new \DateTime('now'));
            $bm->setPseudoDestinataire($destinataire->getPseudo());
            $bm->setLu(false);
            $bm->setObjet($c->objet);
            $bm->setMessage($c->message);
            
            // changer la table
            $em = $this->getDoctrine()->getManager();
            $em->persist($bm);
            $em->flush();
            $session->remove('id_destinataire');
            return $this->redirectToRoute('classement', array('msg' => "Message envoyé à ".$destinataire->getPseudo()." avec succès"));
        }
        return $this->render('envoi_message.html.twig', array('perso' => $perso, 'destinataire' => $destinataire, 'form' => $form->createView()));
    }
    
    /**
     * @Route("/boite_mail", name="boiteMail")
     */
    public function viewMail(Request $request) {
        $session = $this->get('session');
        
        $session->set('nb_message', count($this->getDoctrine()->getRepository('AppBundle:boite_mail')
            ->findBy(array('idDestinataire' => $session->get('id_perso'), 'lu' => false))));
        
        $perso = $this->getDoctrine()
            ->getRepository('AppBundle:personnages')
            ->findOneById($session->get('id_perso'));
        
        $liste_message = $this->getDoctrine()
            ->getRepository('AppBundle:boite_mail')
            ->findBy(array('idDestinataire' => $session->get('id_perso')), array('id' => 'DESC'));
        
        if ($session->has('id_message') == false || $session->get('id_message') == ''){
            return $this->render('boite_lettre.html.twig', array('perso' => $perso, 'liste_message' => $liste_message, 'message' => '', 'msg' => null));
        } else if ($session->get('id_message') == 'supprimé') {
            $session->remove('id_message');
            return $this->render('boite_lettre.html.twig', array('perso' => $perso, 'liste_message' => $liste_message, 'message' => '', 'msg' => 'Message supprimé avec succès'));
        }
        $message = $this->getDoctrine()
            ->getRepository('AppBundle:boite_mail')
            ->findOneById($session->get('id_message'));
        
        return $this->render('boite_lettre.html.twig', array('perso' => $perso, 'liste_message' => $liste_message, 'message' => $message, 'msg' => null));
    }
    
    /**
     * @Route("/lire_message?id={id}", name="lireMessage")
     */
    public function redirectLectMail($id, Request $request) {
        $session = $this->get('session');
        $session->set('id_message', $id);
        
        $repository = $this
			->getDoctrine()
			->getManager();
        
        $em = $repository->getRepository('AppBundle:boite_mail')->findOneById($id);
        $em->setLu(true);
        $repository->persist($em);
        $repository->flush();
        
        $session->set('nb_message', count($this->getDoctrine()->getRepository('AppBundle:boite_mail')
            ->findBy(array('idDestinataire' => $session->get('id_perso'), 'lu' => false))));
        
        return $this->redirectToRoute('boiteMail');
    }
    
    /**
     * @Route("/delete_message?id={id}", name="delMessage")
     */
    public function deleteMessage($id, Request $request) {
        // fonction qui supprime un message
        $session = $this->get('session');
        // on supprime la variable id_message de la session
        $session->set('id_message', 'supprimé');
        
        $repository = $this
			->getDoctrine()
			->getManager();
        
        // supprime le message de la table
		$em = $repository->getRepository('AppBundle:boite_mail')->findOneById($id);
		$repository->remove($em);
		$repository->flush();
        
        $session->set('nb_message', count($this->getDoctrine()->getRepository('AppBundle:boite_mail')
            ->findBy(array('idDestinataire' => $session->get('id_perso'), 'lu' => false))));
        
        return $this->redirectToRoute('boiteMail');
    }
    
	/**
     * @Route("/deconnexion", name="disconnect")
     */
    public function disconectAction(Request $request){
		$session = $this->get('session');
		$session->set('user', null);
		$session->set('id_joueur', null);
        return $this->redirectToRoute('homepage');
    }
	
	 /**
     * @Route("/supprimer?id={id}", name="delet")
     */
    public function deletAction($id, Request $request){
        $repository = $this
			->getDoctrine()
			->getManager();
        
        // supprime le personnage de la table
		$em = $repository->getRepository('AppBundle:personnages')->findOneById($id);
		$repository->remove($em);
		$repository->flush();
        
        $repository = $this
			->getDoctrine()
			->getManager();
        // recupère la table du joueur par la session
        $j = $repository->getRepository('AppBundle:joueurs')->findOneById($this->get('session')->get('id_joueur'));
        $j->setNb_personnage($j->getNb_personnage()-1);
        // décremente la variable du nombre de joueur dans la table joueurs
        $repository->persist($j);
        $repository->flush();
		return $this->redirectToRoute('Perso', array('msg' => 'Votre personnage a été supprimé avec succès'));
	}

    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request){
        // replace this example code with whatever you need
        return $this->render('default/index.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.root_dir').'/..').DIRECTORY_SEPARATOR,
        ]);
    }
}

