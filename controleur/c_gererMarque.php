<?php
	// si le paramètre action n'est pas positionné alors
	//		si aucun bouton "action" n'a été envoyé alors par défaut on affiche les marques
	//		sinon l'action est celle indiquée par le bouton

	if (!isset($_POST['cmdAction'])) {
		 $action = 'afficherMarques';
	}
	else {
		// par défaut
		$action = $_POST['cmdAction'];
	}

	$idMarqueModif = -1;		// positionné si demande de modification
	$notification = 'rien';	// pour notifier la mise à jour dans la vue

	// selon l'action demandée on réalise l'action 
	switch($action) {

		case 'ajouterNouveauMarque': {		
			if (!empty($_POST['txtLibMarque'])) {
				$idMarqueNotif = $db->ajouterMarque($_POST['txtLibMarque']);
				// $idMarqueNotif est l'idMarque de la marque ajouté
				$notification = 'Ajouté';	// sert à afficher l'ajout réalisé dans la vue
			}
		  break;
		}

		case 'demanderModifierMarque': {
				$idMarqueModif = $_POST['txtIdMarque']; // sert à créer un formulaire de modification pour cette marque
			break;
		}
			
		case 'validerModifierMarque': {
			$db->modifierMarque($_POST['txtIdMarque'], $_POST['txtLibMarque']); 
			$idMarqueNotif = $_POST['txtIdMarque']; // $idMarqueNotif est l'idMarque de la marque modifiée
			$notification = 'Modifié';  // sert à afficher la modification réalisée dans la vue
			break;
		}

		case 'supprimerMarque': {
			$idMarque = $_POST['txtIdMarque'];
			//  à compléter, voir quelle méthode appeler dans le modèle
			$db-> supprimerMarque($_POST['txtIdMarque']);
			//  à compléter, voir quelle méthode appeler dans le modèle
			break;
		}
	}
		
	// l' affichage des marques se fait dans tous les cas	
	$tbMarques  = $db->getLesMarque();		
	require 'vue/v_lesMarque.php';

	?>
