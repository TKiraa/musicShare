<?php
	include_once ("header-php.php");
	require "header.php"
?>

<script src="js/javascript.js"></script>
<div class="row-inline">
	<div class="col-80 round-border">
		<center><h1 class="display-4">Partagez votre musique</h1></center>
		<form action="php/handle.php" method="POST">
		  <input type="hidden" id="post-type" name="post-type" value="0">
		  <div class="form-group">
			<label for="post-title" class="h5">Titre du post</label>
			<input type="text" class="form-control" id="post-title" name="post-title" placeholder="Titre post" required>
		  </div>
		  <div class="form-group">
			<label for="selectCat_Create" class="h5">Cat&eacute;gorie de la musique</label>
			<select class="form-control" id="selectCat_Create" name="selectCat_Create">
				<?php
					$countries = $shareHandler->getCategories();
					foreach ($countries as $key) {
						echo "<option value='".$key["idCat"]."'>".$key["name"]."</option>";
					}
				?>
			</select>
		  </div>
  		  <div class="form-group">
			<label for="post-title" class="h5">Lien de la musique</label><abbr title="Sites disponible : &#013; - Spotify&#013; - Youtube&#013; - Deezer&#013; - SoundCloud&#013; - Dailymotion"><img src="image/point.png" width="16" style="margin-left: 10px;"></abbr>
			<div class="form-inline">
				<input type="text" class="form-control" id="post-link" name="post-link" placeholder="Lien de la musique" style="width: 50%;" onchange="findMusicWeb(document.getElementById('post-link').value)" required>
				<div id="img-link" style="margin-left: 30px;"></div>
			</div>
		  </div>
		  <div class="form-group">
			<label for="desc" class="h5">Description / Message</label><em id="desc-char" style="margin-left: 10px;color: grey;">(caract&egrave;res : 256)</em>
			<textarea class="form-control" id="desc" rows="3" maxlength="256" name="description" onkeypress="onWriteDesc(document.getElementById('desc').value)" onkeyup="onWriteDesc(document.getElementById('desc').value)"></textarea>
		  </div>
		  <center>
		  	<input type="submit" class="createpost btncreate <?=(isset($_SESSION["user"]))?"shareBtn":"cantShareBtn"?>" value="Partager" <?=(isset($_SESSION["user"]))?"":"title='Vous devez vous connecter vous partager un post.' disabled"?>>
		  </center>
		</form>
	</div>
	<?php require "footer.php" ?>
</div>
</body>
</html>
