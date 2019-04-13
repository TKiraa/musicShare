<?php
	include_once ("header-php.php");
	if(isset($_SESSION["user"])){
		header("Location : index.php");
	}
	require "header.php"
?>
<div class="row-inline">
	<div class="col-80">
		 <fieldset>
			<legend>Inscriptions</legend>
			<form action="php/handle.php" method="POST">
				<input type="hidden" name="signup" value="1">
				<div class="form-group">
					<label for="username">Pseudo</label>
			 		<input type="text" class="form-control" id="username" name="username" placeholder="Pseudo" required>
				</div>
				<div class="form-group">
					<label for="mail">Adresse email</label>
				<input type="email" class="form-control" id="mail" name="mail" placeholder="name@example.com" required>
				</div>
				<div class="form-group">
					<label for="pwd">Mot de passe</label>
					<input type="password" class="form-control" id="pwd" name="pwd" placeholder="mot de passe" required>
				</div>
					<div class="form-group">
					<label for="country">Choisir Pays</label>
					<select class="form-control" id="country" name="country">
						<?php
							$countries = $shareHandler->getCountries();
							foreach ($countries as $key) {
								echo "<option value='".$key["idCountry"]."'>".$key["name"]."</option>";
							}
						?>
					</select>
				</div>
				<div class="form-group">
					<div class="form-check">
						<input class="form-check-input" type="checkbox" value="" id="invalidCheck" required>
						<label class="form-check-label" for="invalidCheck">
							Accepter les termes et conditions.
						</label>
						<div class="invalid-feedback">
							Vous devez accepter avant de vous inscrire.
						</div>
					</div>
				</div>
				<button class="btn btn-primary" type="submit">Enregistrer</button>
			</form>
		</fieldset>
	</div>
	<?php require "footer.php" ?>
</div>


</body>
</html>
