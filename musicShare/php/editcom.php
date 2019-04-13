<?php
	include_once ("../classes/handler.php");
	session_start();
	$ret = false;
	if(!isset($_SESSION['user']) || !isset($_POST['idCom']) || ($_POST['idUser'] == "-1")) {
		return json_encode($ret);
	}

	$result = HANDLER_SHARE::getInstance()->editCom($_POST['idUser'],$_POST['idCom'],$_POST['idPost'],$_POST['message']);
	$ret['result'] = $result;
	echo json_encode($ret);
?>
