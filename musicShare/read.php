<script src="js/javascript.js"></script>
<?php

if(isset($_POST['add-com'])){
	if(isset($_SESSION['user'])){
		$shareHandler->addCom($_POST['add-com'],$_POST['item-com-post'],$_SESSION['user']['id']);
	}
}

if(isset($_GET['deletecom'])){
	if(isset($_SESSION['user'])){
		$shareHandler->deleteCom($id,$_GET['deletecom'],$_SESSION['user']['id']);
	}
}

?>
<div class="col-80 round-border">
	<center><h3><b>Vous regardez le post :</b> <?=(isset($post['title']))?($post['title']):""?></h3></center>
	<br>
	  <div class="form-group">
		<label for="post-title" class="h5">Lien de la musique</label><abbr title="Sites disponible : &#013; - Spotify&#013; - Youtube&#013; - Deezer&#013; - SoundCloud&#013; - Dailymotion"><img src="image/point.png" width="16" style="margin-left: 10px;"></abbr>
		<br>
				<?php

					switch ($post['type']) {
						case 'youtube':
							$codeVideo = "";
							if (strpos($post['link'], 'watch?v=') !== false) {
								$codeVideo = explode("watch?v=", $post['link'])[1];

							}elseif (strpos($post['link'], 'youtu.be') !== false) {
								$codeVideo = explode("youtu.be/", $post['link'])[1];
							}
							if($codeVideo === "") {
								echo "Erreur lors de la saisie du lien de la musique. contactez l'utilisateur du post.";
							}else{
								echo "<iframe width='560' class='link-embed' height='315' src='https://www.youtube.com/embed/".$codeVideo."' frameborder='0' allow='accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture' allowfullscreen></iframe>";
							}
							break;
						case 'dailymotion':
							$codeVideo = "";
							if (strpos($post['link'], 'dai.ly/') !== false) {
								$codeVideo = explode("dai.ly/", $post['link'])[1];

							}elseif (strpos($post['link'], 'video/') !== false) {
								$codeVideo = explode("video/", $post['link'])[1];
							}
							if($codeVideo === "") {
								echo "Erreur lors de la saisie du lien de la musique. contactez l'utilisateur du post.";
							}else{
								echo "<iframe frameborder='0' class='link-embed' width='560' height='270' src='https://www.dailymotion.com/embed/video/".$codeVideo."' allowfullscreen allow='autoplay'></iframe>";
							}
							break;
						case 'deezer':
							$codeVideo = "";
							if (strpos($post['link'], 'track/') !== false) {
								$codeVideo = explode("track/", $post['link'])[1];
							}
							if($codeVideo === "") {
								echo "Erreur lors de la saisie du lien de la musique. contactez l'utilisateur du post.";
							}else{
								echo "<iframe scrolling='no' class='link-embed' frameborder='0' allowTransparency='true' src='https://www.deezer.com/plugins/player?format=classic&autoplay=false&playlist=true&width=560&height=350&color=007FEB&layout=dark&size=medium&type=tracks&id=".$codeVideo."&app_id=1' width='540' height='350'></iframe>";
							}
							break;
						default:
							echo "<a href='".$post['link']."'>".$post['link']."</a>";
							break;
					}

				?>
	  </div>
	  <div class="form-group">
		<label for="desc" class="h5">Description / Message</label>
		<h6 id="desc"><?=(isset($post['description']))?($post['description']):""?></h6>
	  </div>
	  <?=(!isset($_SESSION['user'])?"":"<hr>")?>
	  <div class="d-grid" <?=(!isset($_SESSION['user'])?"hidden":"")?> >
		<form action="post.php?read=<?=$id?>" method="POST">
			<input type="hidden" name="add-com" value="<?=$id?>">
			<div class="form-group">
				<label for="commentary">Commentaires</label>
				<textarea class="form-control min-w-430" id="commentary" rows="3" name="item-com-post" aria-describedby="commentaireHelp" placeholder="Ajouter commentaire"></textarea>
			</div>
			<button type="submit" class="btn btn-primary " style='float: right;'>Publier</button>
		</form>
	</div>
	<hr class="mr-t-8" id="com">
	<?php

		$comments = $shareHandler->getComFromPost($id);
		foreach ($comments as $com) {
			$user = $shareHandler->getUserFromID($com['idUser']);
			$date = $com['date'];
			$timestamp = strtotime($date);
			$datetime1 = new DateTime(date("Y-m-d H:i:s", $timestamp));
			$datetime2 = new DateTime(date("Y-m-d H:i:s"),new DateTimeZone('Europe/Paris'));
			$interval = $datetime1->diff($datetime2);
			$show = 0;
			switch (true) {
				case ($interval->y > 0):
					$show = $interval->y+1 . " année" . (($interval->y > 1)?"s":"");
					break;
				case ($interval->m > 0):
					$show = $interval->m+1 . " mois";
					break;
				case ($interval->d > 0):
					$show = $interval->d+1 . " jour" . (($interval->d > 1)?"s":"");
					break;
				case ($interval->h > 0):
					$show = $interval->h+1 . " heure" . (($interval->h > 1)?"s":"");
					break;
				case ($interval->m > 0):
					$show = $interval->m+1 . " minute" . (($interval->m > 1)?"s":"");
					break;
				case ($interval->s > 0):
					$show = "quelques secondes";
					break;
			}
			echo"<div class='item-com'>
				<input type='hidden' id='com".$com['idCom']."' value=\"".$com['message']."\">
				<div class='pic-com'>
					<img src='".$user['picture']."' class='img-circle noborder' width='48'>
				</div>
				<div class='data-com'>
					<div class='user-com'>
						<b><a href='profil.php?user=12' class='nodecoration'>".$user['name']."</a></b> il y a ".$show;
			echo"</div>
					<div class='text-com' id='text-com".$com['idCom']."'>
						<em>".$com['message']."</em>
					</div>
				</div>";

				if(isset($_SESSION['user']) && $com['idUser'] == $_SESSION['user']['id']){
					echo "<div class='owner-com' id='owner-com".$com['idCom']."'>
						<div class='dropdown'>
							<button class='btn-transparent dropdown-toggle' type='button' id='ownermenu' data-toggle='dropdown' aria-haspopup='false' aria-expanded='false'>
								<b>...</b>
							</button>

							<div class='dropdown-menu' aria-labelledby='ownermenu'>
								<button class='dropdown-item btn-transparent' onClick='editCom(".$com['idCom'].")'>
									<img src='image/edit.png' width='16'>
									<span>Modifier</span>
								</button>
							<a class='dropdown-item btn-transparent' href='post.php?read=".$id."&deletecom=".$com['idCom']."'>
									<img src='image/delete.png' width='16'>
									<span>Supprimer</span>
								</a>
							</div>
						</div>
					</div>";
				}
				echo"</div>";
		}
	?>
