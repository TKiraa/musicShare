<div class="col-17">
	<div class="item-footer round-border">
		<p class="pres">
			Les meilleurs partage de musique sur <b>MusicShare</b> pour vous, tir&eacute;s des plateformes de musique les plus actives sur <b>MusicShare</b>. Recherchez ici pour voir le contenu le plus partag&eacute;, le plus vot&eacute; et le plus comment&eacute; sur Internet.
		</p>
		<a class="createpost btncreate" href="create.php">Partager une musique</a>
	</div>
</div>


<div class="modal fade" id="updatePicModal" tabindex="-1" role="dialog" aria-labelledby="updatePicLabel" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<form id="uploadimage" method="POST" enctype="multipart/form-data" class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="updatePicLabel">Mettre à jour la photo de profil</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
				<div class="modal-body">
					<div class="col-35">
						<img src="<?=$_SESSION['user']['picture']?>" id="previewing" class="img-circle w-128">
					</div>
					<div class="col-60">
						<div class="custom-file mr-t-15">
							<input type="file" class="custom-file-input" name="file" required	id="customFile">
							<label class="custom-file-label" id="namefile" for="customFile">Choississez une image</label>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Fermer</button>
					<button type="submit" class="btn btn-primary">Sauvegarde</button>
				</div>
		</form>
	</div>
</div>

<div class="modal fade" id="editPwd" tabindex="-1" role="dialog" aria-labelledby="newPasswordModal" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<form method="POST" class="modal-content" action="php/handle.php">
			<input type="hidden" name="change-pwd">
			<div class="modal-header">
				<h5 class="modal-title">Mettre à jour votre mot de passe</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<div class="form-group">
					<label for="old-password">Ancien mot de passe</label>
					<input type="password" class="form-control" id="old-password" name="old-password" placeholder="Enter ancien mot de passe">
				</div>
				<hr>
				<div class="form-group">
					<label for="newpassword">Nouveau mot de passe</label>
					<input type="password" class="form-control" id="newpassword" name="newpassword" onchange="checkNewPwd();" placeholder="Nouveau mot de passe">
				</div>
				<div class="form-group">
					<label for="newpassword_confirm">Confirmer nouveau mot de passe</label>
					<input type="password" class="form-control" id="newpassword_confirm" name="newpassword_confirm" onchange="checkNewPwd();" placeholder="Confirmer nouveau mot de passe">
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Fermer</button>
					<button type="submit" class="btn btn-primary">Sauvegarde</button>
				</div>
			</div>
		</form>
	</div>
</div>
<script type="text/javascript">

	function checkNewPwd() {
		var new_pwd = document.getElementById("newpassword");
		var new_pwd_confirm = document.getElementById("newpassword_confirm");

		if(new_pwd.value == new_pwd_confirm.value){
			new_pwd.className = 'form-control is_valid';
			new_pwd_confirm.className = 'form-control is_valid';
		}else{
			new_pwd.className = 'form-control is_invalid';
			new_pwd_confirm.className = 'form-control is_invalid';
		}
	}
</script>


<?php
	if(isset($_POST["login"])){
		echo "<audio id='soundconnection' autoplay><source src='Audio/toctoctoc.mp3' hidden></audio>";
	}
?>
