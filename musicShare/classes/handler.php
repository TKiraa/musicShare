<?php
header('Content-Type: text/html; charset=UTF-8');
class HANDLER_SHARE{

	private $database = null;
	private static $instance = null;
	private function __construct()
	{
		try {
			$this->database = new PDO("mysql:dbname=musicshare;host=localhost", 'root', 'root',array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'));
		} catch (PDOException $e) {
			echo 'Connexion échouée : ' . $e->getMessage();
		}
	}


	public static function getInstance(){
		if(is_null(self::$instance)){
			self::$instance = new HANDLER_SHARE();
		}
		return (self::$instance);
	}
	public function getPosts()
	{
		$sql = "SELECT idPost, title, description, link, `type`, vote, `date`, idUser, idCat FROM posts ORDER BY vote DESC;";
		$query = $this->database->prepare($sql);
		$query->execute();
		return $query->fetchAll();
	}

	public function getPostsFromId($id)
	{
		$sql = "SELECT idPost, title, description, link, `type`, vote, `date`, idUser, idCat FROM posts WHERE idUser = :id ORDER BY vote DESC LIMIT 7;";
		$query = $this->database->prepare($sql);
		$query->bindValue(":id",$id);
		$query->execute();
		return $query->fetchAll();
	}

	public function getPost($id)
	{
		$sql = "SELECT title, description, link, `type`, vote, `date`, idUser, idCat FROM posts WHERE idPost = :id;";
		$query = $this->database->prepare($sql);
		$query->bindValue(":id",$id);
		$query->execute();
		return $query->fetch();
	}

	public function getUser($name,$pwd)
	{
		$sql = "SELECT idUser, email, idCountry, name, picture FROM `user` WHERE name = :name AND password = :pwd;";
		$query = $this->database->prepare($sql);
		$query->bindValue(":name",$name);
		$query->bindValue(":pwd",$pwd);
		$query->execute();
		$return = ($query->fetch());
		return $return;
	}
	public function checkPwdProfil($id,$pwd)
	{
		$sql = "SELECT idUser FROM `user` WHERE idUser = :id AND password = :pwd;";
		$query = $this->database->prepare($sql);
		$query->bindValue(":id",$id);
		$query->bindValue(":pwd",$pwd);
		$query->execute();
		return (($query->fetch() !== false)?true:false);
	}
	public function editProfil($id,$email,$country,$bio)
	{
		$sql = "UPDATE `user` SET email= :email, idCountry = :idC, bio = :bio WHERE idUser = :id;";
		$query = $this->database->prepare($sql);
		$query->bindValue(":id",$id);
		$query->bindValue(":email",$email);
		$query->bindValue(":idC",$country);
		$query->bindValue(":bio",$bio);
		$query->execute();
	}
	public function EditPwdProfil($id,$new)
	{
		$sql = "UPDATE `user` SET password = :pwd WHERE idUser = :id;";
		$query = $this->database->prepare($sql);
		$query->bindValue(":id",$id);
		$query->bindValue(":pwd",$new);
		$query->execute();
	}

	public function getUserFromID($id)
	{
		$sql = "SELECT email, idCountry, name, bio, picture, `date` FROM `user` WHERE idUser = :id;";
		$query = $this->database->prepare($sql);
		$query->bindValue(":id",$id);
		$query->execute();
		$return = ($query->fetch());
		return $return;
	}
	public function editPic($id,$pic)
	{
		$sql = "UPDATE `user` SET picture = :pic WHERE idUser = :id;";
		$query = $this->database->prepare($sql);
		$query->bindValue(":id",$id);
		$query->bindValue(":pic",$pic);
		$query->execute();
	}

	public function getOwnerPost($id){
		$sql = "SELECT idUser FROM posts WHERE idPost = :idP;";
		$query = $this->database->prepare($sql);
		$query->bindValue(":idP",$id);
		$query->execute();
		return $query->fetch();
	}

	public function deletePost($id){
		$sql = "DELETE FROM posts WHERE idPost = :idP;";
		$query = $this->database->prepare($sql);
		$query->bindValue(":idP",$id);
		$query->execute();
	}

	public function checkvote($idPost,$idUser){
		$sql = "SELECT idVoteUser,vote FROM uservote WHERE idUser = :idUser AND idPost = :idPost;";
		$query = $this->database->prepare($sql);
		$query->bindValue(":idPost",$idPost);
		$query->bindValue(":idUser",$idUser);
		$query->execute();
		return $query->fetch();
	}

	public function updateVote($idPost,$vote){
		if($vote){
			$sql = "UPDATE posts SET vote=vote+1 WHERE idPost = :idPost;";
		}else{
			$sql = "UPDATE posts SET vote=vote-1 WHERE idPost = :idPost;";
		}
		$query = $this->database->prepare($sql);
		$query->bindValue(":idPost",$idPost);
		$query->execute();
	}

	public function updateUserVote($idVoteUser,$vote){
		$sql = "UPDATE uservote SET vote=:vote WHERE idVoteUser = :idVoteUser;";
		$query = $this->database->prepare($sql);
		$query->bindValue(":vote",$vote);
		$query->bindValue(":idVoteUser",$idVoteUser);
		$query->execute();
	}

	public function insertVote($idPost,$idUser,$vote){
		$sql = "INSERT INTO uservote (idUser, idPost, vote) VALUES (:idUser, :idPost, :vote);";
		$query = $this->database->prepare($sql);
		$query->bindValue(":idPost",$idPost);
		$query->bindValue(":idUser",$idUser);
		$query->bindValue(":vote",$vote);
		$query->execute();
	}

	public function deleteVote($idVoteUser){
		$sql = "DELETE FROM uservote WHERE idVoteUser = :idVoteUser;";
		$query = $this->database->prepare($sql);
		$query->bindValue(":idVoteUser",$idVoteUser);
		$query->execute();
	}

	public function votePost($idPost,$idUser,$vote){
		$voteExist = $this->checkvote($idPost,$idUser);
		if($voteExist !== false){
			if((int)$vote == (int)$voteExist['vote']){
				$this->deleteVote($voteExist['idVoteUser']);
				$this->updateVote($idPost,!($vote));
				return;
			}else{
				$this->updateVote($idPost,$vote);
				$this->updateVote($idPost,$vote);
				$this->updateUserVote($voteExist['idVoteUser'],(int)$vote);
				return;
			}
		}else{
			$this->insertVote($idPost,$idUser,(int)$vote);
			$this->updateVote($idPost,$vote);
		}
	}

	public function getUsername($id)
	{
		$sql = "SELECT name FROM `user` WHERE idUser = :id";
		$query = $this->database->prepare($sql);
		$query->bindValue(":id",$id);
		$query->execute();
		$return = ($query->fetch());
		return $return;
	}

	public function getCategories()
	{
		$sql = "SELECT idCat, name FROM categorie;";
		$query = $this->database->prepare($sql);
		$query->execute();
		return $query->fetchAll();
	}

	public function getCategorieName($id)
	{
		$sql = "SELECT name FROM categorie WHERE idCat = :id;";
		$query = $this->database->prepare($sql);
		$query->bindValue(":id",$id);
		$query->execute();
		$return = $query->fetch();
		return $return;
	}

	public function getCountries()
	{
		$sql = "SELECT idCountry, name FROM country;";
		$query = $this->database->prepare($sql);
		$query->execute();
		$return = $query->fetchAll();
		return $return;
	}

	public function getCountry($id)
	{
		$sql = "SELECT name FROM country WHERE idCountry = :id;";
		$query = $this->database->prepare($sql);
		$query->bindValue(":id",$id);
		$query->execute();
		$return = $query->fetch();
		return $return;
	}

	public function getComFromPost($idPost)
	{
		$sql = "SELECT idCom, idUser, message, `date` FROM commentary WHERE idPost = :id ORDER BY `date` DESC;";
		$query = $this->database->prepare($sql);
		$query->bindValue(":id",$idPost);
		$query->execute();
		return ($query->fetchAll());
	}

	public function getCountComFromPost($idPost)
	{
		$sql = "SELECT COUNT(idCom) FROM commentary WHERE idPost = :id;";
		$query = $this->database->prepare($sql);
		$query->bindValue(":id",$idPost);
		$query->execute();
		return ($query->fetch());
	}

	public function addCom($idPost,$commentary,$idUser){
		$sql = "INSERT INTO commentary (idUser, message, `date`, idPost) VALUES (:idUser, :commentary, NOW(), :idPost);";
		$query = $this->database->prepare($sql);
		$query->bindValue(":idPost",$idPost);
		$query->bindValue(":commentary",$commentary);
		$query->bindValue(":idUser",$idUser);
		$query->execute();
	}

	public function editCom($idUser,$idCom,$idPost,$message){
		$sql = "UPDATE commentary SET message = :message WHERE idUser = :idUser AND idPost = :idPost AND idCom = :idCom;";
		$query = $this->database->prepare($sql);
		$query->bindValue(":idPost",$idPost);
		$query->bindValue(":idCom",$idCom);
		$query->bindValue(":idUser",$idUser);
		$query->bindValue(":message",$message);
		return ($query->execute());
	}

	public function deleteCom($idPost, $idCom, $idUser) {
		$sql = "DELETE FROM commentary WHERE idCom = :idCom AND idPost = :idPost AND idUser = :idUser;";
		$query = $this->database->prepare($sql);
		$query->bindValue(":idCom",$idCom);
		$query->bindValue(":idPost",$idPost);
		$query->bindValue(":idUser",$idUser);
		$query->execute();
	}

	public function signUp($mail,$name,$pwd,$id){
		$sql = "INSERT INTO `user` (email, name, password, `date`, idCountry) VALUES (:mail, :name, :pwd, NOW(), :id);";
		$query = $this->database->prepare($sql);
		$query->bindValue(":mail",$mail);
		$query->bindValue(":name",$name);
		$query->bindValue(":pwd",$pwd);
		$query->bindValue(":id",$id);
		$query->execute();
		return $this->database->lastInsertId();
	}

	public function createPost($title,$description,$link,$type,$idU,$idC){
		$sql = "INSERT INTO posts (title, description, link, `type`, idUser, idCat) VALUES (:title, :description, :link, :type, :idU, :idC);";
		$query = $this->database->prepare($sql);
		$query->bindValue(":title",$title);
		$query->bindValue(":description",$description);
		$query->bindValue(":link",$link);
		$query->bindValue(":type",$type);
		$query->bindValue(":idU",$idU);
		$query->bindValue(":idC",$idC);
		$query->execute();
	}

	public function EditPost($idPost, $title, $desc, $cat){
		$sql = "UPDATE posts SET title = :title, description = :descr, idCat = :idC WHERE idPost = :idP;";
		$query = $this->database->prepare($sql);
		$query->bindValue(":title",$title);
		$query->bindValue(":descr",$desc);
		$query->bindValue(":idC",$cat);
		$query->bindValue(":idP",$idPost);
		$query->execute();
	}





	public function search($cat,$chaine)
	{
		if($cat != 0){
			$sql = "SELECT idPost, title, description, link, `type`, vote, `date`, idUser, idCat FROM posts WHERE idCat = :idCat AND (UPPER(title) LIKE concat('%', :chaine, '%')) ORDER BY vote DESC;";
		}else{
			$sql = "SELECT idPost, title, description, link, `type`, vote, `date`, idUser, idCat FROM posts WHERE (UPPER(title) LIKE concat('%', :chaine, '%')) ORDER BY vote DESC;";
		}

		$query = $this->database->prepare($sql);
		$query->bindValue(":chaine",$chaine);
		if($cat != 0){
			$query->bindValue(":idCat",$cat);
		};
		$query->execute();
		return $query->fetchAll();
	}
}


?>
