<script src="js/javascript.js"></script>
<div class="col-80 round-border">
	<center><h1 class="display-4"><b>Modifer votre post :</b> <?=(isset($post['title']))?($post['title']):""?></h1></center>
	<form action="php/handle.php" method="POST">
	  <input type="hidden" id="edit-post" name="edit-post" value="<?=$id?>">
	  <input type="hidden" id="owner-post" name="owner-post" value="<?=$post['idUser']?>">
	  <div class="form-group">
		<label for="post-title" class="h5">Titre du post</label>
		<input type="text" class="form-control" id="post-title" name="post-title" value="<?=(isset($post['title']))?($post['title']):""?>" placeholder="Titre post" required>
	  </div>
	  <div class="form-group">
		<label for="selectCat" class="h5">Cat&eacute;gorie de la musique</label>
		<select class="form-control" id="selectCat" name="selectCat">
			<?php
				$categories = $shareHandler->getCategories();
				foreach ($categories as $key) {
					echo "<option value='".$key["idCat"]."'".(($key["idCat"] === $post['idCat'])?"selected":"").">".$key["name"]."</option>";
				}
			?>
		</select>
	  </div>
		  <div class="form-group">
		<label for="post-title" class="h5">Lien de la musique</label><abbr title="Sites disponible : &#013; - Spotify&#013; - Youtube&#013; - Deezer&#013; - SoundCloud&#013; - Dailymotion"><img src="image/point.png" width="16" style="margin-left: 10px;"></abbr>
		<div class="form-inline">
			<a id="post-link" placeholder="Lien de la musique" href="<?=(isset($post['link']))?($post['link']):"erreur de recuperation du lien"?>" style="min-width: 20%;"><?=(isset($post['link']))?($post['link']):"erreur de recuperation du lien"?></a>
			<div id="img-link" style="margin-left: 30px;"><img src='image/<?=(isset($post['type']))?($post['type']):"youtube"?>.png' width='32'></div>
		</div>
	  </div>
	  <div class="form-group">
		<label for="desc" class="h5">Description / Message</label><em id="desc-char" style="margin-left: 10px;color: grey;">(caract&egrave;res : <?=(isset($post['description']))?(256-strlen($post['description'])):"256"?>)</em>
		<textarea class="form-control" id="desc" rows="3" maxlength="256" name="description" value="<?=(isset($post['description']))?($post['description']):""?>" onkeypress="onWriteDesc(document.getElementById('desc').value)" onkeyup="onWriteDesc(document.getElementById('desc').value)"><?=(isset($post['description']))?($post['description']):""?></textarea>
	  </div>
	  <center>
	  	<input type="submit" class="createpost btncreate <?=(isset($_SESSION["user"]))?"shareBtn":"cantShareBtn"?>" value="Partager" <?=(isset($_SESSION["user"]))?"":"title='Vous devez vous connecter vous partager un post.' disabled"?>>
	  </center>
	</form>
</div>
