<?php
	// si le paramètre action n'est pas positionné alors
	//		si aucun bouton "action" n'a été envoyé alors par défaut on affiche les genres
	//		sinon l'action est celle indiquée par le bouton

	if (!isset($_POST['cmdAction'])) {
		 $action = 'afficherJeux';
	}
	else {
		// par défaut
		$action = $_POST['cmdAction'];
	}

	$idJeuxModif = -1;		// positionné si demande de modification
	$notification = 'rien';	// pour notifier la mise à jour dans la vue

	// selon l'action demandée on réalise l'action 
	switch($action) {

		case 'ajouterNouveauJeux': {		
			if (!empty($_POST['txtLibJeux'])) {
				$idJeuxNotif = $db->ajouterJeux($_POST['txtLibJeux']);
				// $idGenreNotif est l'idGenre du genre ajouté
				$notification = 'Ajouté';	// sert à afficher l'ajout réalisé dans la vue
			}
		  break;
		}

		case 'demanderModifierJeux': {
				$idJeuxModif = $_POST['txtIdJeux']; // sert à créer un formulaire de modification pour ce genre
			break;
		}
			
		case 'validerModifierJeux': {
			$db->modifierJeux($_POST['txtIdJeux'], $_POST['txtLibJeux']); 
			$idJeuxNotif = $_POST['txtIdJeux']; // $idGenreNotif est l'idGenre du genre modifié
			$notification = 'Modifié';  // sert à afficher la modification réalisée dans la vue
			break;
		}

		case 'supprimerJeux': {
			$idJeux = $_POST['txtIdJeux'];
			$db->supprimerJeux($_POST['txtIdJeux']);
			break;
		}
	}
		
	// l' affichage des genres se fait dans tous les cas	
	$tbJeux  = $db->getLesJeux();		
	require 'vue/v_lesJeux.php';

	?>