</div>


<script type="text/javascript">

	function editCom(idCom) {
		var message = $(("#com" + idCom)).val();
		$(("#text-com" + idCom)).html(
			"<div class='form-group'><div id='error'></div><textarea class='form-control min-w-430' id='comText"+idCom+"' rows='3' name='item-com-post' aria-describedby='commentaireHelp' placeholder='Ajouter commentaire'>" + message + "</textarea></div><button type='submit' onclick='confirmEditCom(document.getElementById(\"comText"+idCom+"\").value,"+idCom+")' class='btn btn-primary' style='float: right; margin-left : 10px;'>Editer</button><button type='submit' onclick='abortEditCom("+idCom+")' class='btn btn-primary' style='float: right;'>Annuler</button>"
		);
		$(("#owner-com" + idCom)).hide();
	}

	function confirmEditCom(text,idC){
		$.ajax({
			type: 'POST',
			url: 'php/editCom.php',
			dataType: 'json',
			data: {
					idUser : <?=(isset($_SESSION['user'])?$_SESSION['user']['id']:"-1")?>,
					idCom : idC,
					idPost : <?=$id?>,
					message : text
			},
			success: function(data){
				if(data.result){
					$(("#text-com" + idC)).html("<em>" + text + "</em>");
					$(("#owner-com" + idC)).show();
					$(("#com" + idC)).val(text);
				}else{

				}
			},
			error: function (xhr, status, error){
			    console.log(error);
			},
		});
	}


	function abortEditCom(idC) {
		$(("#text-com" + idC)).html("<em>" + $(("#com" + idC)).val() + "</em>");
		$(("#owner-com" + idC)).show();
	}
</script>
