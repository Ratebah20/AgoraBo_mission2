	<?php
	// si le paramètre action n'est pas positionné alors
	//		si aucun bouton "action" n'a été envoyé alors par défaut on affiche les genres
	//		sinon l'action est celle indiquée par le bouton

	if (!isset($_POST['cmdAction'])) {
		 $action = 'afficherGenres';
	}
	else {
		// par défaut
		$action = $_POST['cmdAction'];
	}

	$idGenreModif = -1;		// positionné si demande de modification
	$notification = 'rien';	// pour notifier la mise à jour dans la vue

	// selon l'action demandée on réalise l'action 
	switch($action) {

		case 'ajouterNouveauGenre': {		
			if (!empty($_POST['txtLibGenre'])) {
				$idGenreNotif = $db->ajouterGenre($_POST['txtLibGenre']);
				// $idGenreNotif est l'idGenre du genre ajouté
				$notification = 'Ajouté';	// sert à afficher l'ajout réalisé dans la vue
			}
		  break;
		}

		case 'demanderModifierGenre': {
				$idGenreModif = $_POST['txtIdGenre']; // sert à créer un formulaire de modification pour ce genre
			break;
		}
			
		case 'validerModifierGenre': {
			$db->modifierGenre($_POST['txtIdGenre'], $_POST['txtLibGenre']); 
			$idGenreNotif = $_POST['txtIdGenre']; // $idGenreNotif est l'idGenre du genre modifié
			$notification = 'Modifié';  // sert à afficher la modification réalisée dans la vue
			break;
		}

		case 'supprimerGenre': {
			$idGenre = $_POST['txtIdGenre'];
			$db->supprimerGenre($_POST['txtIdGenre']);
			break;
		}
	}
		
	// l' affichage des genres se fait dans tous les cas	
	$tbGenres  = $db->getLesGenres();		
	require 'vue/v_lesGenres.php';

	?>
