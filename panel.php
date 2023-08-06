<?php
include "php/connect.php";
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Panel - Evaluation Process to Diploma System</title>
	<link href="img/icon.png" rel="icon">
	<link href="img/icon.png" rel="apple-touch-icon">
	<link rel="stylesheet" href="css/style.css">
	<link rel="stylesheet" href="css/alert-box.css">
	<link rel="stylesheet" href="css/font-awesome.css">
	<script src="js/ajax.googleapis.com_ajax_libs_jquery_2.2.0_jquery.min.js"></script>
	<script src="js/font-awesome.js"></script>
</head>
<body>
	<div class="header">
		<div class="navigation">
			<img src="img/logo.png" class="logo">
			<a id="index" href="./" title="Evaluation"><i class="fas fa-home"></i>Home</a>
			<a id="panel" href="panel.php" title="Panel" class="active panel"><i class="fas fa-solar-panel"></i>Panel</a>
		</div>
	</div>
	<div class="main">
		<div id="sub-navigation" class="sub-navigation">
			<?php
			if (isset($_GET["student"])) {
				?><a href="panel.php?head">Head</a>
				<a href="panel.php?student" class="active">Student</a>
				<a href="panel.php?subject">Subject</a><?php
			}
			else if (isset($_GET["subject"])) {
				?><a href="panel.php?head">Head</a>
				<a href="panel.php?student">Student</a>
				<a href="panel.php?subject" class="active">Subject</a><?php
			}
			else {
				?><a href="panel.php?head" class="active">Head</a>
				<a href="panel.php?student">Student</a>
				<a href="panel.php?subject">Subject</a><?php
			}
			?>
		</div>
		<div id="main-body" class="main-body">
			<?php
			if (isset($_GET["student"])) {
				include "php/panel-student.php";
			}
			else if (isset($_GET["subject"])) {
				
			}
			else {
				include "php/panel-head.php";
			}
			?>
		</div>
	</div>
	<div id="alert-box" class="alert-box"></div>
	<div id="loader" title="Loading..." oncontextmenu="return false;" class="loader">
		<img src="img/logo.png">
	</div>
	<script>
		document.getElementById("index").addEventListener("click", function() {
			document.getElementById("loader").style.display = "inherit";
		});
	</script>
	<script>
		document.getElementById("panel").addEventListener("click", function() {
			document.getElementById("loader").style.display = "inherit";
		});
	</script>
</body>
</html>