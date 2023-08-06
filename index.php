<?php
if (isset($_COOKIE["admin"])) {
	
}
else if (isset($_COOKIE["evaluation-process"])) {
	
}
else if (isset($_COOKIE["sop-promotional"])) {
	
}
else {
	header("location:login");
}
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link href="img/icon.png" rel="icon">
	<link href="img/icon.png" rel="apple-touch-icon">
	<link rel="stylesheet" href="css/style.css?v=1.0">
	<link rel="stylesheet" href="css/font-awesome.css?v=1.0">
	<?php include "css/media-screen.php"; ?>
	<script src="js/code.jquery.com_jquery-3.6.0.min.js?v=1.0"></script>
	<script src="js/font-awesome.js?v=1.0"></script>
	<script>
		function getCookie(cookieName) {
			var cookieString = document.cookie;
			var cookies = cookieString.split(";");

			for (var i = 0; i < cookies.length; i++) {
				var cookie = cookies[i].trim();
				if (cookie.startsWith(cookieName + "=")) {
					return cookie.substring(cookieName.length + 1);
				}
			}
			return null;
		}
	</script>
</head>
<body>
	<div class="header">
		<a id="menu-bar" class="menu-bar"><i class="fas fa-bars"></i></a>
		<div class="navigation">
			<img src="img/logo.png" class="logo">
			<a id="index" href="./" title="Evaluation" class="active"><i class="fas fa-home"></i>Home</a>
			<?php
			if (isset($_COOKIE["admin"]) || isset($_COOKIE["evaluation-process"]) || isset($_COOKIE["sop-promotional"])) {
				echo "<a id='logout-btn' title='Logout' class='logout'><i class='fas fa-solar-panel'></i>Logout</a>";
			}
			?>
		</div>
	</div>
	<div class="main">
		<div id="sub-navigation" class="sub-navigation <?php if (isset($_COOKIE['navigation'])) { echo $_COOKIE['navigation']; } else { echo 'maximized'; } ?>">
			<?php
			if (isset($_COOKIE["evaluation-process"])) {
				?><div id="application-evaluation" title="Application for Evaluation" class="active">
					<a><img src="img/icon/11310.png"></a>
				</div>
				<div id="final-evaluation-result-form" title="Final Evaluation Result Form">
					<a><img src="img/icon/51064.png"></a>
				</div>
				<div id="application-graduation" title="Application for Graduation">
					<a><img src="img/icon/11311.png"></a>
				</div>
				<div id="list-graduates" title="List of Graduates">
					<a><img src="img/icon/429.png"></a>
				</div>
				<div id="create-diploma" title="Create Diploma">
					<a><img src="img/icon/67.png"></a>
					</div><?php
			}
			else if (isset($_COOKIE["sop-promotional"])) {
				?><div id="promotional" title="Promotional">
					<a><img src="img/icon/11.png"></a>
				</div>
				<div id="grade-sheet" title="Grade Sheet">
					<a><img src="img/icon/55.png"></a>
				</div>
				<div id="list-promoted" title="List of Promoted">
					<a><img src="img/icon/429.png"></a>
				</div>
				<div id="create-sop-diploma" title="Create Diploma">
					<a><img src="img/icon/67.png"></a>
				</div><?php
			}
			else if (isset($_COOKIE["admin"])) {
				?><div id="dashboard" title="Dashboard">
					<a href="?dashboard"><i class="fas fa-chart-line"></i></a>
				</div>
				<div id="colleges" title="Colleges">
					<a href="?colleges"><i class="fas fa-university"></i></a>
				</div>
				<div id="heads" title="Heads">
					<a href="?heads"><i class="fas fa-user-tie"></i></a>
				</div>
				<div id="subjects" title="Subjects">
					<a href="?subjects"><i class="far fa-file-alt"></i></a>
				</div>
				<div id="professors" title="Professors">
					<a href="?professors"><i class="fas fa-chalkboard-teacher"></i></a>
				</div><?php
			}
			?>
		</div>
		<div id="main-body" class="main-body">
			<?php
			if (isset($_COOKIE["evaluation-process"])) {
				if (isset($_GET["page"])) {
					$page = $_GET["page"];
					if ($page == "final-evaluation-result-form") {
						include "php/final-evaluation-result-form.php";
					}
					else if ($page == "application-for-graduation") {
						include "php/application-graduation.php";
					}
					else if ($page == "list-of-graduates") {
						include "php/list-graduates.php";
					}
					else if ($page == "create-diploma") {
						include "php/create-diploma.php";
					}
					else {
						include "php/application-evaluation.php";
					}
				}
				else {
					include "php/application-evaluation.php";
				}
			}
			else if (isset($_COOKIE["sop-promotional"])) {
				if (isset($_GET["page"])) {
					$page = $_GET["page"];
					if ($page == "grade-sheet") {
						include "php/grade-sheet.php";
					}
					else if ($page == "list-of-promoted") {
						include "php/list-promoted.php";
					}
					else if ($page == "create-sop-diploma") {
						include "php/create-sop-diploma.php";
					}
					else {
						include "php/promotional.php";
					}
				}
				else {
					include "php/promotional.php";
				}
			}
			else if (isset($_COOKIE["admin"])) {
				if (isset($_GET["subjects"])) {
					include "php/admin-subjects.php";
				}
				else if (isset($_GET["colleges"])) {
					include "php/admin-colleges.php";
				}
				else if (isset($_GET["professors"])) {
					include "php/admin-professors.php";
				}
				else if (isset($_GET["heads"])) {
					include "php/admin-heads.php";
				}
				else {
					include "php/admin-dashboard.php";
				}
			}
			?>
		</div>
	</div>
	<div id="modal" class="modal">
		<div id="modal-content" class="modal-content"></div>
	</div>
	<div id="loader" title="Loading..." oncontextmenu="return false;" class="loader">
		<img src="img/logo.png">
	</div>
	<script>
		document.getElementById("menu-bar").addEventListener("click", function() {
			var subNav = document.getElementById("sub-navigation");
			if (subNav.classList.contains("maximized")) {
				document.getElementById("sub-navigation").classList.remove("maximized");
				document.getElementById("sub-navigation").classList.add("minimized");
				document.cookie = "navigation = minimized";
			}
			else {
				document.getElementById("sub-navigation").classList.add("maximized");
				document.getElementById("sub-navigation").classList.remove("minimized");
				document.cookie = "navigation = maximized";
			}
		});
	</script>
	<script>
		document.getElementById("index").addEventListener("click", function() {
			document.getElementById("loader").style.display = "inherit";
		});
	</script>
	<?php
	if (isset($_COOKIE["admin"]) || isset($_COOKIE["evaluation-process"]) || isset($_COOKIE["sop-promotional"])) {
		?><script>
			document.getElementById("logout-btn").addEventListener("click", function() {
				document.getElementById("loader").style.display = "inherit";
				$.ajax({
					url: "php/logout.php",
					type: "post",
					success: function(response) {
						if (response == "success") {
							location.reload();
						}
						else {
							alert(response);
						}
					}
				});
			});
		</script><?php
	}
	if (isset($_COOKIE["evaluation-process"])) {
		?><script>
			document.getElementById("application-evaluation").addEventListener("click", function() {
				document.getElementById("loader").style.display = "inherit";
				location.href = "./";
			});
		</script>
		<script>
			document.getElementById("final-evaluation-result-form").addEventListener("click", function() {
				document.getElementById("loader").style.display = "inherit";
				$.ajax({
					url: "php/final-evaluation-result-form.php",
					type: "post",
					data: {
						rel: "",
					},
					success: function(response) {
						document.getElementById("loader").style.display = "none";
						window.history.pushState("", "", "?page=final-evaluation-result-form");
						$("#main-body").html(response);
					}
				});
			});
		</script>
		<script>
			document.getElementById("application-graduation").addEventListener("click", function() {
				document.getElementById("loader").style.display = "inherit";
				$.ajax({
					url: "php/application-graduation.php",
					type: "post",
					data: {
						rel: "",
					},
					success: function(response) {
						document.getElementById("loader").style.display = "none";
						window.history.pushState("", "", "?page=application-for-graduation");
						$("#main-body").html(response);
					}
				});
			});
		</script>
		<script>
			document.getElementById("list-graduates").addEventListener("click", function() {
				document.getElementById("loader").style.display = "inherit";
				$.ajax({
					url: "php/list-graduates.php",
					type: "post",
					data: {
						rel: "",
					},
					success: function(response) {
						document.getElementById("loader").style.display = "none";
						window.history.pushState("", "", "?page=list-of-graduates");
						$("#main-body").html(response);
					}
				});
			});
		</script>
		<script>
			document.getElementById("create-diploma").addEventListener("click", function() {
				document.getElementById("loader").style.display = "inherit";
				$.ajax({
					url: "php/create-diploma.php",
					type: "post",
					data: {
						rel: "",
					},
					success: function(response) {
						document.getElementById("loader").style.display = "none";
						window.history.pushState("", "", "?page=create-diploma");
						$("#main-body").html(response);
					}
				});
			});
		</script><?php
	}
	else if (isset($_COOKIE["sop-promotional"])) {
		?><script>
			document.getElementById("promotional").addEventListener("click", function() {
				document.getElementById("loader").style.display = "inherit";
				$.ajax({
					url: "php/promotional.php",
					type: "post",
					data: {
						rel: "",
					},
					success: function(response) {
						document.getElementById("loader").style.display = "none";
						window.history.pushState("", "", "?page=promotional");
						$("#main-body").html(response);
					}
				});
			});
		</script>
		<script>
			document.getElementById("grade-sheet").addEventListener("click", function() {
				document.getElementById("loader").style.display = "inherit";
				$.ajax({
					url: "php/grade-sheet.php",
					type: "post",
					data: {
						rel: "",
					},
					success: function(response) {
						document.getElementById("loader").style.display = "none";
						window.history.pushState("", "", "?page=grade-sheet");
						$("#main-body").html(response);
					}
				});
			});
		</script>
		<script>
			document.getElementById("list-promoted").addEventListener("click", function() {
				document.getElementById("loader").style.display = "inherit";
				$.ajax({
					url: "php/list-promoted.php",
					type: "post",
					data: {
						rel: "",
					},
					success: function(response) {
						document.getElementById("loader").style.display = "none";
						window.history.pushState("", "", "?page=list-of-promoted");
						$("#main-body").html(response);
					}
				});
			});
		</script>
		<script>
			document.getElementById("create-sop-diploma").addEventListener("click", function() {
				document.getElementById("loader").style.display = "inherit";
				$.ajax({
					url: "php/create-sop-diploma.php",
					type: "post",
					data: {
						rel: "",
					},
					success: function(response) {
						document.getElementById("loader").style.display = "none";
						window.history.pushState("", "", "?page=create-sop-diploma");
						$("#main-body").html(response);
					}
				});
			});
		</script><?php
	}
	?>
</body>
</html>