<?php
	include_once ("header-php.php");
	require "header.php";
	$user = -1;
	if(!isset($_GET["user"])){
		if(isset($_SESSION['user'])){
			$user = $_SESSION['user']['id'];
		}else{
			echo "<script type='text/javascript'>document.location.href='php/index.php';</script>";
		}
	}else{
		$user = $_GET["user"];
	}


	$userData = $shareHandler->getUserFromID($user);
	if ($userData === false) {
		echo "<script type='text/javascript'>document.location.href='index.php';</script>";
	}
?>


<div class="row-inline">
		<div class="col-80 round-border lessmarg">
			<div class="col-40 borderright">
				<div>
					<a href="<?=$userData['picture']?>" target="_blank" class="nodecoration">
						<img src="<?=$userData['picture']?>" class="img-circle w-128">
					</a>
					<span class="textProfil no-m-l"><?=$userData['name']?></span>
				</div>
				<div class="col-8 min-h-270">
					<h5 class="profil-attr"><b>Pseudonyme: </b>
						<text><?=$userData['name']?></text>
					</h5>
					<h5 class="profil-attr"><b>Localisation: </b>
						<text><?=($shareHandler->getCountry($userData['idCountry']))['name']?></text>
						<img src="https://www.countryflags.io/<?=$userData['idCountry']?>/shiny/64.png" width="32">
					</h5>
					<h5 class="profil-attr"><b>Inscrit depuis : </b>
						<text>
							<?php
								$date = $userData['date'];
								$timestamp = strtotime($date);
								$dateformatted = explode("-",date("m-d-Y", $timestamp));
								echo ($dateformatted[1]."/".$dateformatted[0]."/".$dateformatted[2]);

							?>
						</text>
					</h5>
					<h5 class="description"><b>Description: </b><br>
						<div class="test-desc"> <?=($userData['bio'] == "")?"<text><em>Pas de description personnel</em></text>":$userData['bio']?></div>
					</h5>
					<?php
						if (isset($_SESSION['user']) && $_SESSION['user']['id'] === $user) {
							echo "<a class='btn btn-primary btn-lg' href='modifierProfil.php'>Modifier profil</a>";
						}
					?>
				</div>
			</div>
			<div class="col-60">
				<center><span class="textProfil">Posts partag&eacute;s</span></center>
				<?php

					$posts = $shareHandler->getPostsFromId($user);
					foreach ($posts as $post) {
						echo "<div class='item-post'>
								<input type='hidden' id='link-post".$post['idPost']."' value='read=".$post['idPost']."'>
								<div onclick='clickPost(\"read=".$post['idPost']."\");' class='middle-post w-9 pad-5'>
									<div class='type-post'>
										<img src='image/".$post['type'].".png' class='type-img mr-t-8' width='32'>
									</div>
									<div class='text-post'>
										<div class='title-post mr-t-5'>
											<b>".$post['title']."</b>
										</div>
										<div class='data-post'>
											<a href='?cat=".$post['idCat']."'><b style='color: rgb(100, 102, 103);'>".($shareHandler->getCategorieName($post['idCat']))['name']."</b></a> &bull; <em>poste par ".($shareHandler->getUsername($post['idUser']))['name']."</em>
										</div>
									</div>
								</div>
								<div class='commentary-post'>
									<div class='count-com' onclick='clickPost(document.getElementById(\"link-post".$post['idPost']."\").value + \"#com\")'>
										<img src='image/commentary_icon.png' width='16'>
										<span>".($shareHandler->getCountComFromPost($post['idPost']))[0]."</span>
									</div>
								<button class='btn-transparent BtnShare' id='BtnShare' value='".$post['idPost']."' data-clipboard-action='copy'><img src='image/share.png' width='16'></button></div></div>";
							};
				?>
			</div>
		</div>
		<?php require "footer.php" ?>
</div>
<script src="js/clipboard.min.js"></script>
<script type="text/javascript">
	new ClipboardJS('.BtnShare', {
	    text: function() {
	    	alert("Le lien a ete mis dans le presse-papier.");
	        return ("http://localhost:88/musicShare/" + "post.php?" + (document.getElementById('link-post'+ (document.getElementById('BtnShare').value)).value));
	    }
	});
</script>
</body>
</html>
