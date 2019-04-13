<?php
	include_once ("header-php.php");
	require "header.php";
?>
<script type="text/javascript">
	window.addEventListener("beforeunload", function (event) {
		document.location.href = document.location;
	});
</script>
<?=(isset($canConnect))?"":""?>

<?php

	if(isset($_GET['connect'])){
		switch ($_GET['connect']) {
			case 1:
				echo "<div class='alert alert-success' role='alert'>Inscription r&eacute;ussie ! vous pouvez maintenant vous connecter.</div>";
				break;
			case 2:
				echo "<div class='alert alert-success' role='alert'>Connexion r&eacute;ussie !</div>";
				break;
			case 3:
				echo "<div class='alert alert-danger' role='alert'>Le Mot de passe et l'identifiant ne correspondent pas.</div>";
				break;
		}
	}
?>
<div class="row-inline">
	<div class="col-80 round-border nopad">
		<?php

			if (isset($_POST["cat"]) ){
				$posts=$shareHandler->search($_POST["cat"],$_POST["search"]);
			}elseif(isset($_GET["cat"])){
				$posts=$shareHandler->search($_GET["cat"],"");
			}else{
				$posts = $shareHandler->getPosts();
			};
			foreach ($posts as $post) {
				$vote = false;
				if(isset($_SESSION['user'])) {
					$vote = $shareHandler->checkVote($post['idPost'],$_SESSION['user']['id']);
				}
				$picUp = "up";
				$picDown = "down";
				if($vote !== false){
					if($vote['vote'] == 1){
						$picUp = "up_selected";
					}else{
						$picDown = "down_selected";
					}
				}

				date_default_timezone_set('Europe/Paris');

				$timestamp = strtotime($post['date']);
				$datetime1 = new DateTime(date("Y-m-d H:i:s", $timestamp));
				$datetime2 = new DateTime(date("Y-m-d H:i:s"));
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
					case ($interval->i > 0):
						$show = $interval->i+1 . " minute" . (($interval->i > 1)?"s":"");
						break;
					case ($interval->s > 0):
						$show = "quelques secondes";
						break;
				}

				echo "<div class='item-post'>
						<input type='hidden' id='link-post".$post['idPost']."' value='read=".$post['idPost']."'>
						<div class='vote-post'>
							<img src='image/".$picUp.".png' id='imgUp' ".(($picUp == "up_selected")?"":"onmouseover='this.src=\"image/up_selected.png\";' onmouseleave='this.src=\"image/up.png\";'")." ".((isset($_SESSION['user']))?("onclick='document.location.href = \"php/handle.php?id=".$post['idPost']."&vote=1\"'"):"class='cant_click' disabled")." style='margin-right: 5px;' width='16'>
							<span>".$post['vote']."</span>
							<img src='image/".$picDown.".png' id='imgDown' ".((!isset($_SESSION['user']))?"class='cant_click' disabled' ":"onclick='document.location.href = \"php/handle.php?id=".$post['idPost']."&vote=0\"'").(($picDown == "down_selected")?"":" onmouseover='this.src=\"image/down_selected.png\";' onmouseleave='this.src=\"image/down.png\";'")." style='margin-left: 5px;'  width='16'>
						</div>
						<div onclick='clickPost(\"read=".$post['idPost']."\");' class='middle-post'>
							<div class='type-post'>
								<img src='image/".$post['type'].".png' class='type-img' width='32'>
							</div>
							<div class='text-post'>
								<div class='title-post'>
									<b>".$post['title']."</b>
								</div>
								<div class='data-post'>

									<a href='?cat=".$post['idCat']."'><b style='color: rgb(100, 102, 103);'>".($shareHandler->getCategorieName($post['idCat']))['name']."</b></a> &bull; <em>posté par <a style='color: #212529;'href='profil.php?user=".$post['idUser']."'>".($shareHandler->getUsername($post['idUser']))['name']."</a>, il y a ".$show."</em>
								</div>
							</div>
						</div>
						<div class='commentary-post'>
							<div class='count-com' onclick='clickPost(document.getElementById(\"link-post".$post['idPost']."\").value + \"#com\")'>
								<img src='image/commentary_icon.png' width='16'>
								<span>".($shareHandler->getCountComFromPost($post['idPost']))[0]."</span>
							</div>";
							if(isset($_SESSION['user']) && $_SESSION['user']['id'] === $post['idUser']){
								echo "
								<div class='dropdown'>
									<button class='btn-transparent dropdown-toggle' type='button' id='ownermenu' data-toggle='dropdown' aria-haspopup='false' aria-expanded='false'>
										<b>...</b>
									</button>

									<div class='dropdown-menu' aria-labelledby='ownermenu'>
										<button class='dropdown-item btn-transparent BtnShare' id='BtnShare' value='".$post['idPost']."' data-clipboard-action='copy'>
											<img src='image/share.png' width='16'>
											<span>Partager</span>
										</button>
										<a class='dropdown-item btn-transparent' href='post.php?edit=".$post['idPost']."'>
											<img src='image/edit.png' width='16'>
											<span>Modifier</span>
										</a>
										<a class='dropdown-item btn-transparent' href='php/handle.php?delete=".$post['idPost']."'>
											<img src='image/delete.png' width='16'>
											<span>Supprimer</span>
										</a>
									</div>
								</div>";
							}else{
								echo "<button class='btn-transparent BtnShare' id='BtnShare' value='".$post['idPost']."' data-clipboard-action='copy'><img src='image/share.png' width='16'></button>";
							}
						echo "</div></div>";
			};
		?>
	</div>
	<?php require "footer.php" ?>
</div>




<script src="js/clipboard.min.js"></script>
<script>
	new ClipboardJS('.BtnShare', {
	    text: function() {
	    	alert("Le lien a ete mis dans le presse-papier.");
	        return ("http://localhost:88/musicShare/" + "post.php?" + (document.getElementById('link-post'+ (document.getElementById('BtnShare').value) ).value));
	    }
	});

	function deletePost(id) {
		$.ajax({
			type: 'POST',
			url: './php/handle.php',
			data: {delete : id},
			success: function(data){
				document.location.href="php/handle.php";
			},
			error: function (xhr, status, error){
				console.log('Fail' + error);
			},
			async: false
		});
	};
</script>




</body>
</html>
