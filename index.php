<?php
/**
 * Page d'accueil de l'application AgoraBo

 * Point d'entrée unique de l'application
 * @author MD
 * @package default
 */
// démarrer la session 
session_start();
require 'vue/v_header.php';	// entête des pages HTML

// inclure les bibliothèques de fonctions
require_once 'app/_config.inc.php';
require_once 'modele/class.PdoJeux.inc.php';
	
// Connexion au serveur et à la base (A)
$db = PdoJeux::getPdoJeux();

// Si aucun utilisateur connecté, on considère que la page demandée est la page de
//connexion
// $_SESSION['idUtilisateur'] est crée lorsqu'un utilisateur autorisé se connecte (dans
//c_connexion.php)
if (!isset($_SESSION['idUtilisateur'])){
 require 'controleur/c_connexion.php';
} else {

	// Récupère l'identifiant de la page passé via l'URL
	// Si non défini, on considère que la page demandée est la page d'accueil
	if (!isset($_GET['uc'])){
    	$_GET['uc'] = 'index';
	}
	$uc = $_GET['uc'];

	// selon la valeur du use case demandé(uc) on inclut le contrôleur secondaire
	switch($uc){
		case 'index' : {
			$menuActif = '';
			require 'vue/v_menu.php';
        	require 'vue/v_accueil.php'; break;
		}
    	case 'gererGenres' : {
			$menuActif = 'Genre';	// pour garder le menu correspondant ouvert
			require 'vue/v_menu.php';
			require "controleur/c_gererGenres.php";
			break;
		}
		case 'gererPlateforme' : {
			$menuActif = 'Plateforme';
			require 'vue/v_menu.php';
			require "controleur/c_gererPlateforme.php";
			break;
		}
		case 'gererMarque' : {
			$menuActif = 'Marque';
			require 'vue/v_menu.php';
			require "controleur/c_gererMarque.php";
			break;
		}
		case 'gererPegi' : {
			$menuActif = 'Pegi';
			require 'vue/v_menu.php';
			require "controleur/c_gererPegi.php";
			break;
		}
		case 'gererJeux' : {
			$menuActif = 'Jeux';
			require 'vue/v_menu.php';
			require 'controleur/c_gererJeux.php';
		}
		case 'deconnexion' :
			{
			require 'controleur/c_deconnexion.php';
			break;
			}
	}
}
		   


// Fermeture de la connexion (C)
$db = null;	

// pied de page
require("vue/v_footer.html") ;	
?>

