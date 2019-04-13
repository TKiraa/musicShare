<?php
	include_once ("header-php.php");
	require "header.php";
?>

<div class="row-inline">
	<?php
		$id = 0;
		switch (true) {
			case (isset($_GET['edit'])):
				$post = $shareHandler->getPost($_GET['edit']);
				$id = $_GET['edit'];
				require "edit.php";
				break;
			case (isset($_GET['read'])):
				$post = $shareHandler->getPost($_GET['read']);
				$id = $_GET['read'];
				require "read.php";
				break;
			default:
				echo "<script type='text/javascript'>document.location.href='index.php';</script>";
				break;
		}
		require "footer.php";
	?>
</div>



</body>
</html>
