<?php
	include_once ("../header-php.php");

	if( isset($_GET["action"]) ||
		isset($_GET["vote"]) ||
		isset($_POST["signup"]) ||
		isset($_POST["post-type"]) ||
		isset($_POST["login"]) ||
		isset($_GET["delete"]) ||
		isset($_POST["edit-post"])
	){
			if(isset($_GET["action"])){
				if(($_GET["action"] === "logoff") && isset($_SESSION['user'])){
					 unset($_SESSION['user']);
				}
			}

			if(isset($_GET["vote"])){
				if($_GET["vote"]){
					$shareHandler->votePost($_GET['id'],$_SESSION['user']['id'],true);
				}else{
					$shareHandler->votePost($_GET['id'],$_SESSION['user']['id'],false);
				}
			}

			if(isset($_POST["signup"])){
				$shareHandler->signUp($_POST["mail"], $_POST["username"], $_POST["pwd"], $_POST["country"]);

				header("Location: ../index.php?connect=1");
				exit();
			}
			if(isset($_POST["post-type"])){
				$shareHandler ->createPost($_POST["post-title"], $_POST["description"], $_POST["post-link"], $_POST["post-type"], $_SESSION["user"]['id'], $_POST["selectCat_Create"]);
				$_POST = array();
			}
			if(isset($_POST["login"])){
				$user = $shareHandler ->getUser($_POST["username"],$_POST["password"]);
				if($user !== false){
					$array = array(
						"mail" => $user["email"],
						"user" => $user["name"],
						"country" => $user["idCountry"],
						"id" => $user["idUser"],
						"picture" => $user["picture"]
					);
					$_SESSION["user"] = $array;
					header("Location: ../index.php?connect=2");
					exit();
				}
				header("Location: ../index.php?connect=3");
				exit();
			}
			if(isset($_GET["delete"])) {
				$idOwner = $shareHandler->getOwnerPost($_GET["delete"]);
				if($_SESSION['user']['id'] === $idOwner['idUser']){
					$shareHandler->deletePost($_GET["delete"]);
				}
			}

			if(isset($_POST["edit-post"])){
				if($_POST['owner-post'] == $_SESSION["user"]['id']){
					$shareHandler ->EditPost($_POST["edit-post"], $_POST["post-title"], $_POST["description"], $_POST["selectCat"]);
					header("Location: ../post.php?read=".$_POST["edit-post"]);
					exit();
				}
			}
		header("Location: ../index.php");
		exit();
	}


	if(isset($_POST['modif-profil'])){
		if($shareHandler->checkPwdProfil($_SESSION['user']['id'],$_POST['pwd-profil'])){
			$shareHandler->EditProfil($_SESSION['user']['id'],$_POST['email-profil'],$_POST['country'],$_POST['bio-profil']);
			header("Location: ../modifierProfil.php?edit=1");
			exit();
		}
		header("Location: ../modifierProfil.php?edit=0");
		exit();
	}

	if(isset($_POST['newpassword'])){
		if($shareHandler->checkPwdProfil($_SESSION['user']['id'],$_POST['old-password']) && ($_POST['newpassword'] == $_POST['newpassword_confirm'])) {
			$shareHandler->EditPwdProfil($_SESSION['user']['id'],$_POST['newpassword']);
			header("Location: ../modifierProfil.php?edit=1");
			exit();
		}
		header("Location: ../modifierProfil.php?edit=2");
		exit();
	}
?>
