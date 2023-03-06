<?php

if (!isset($_POST['cmdAction'])){
    $action = 'demanderConnexion';
   }
   else {
    // par défaut
    $action = $_POST['cmdAction'];
   }
   switch ($action) {
    case 'demanderConnexion': {
    require_once 'app/_config.inc.php';
    require_once 'modele/class.PdoJeux.inc.php';
    require_once 'vue/v_connexion.php';
    break;
    }
   
    case 'validerConnexion': {
    // vérifier si l'utilisateur existe avec ce mot de passe
    require_once 'app/_config.inc.php';
    require_once 'modele/class.PdoJeux.inc.php';
    $membre = PdoJeux::getPdoJeux();
    $loginMembre = isset($_POST['txtLogin']) ? $_POST['txtLogin'] : null;
    $mdpMembre = isset($_POST['hdMdp']) ? $_POST['hdMdp'] : null;
    $utilisateur = $membre->getUnMembre($loginMembre, $mdpMembre);

    
    // si l'utilisateur n'existe pas
    if (!$utilisateur) {
       // positionner le message d'erreur $erreur
       $erreur = 'Identifiant ou mot de passe incorrect';
    
       // inclure la vue correspondant au formulaire d'authentification
       require_once 'vue/v_connexion.php';
    } else {
    // créer trois variables de session pour id utilisateur, nom et prénom
    $_SESSION['idUtilisateur'] = $utilisateur->idMembre;
    $_SESSION['nomUtilisateur'] = $utilisateur->nomMembre;
    $_SESSION['prenomUtilisateur'] = $utilisateur->prenomMembre;
   
    // redirection du navigateur vers la page d'accueil
    header('Location: index.php');
    exit;
    }
    break;
    }
   }
   