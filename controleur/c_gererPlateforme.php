<?php
	// si le paramètre action n'est pas positionné alors
	//		si aucun bouton "action" n'a été envoyé alors par défaut on affiche les genres
	//		sinon l'action est celle indiquée par le bouton

	if (!isset($_POST['cmdAction'])) {
		 $action = 'afficherPlateforme';
	}
	else {
		// par défaut
		$action = $_POST['cmdAction'];
	}

	$idPlateformeModif = -1;		// positionné si demande de modification
	$notification = 'rien';	// pour notifier la mise à jour dans la vue

	// selon l'action demandée on réalise l'action 
	switch($action) {

		case 'ajouterNouveauPlateforme': {		
			if (!empty($_POST['txtLibPlateforme'])) {
				$idPlateformeNotif = $db->ajouterPlateforme($_POST['txtLibPlateforme']);
				// $idGenreNotif est l'idGenre du genre ajouté
				$notification = 'Ajouté';	// sert à afficher l'ajout réalisé dans la vue
			}
		  break;
		}

		case 'demanderModifierPlateforme': {
				$idPlateformeModif = $_POST['txtIdPlateforme']; // sert à créer un formulaire de modification pour ce genre
			break;
		}
			
		case 'validerModifierPlateforme': {
			$db->modifierPlateforme($_POST['txtIdPlateforme'], $_POST['txtLibPlateforme']); 
			$idPlateformeNotif = $_POST['txtIdPlateforme']; // $idGenreNotif est l'idGenre du genre modifié
			$notification = 'Modifié';  // sert à afficher la modification réalisée dans la vue
			break;
		}

		case 'supprimerPlateforme': {
			$idPlateforme = $_POST['txtIdPlateforme'];
			$db->supprimerPlateforme($_POST['txtIdPlateforme']);
			break;
		}
	}
		
	// l' affichage des genres se fait dans tous les cas	
	$tbPlateforme  = $db->getLesPlateforme();		
	require 'vue/v_lesPlateforme.php';

	?>
