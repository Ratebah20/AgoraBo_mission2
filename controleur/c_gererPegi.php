<?php
	// si le paramètre action n'est pas positionné alors
	//		si aucun bouton "action" n'a été envoyé alors par défaut on affiche les pegis
	//		sinon l'action est celle indiquée par le bouton

	if (!isset($_POST['cmdAction'])) {
		 $action = 'afficherPegis';
	}
	else {
		// par défaut
		$action = $_POST['cmdAction'];
	}

	$idPegiModif = -1;		// positionné si demande de modification
	$notification = 'rien';	// pour notifier la mise à jour dans la vue

	// selon l'action demandée on réalise l'action 
	switch($action) {

		case 'ajouterNouveauPegi': {		
			if (!empty($_POST['txtLibPegi'])) {
				$idPegiNotif = $db->ajouterPegi($_POST['txtLibPegi'], $_POST['txtAgePegi']);
				// $idPegiNotif est l'idPegi de la pegi ajouté
				$notification = 'Ajouté';	// sert à afficher l'ajout réalisé dans la vue
			}
		  break;
		}

		case 'demanderModifierPegi': {
				$idPegiModif = $_POST['txtIdPegi']; // sert à créer un formulaire de modification pour cette pegi
			break;
		}
			
		case 'validerModifierPegi': {
			$db->modifierPegi($_POST['txtIdPegi'], $_POST['txtLibPegi'], $_POST['txtAgePegi']); 
			$idPegiNotif = $_POST['txtIdPegi']; // $idPegiNotif est l'idPegi de la pegi modifiée
			$notification = 'Modifié';  // sert à afficher la modification réalisée dans la vue
			break;
		}

		case 'supprimerPegi': {
			$idPegi = $_POST['txtIdPegi'];
			//  à compléter, voir quelle méthode appeler dans le modèle
			$db-> supprimerPegi($_POST['txtIdPegi']);
			//  à compléter, voir quelle méthode appeler dans le modèle
			break;
		}
	}
		
	// l' affichage des pegis se fait dans tous les cas	
	$tbPegis  = $db->getLesPegi();		
	require 'vue/v_lesPegi.php';

	?>
