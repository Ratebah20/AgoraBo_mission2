<!-- page start-->
<div class="col-sm-6">
	<section class="panel">
		<div class="chat-room-head">
			<h3><i class="fa fa-angle-right"></i> Gérer les Jeux</h3>
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
			<!-- formulaire pour ajouter un nouveau Jeux-->
			<tr>
			<form action="index.php?uc=gererJeux=affichierJeux" method="post">
				<td>Nouveau</td>
				<td>
					<input type="text" id="txtLibJeux" name="txtLibJeux" size="24" required minlength="4"  maxlength="24"  placeholder="Libellé" title="De 4 à 24 caractères"  />
				</td>
				<td> 
					<button class="btn btn-primary btn-xs" type="submit" name="cmdAction" value="ajouterNouveauJeux" title="Enregistrer nouveau Jeux"><i class="fa fa-save"></i></button>
					<button class="btn btn-info btn-xs" type="reset" title="Effacer la saisie"><i class="fa fa-eraser"></i></button>	
				</td>
			</form>
			</tr>
				
			<?php
			foreach ($tbJeux as $Jeux) { 
			?>
			  <tr>
			  
				<!-- formulaire pour modifier et supprimer les Jeuxs-->
				<form action="index.php?uc=gererJeux&action=afficherJeux" method="post">
				<td><?php echo $Jeux->identifiant; ?><input type="hidden"  name="txtIdJeux" value="<?php echo $Jeux->identifiant; ?>" /></td>
				<td><?php 
					if ($Jeux->identifiant != $idJeuxModif) {
						echo $Jeux->libelle;
						?>
						</td><td>
							<?php if ($notification != 'rien' && $Jeux->identifiant == $idJeuxNotif) {  
								echo '<button class="btn btn-success btn-xs"><i class="fa fa-check"></i>' . $notification . '</button>'; 
							
							} ?>
							<button class="btn btn-primary btn-xs" type="submit" name="cmdAction" value="demanderModifierJeux" title="Modifier"><i class="fa fa-pencil"></i></button>
							<button class="btn btn-danger btn-xs" type="submit" name="cmdAction" value="supprimerJeux" title="Supprimer" onclick="return confirm('Voulez-vous vraiment supprimer ce Jeux?');"><i class="fa fa-trash-o "></i></button>
						</td>
					<?php
					}
					else {
						?><input type="text" id="txtLibJeux" name="txtLibJeux" size="24" required minlength="4"  maxlength="24"   value="<?php echo $Jeux->libelle; ?>" />     
						</td>
						<td>		 
							<button class="btn btn-primary btn-xs" type="submit" name="cmdAction" value="validerModifierJeux" title="Enregistrer"><i class="fa fa-save"></i></button>
							<button class="btn btn-info btn-xs" type="reset" title="Effacer la saisie"><i class="fa fa-eraser"></i></button>				
							<button class="btn btn-warning btn-xs" type="submit" name="cmdAction" value="annulerModifierJeux" title="Annuler"><i class="fa fa-undo"></i></button>
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
    </section><!-- fin section Jeuxs-->
</div><!--fin div col-sm-6-->

