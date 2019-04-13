<?php
	include_once ("header-php.php");
	require "header.php";
	if(isset($_GET['edit'])){
		$profilEdited = intval($_GET['edit']);
	}
	if(isset($_SESSION['user'])){
		$userData = $shareHandler->getUserFromID($_SESSION['user']['id']);
		if ($userData === false) {
			echo "<script type='text/javascript'>document.location.href='index.php';</script>";
		}
	}else{
		echo "<script type='text/javascript'>document.location.href='index.php';</script>";
	}
?>
	<div class="row-inline">
		<?php
			if(isset($profilEdited)){
				if($profilEdited === 1){
					echo "<div class='alert alert-success' role='alert'>
						Profil modifié !
					</div>";
				}elseif ($profilEdited === 0 || $profilEdited === 2) {

					echo "<div class='alert alert-danger' role='alert'>
						Mot de passe incorrect.
					</div>";
				}
			}

		?>
		<div class="col-80 round-border lessmarg">
			<form class="form-menu" action="php/handle.php" method="POST">
				<input type="hidden" name="modif-profil" value="1">
				<div class="form-row">
					<div class="cont">
						<img src="<?=$userData['picture']?>" class="img-circle image w-128">
						<div class="middle">
							<img src="image/plus.png" class="img-circle cursorhover w-128" data-toggle="modal" data-target="#updatePicModal">
						</div>
					</div>
					<span class="textProfil"><?=$userData['name']?></span>
				</div>
				<div>
					<h5 class="profil-attr mr-t-8"><b>Mot de passe: </b></h5>
					<div class="input-group w-6 min-w-430">
						<input type="password" class="form-control color-black <?=((isset($profilEdited) && ($profilEdited === 0))?'is_invalid':'')?>" name="pwd-profil" placeholder="Entrez votre mot de passe pour modifier votre profil." required>
					</div>

					<h5 class="profil-attr mr-t-50"><b>Email: </b></h5>
					<div class="input-group w-6 min-w-430">
						<input type="email" class="form-control color-black" name="email-profil" value="<?=$userData['email']?>" placeholder="Votre email">
					</div>

					<h5 class="profil-attr mr-t-8"><b>Localisation: </b></h5>
					<div class="form-row no-mr-l mr-t-8 w-6 min-w-430">
						<select class="form-control w-9 nofloat color-black" id="country" name="country" onchange="document.getElementById('flag-country').src='https://www.countryflags.io/'+ document.getElementById('country').value + '/shiny/64.png';">
							<?php
								$countries = $shareHandler->getCountries();
								foreach ($countries as $key) {
									echo "<option value='".$key["idCountry"]."' ". (($userData['idCountry'] === $key["idCountry"])?"selected":"") .">".$key["name"]."</option>";
								}
							?>
						</select>
						<img id="flag-country" class="mr-l-8" src="https://www.countryflags.io/<?=$userData['idCountry']?>/shiny/64.png" width="32" height="32">
					</div>

					<h5 class="profil-attr mr-t-8"><b>Description: </b></h5>
					<div class="no-mr-l mr-t-8 w-6 min-w-430">
						<textarea name="bio-profil" class="desc-text color-black"><?=(($userData["bio"] !== "")?$userData["bio"]:"")?></textarea>
					</div>

					<button class='btn btn-primary btn-lg' type="submit" href='modifierProfil.php'>Modifier profil</button>
				</div>
			</form>
			<button class='btn btn-primary btn-lg f-r mr-t-8'  data-toggle="modal" data-target="#editPwd">Changer mot de passe</button>
		</div>
		<?php require "footer.php" ?>
	</div>
</body>
</html>
