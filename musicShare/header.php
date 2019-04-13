<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="content-type" content="text/html; charset=utf-8" />
	<title>Music Share</title>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
	<script  src="js/jquery-3.3.1.min.js"  integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8="  crossorigin="anonymous"></script>
	<script src="js/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
	<script src="js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
	<script src="js/upload.js"></script>
	<script src="js/javascript.js"></script>
	<link rel="stylesheet" href="css/style.css">

</head>
<body>
	<div id="border">
		<div class="navBar">
			<div id="item-nav">
				<a class="nodecoration" href="index.php"><img src="image/musicShareLogo.png" style="max-height: 100px;"></a>
			</div>

			<div id="item-nav">
				<h3 class="card-title">Music Share</h3>
				<form action="index.php" method="POST">
					<div class="input-group" id="search-div">
						<select class="form-control" id="selectCat" name="cat">
							<option value='0' selected>Tout</option>
							<?php
								$countries = $shareHandler->getCategories();
								foreach ($countries as $key) {
									echo "<option value='".$key["idCat"]."'".((isset($_POST["cat"]) && $_POST["cat"] == $key["idCat"])?"selected":"").">".$key["name"]."</option>";
								}
							?>
						</select>
						<input type="text" id="input-navbar" class="form-control" name="search" placeholder="Tapez ce que vous voulez chercher." <?=((isset($_POST["cat"]))?("value='".$_POST['search']."'"):"")?>>
						<input class="btn btn-primary" id="right-btn" type="submit" value="Chercher"/>
					</div>
				</form>
			</div>
			<div id="item-nav">
				<?php
					if(isset($_SESSION["user"])){
						echo "
							<div class='user-nav'>
								<div class='cont no-min-h'>
									<img src='".$_SESSION["user"]["picture"]."' class='img-circle image' width='64'>
									<div class='middle'>
										<img src='image/plus.png' class='img-circle cursorhover' width='64' data-toggle='modal' data-target='#updatePicModal'>
									</div>
								</div>
								<ul class='nav nav-Profil'>
									<li class='nav-item dropdown'>
										<a class='nav-link dropdown-toggle' id='navbarDropdown' role='button' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'>
											".strtoupper($_SESSION["user"]["user"])."
										</a>
										<div class='dropdown-menu' aria-labelledby='navbarDropdown'>
											<a class='dropdown-item' href='profil.php'>Profil</a>
											<div class='dropdown-divider'></div>
											<a class='dropdown-item' href='php/handle.php?action=logoff'>Deconnexion</a>
										</div>
									</li>
								</ul>
							</div>
							";
					}else{
						echo "
							<div class='btn-group'>
								<button class='btn btn-primary' href='#' data-toggle='modal' data-target='#loginModal'>Se connecter</button>
								<a class='btn btn-primary' href='inscription.php'>Inscription</a>
							</div>
							";
					}
				?>
			</div>
		</div>
	</div>
	<div class="modal fade" id="loginModal" tabindex="-1" role="dialog" aria-labelledby="loginModalLabel" aria-hidden="true">
		<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
			<h5 class="modal-title" id="loginModalLabel">Se connecter</h5>
			<button type="button" class="close" data-dismiss="modal" aria-label="Annuler">
				<span aria-hidden="true">&times;</span>
			</button>
			</div>
			<form action="php/handle.php" method="POST">
				<input type="hidden" name="login" value="1">
				<div class="modal-body">
					<div class="form-group">
					<label for="username">Adresse email</label>
					<input type="text" class="form-control" name="username" placeholder="Entrez votre pseudo">
					</div>
					<div class="form-group">
					<label for="password">Password</label>
					<input type="password" class="form-control" name="password" placeholder="Entrez votre mot de passe">
					</div>
				</div>
				<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Annuler</button>
				<input type="submit" class="btn btn-primary" value="Se connecter">
				</div>
			</form>
		</div>
		</div>
	</div>
