<!-- page start-->
<div class="col-sm-6">
	<section class="panel">
		<div class="chat-room-head">
			<h3><i class="fa fa-angle-right"></i> Gérer les plateforme</h3>
		</div>
		<div class="panel-body">
			<table class="table table-striped table-advance table-hover">
			<thead>
			  <tr class="tableau-entete">
				<th><i class="fa fa-bullhorn"></i> Identifiant</th>
				<th><i class="fa fa-bookmark"></i> Libellé</th>
				<th></th>
			  </tr>
			</thead>
			<tbody>
			<!-- formulaire pour ajouter un nouveau Plateforme-->
			<tr>
			<form action="index.php?uc=gererPlateforme=affichierPlateforme" method="post">
				<td>Nouveau</td>
				<td>
					<input type="text" id="txtLibPlateforme" name="txtLibPlateforme" size="24" required minlength="4"  maxlength="24"  placeholder="Libellé" title="De 4 à 24 caractères"  />
				</td>
				<td> 
					<button class="btn btn-primary btn-xs" type="submit" name="cmdAction" value="ajouterNouveauPlateforme" title="Enregistrer nouveau Plateforme"><i class="fa fa-save"></i></button>
					<button class="btn btn-info btn-xs" type="reset" title="Effacer la saisie"><i class="fa fa-eraser"></i></button>	
				</td>
			</form>
			</tr>
				
			<?php
			foreach ($tbPlateforme as $Plateforme) { 
			?>
			  <tr>
			  
				<!-- formulaire pour modifier et supprimer les Plateformes-->
				<form action="index.php?uc=gererPlateforme&action=afficherPlateforme" method="post">
				<td><?php echo $Plateforme->identifiant; ?><input type="hidden"  name="txtIdPlateforme" value="<?php echo $Plateforme->identifiant; ?>" /></td>
				<td><?php 
					if ($Plateforme->identifiant != $idPlateformeModif) {
						echo $Plateforme->libelle;
						?>
						</td><td>
							<?php if ($notification != 'rien' && $Plateforme->identifiant == $idPlateformeNotif) {  
								echo '<button class="btn btn-success btn-xs"><i class="fa fa-check"></i>' . $notification . '</button>'; 
							
							} ?>
							<button class="btn btn-primary btn-xs" type="submit" name="cmdAction" value="demanderModifierPlateforme" title="Modifier"><i class="fa fa-pencil"></i></button>
							<button class="btn btn-danger btn-xs" type="submit" name="cmdAction" value="supprimerPlateforme" title="Supprimer" onclick="return confirm('Voulez-vous vraiment supprimer ce Plateforme?');"><i class="fa fa-trash-o "></i></button>
						</td>
					<?php
					}
					else {
						?><input type="text" id="txtLibPlateforme" name="txtLibPlateforme" size="24" required minlength="4"  maxlength="24"   value="<?php echo $Plateforme->libelle; ?>" />     
						</td>
						<td>		 
							<button class="btn btn-primary btn-xs" type="submit" name="cmdAction" value="validerModifierPlateforme" title="Enregistrer"><i class="fa fa-save"></i></button>
							<button class="btn btn-info btn-xs" type="reset" title="Effacer la saisie"><i class="fa fa-eraser"></i></button>				
							<button class="btn btn-warning btn-xs" type="submit" name="cmdAction" value="annulerModifierPlateforme" title="Annuler"><i class="fa fa-undo"></i></button>
						</td>				
					<?php
					}				
					?>
				</form>
				
			  </tr>  
			<?php
			}
			?>
			</tbody>
		  </table>
			  	  
		</div><!-- fin div panel-body-->
    </section><!-- fin section Plateformes-->
</div><!--fin div col-sm-6-->

