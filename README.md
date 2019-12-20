Deadly_Boss
===========

A Symfony project created on May 1, 2017, 4:49 pm.

						Descriptif du site Deadly Boss Mode
					Binôme 32: AOUESSAR Oussama, AREZES Mike

# I) Installation
	Pour installer le jeu, il suffit de faire les commandes suivantes:
	     - symfony new Deadly_Boss
	       	       Cette commande créer le projet Deadly_Boss
	     - Aller dans le répertoire Deadly_Boss créée
	     - Remplacer les dossier app, src et web par les fichiers dans le projet
	     - Créer un base de donnée et changer les informations dans parameters.yml en
	       	     	conséquence (nous l'avons de base nommé deadly_boss)
	     - Importer le fichier deadly_boss.sql pour générer et remplir la base de données que
	       		vous avez créée
	     - Lancez le serveur et aller à la page localhost:8000
	 Vous êtes à présent prêt pour jouer

# II) Explication rapide du fonctionnement du projet pages par pages
	      	- base.html.twig: C'est la page d'inclusion
		- index.html.twig: Permet de s'inscrire et de de se connecter via un formulaire et
		  		   d'uploader une image d'avatar, au moment de la connexion ou de
				   l'inscription, on créer une session
		- personnage.html.twig: Permet de créer un nouveau personnage et/ou de selectionner
		  		   et/ou de supprimer un prééxistant (on affiche aussi les informations relative
				   au joueur et à ces personnages)
		- action.html.twig: Il s'agit de la page principale qui permet de prendre des quêtes,
		  		    gagner ou perdre des ressources selon le résultat des combats (on peux
				    voir les coordonnées de la quête sur une map en survolant cette quête)
				    Si le menu dans la barre en haut deviens rouge, cela veut dire que l'on a
				    reçu un nouveau message
		- classement.html.twig: Permet de voir le classement des joueurs par score, de voir le
		  		    profil ou de leur envoyer un message
		- profil.html.twig: Permet de voir les infomations du personnage ainsi que celle du
		  		    joueur qui le controle (cette page est accessible depuis classement en
				    cliquant sur le pseudo d'un personnage)
		- envoi_message.html.twig: Permet d'envoyer un message à un personnage selectionné
		  		    depuis la page classement en cliquant sur l'icône de mail
		- boite_lettre.html.twig: Permet la consultation des messages reçu et leur suppression
		  	 	    (lorsqu'on lit un message, ce dernier est marqué comme lu)
		- DefaultController.php: Gère toutes les routes et les fonctions de notre site

# III) Explication principe du jeu
      		On choisi une race et on effectue des quêtes. Cela fait appel à une fonction de combat
		qui va déterminer un résultat selon les ressources du personnages et le niveau de la
		quête.
		Si le personnage gagne, ses ressources augmentent en fonction des récompenses de la
		quêtes.
		Si le personnage perd, ses ressources diminuent de la moitié des ressources qu'il aurait
		obtenu s'il avait gagné.
		Si une quête a été accomplie avec succès, une nouvelle quête avec un niveau un peu plus
		élevé est généré.
		Si notre score atteint 320, des quêtes "évènement" avec un niveau bien plus élevé que la
		moyenne apparaissent.
		Si le personnage est à court de "mana", il ne peu plus lancer de quêtes, il est obligé de
		dépenser de l'or dans l'achats de "mana" ou de défense.
		Petit plus, si le personnage est coincé, c'est à dire qu'il n'a ni "or" ni "mana", le serveur
		lui attribuera 20 pièces d'or.
		
