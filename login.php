<?php
if (isset($_COOKIE["admin"])) {
	header("location:./");
}
else if (isset($_COOKIE["evaluation-process"])) {
	header("location:./");
}
else if (isset($_COOKIE["sop-promotional"])) {
	header("location:./");
}
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Login - Evaluation Process and SOP Promotional to Diploma System</title>
	<link href="img/icon.png" rel="icon">
	<link href="img/icon.png" rel="apple-touch-icon">
	<link rel="stylesheet" href="css/style.css">
	<link rel="stylesheet" href="css/login.css">
	<style>
		body {
			background-color: #f0f2f5;
		}
	</style>
	<link rel="stylesheet" href="css/font-awesome.css">
	<script src="js/code.jquery.com_jquery-3.6.0.min.js"></script>
	<script src="js/font-awesome.js"></script>
</head>
<body>
	<div class="header">
		<div class="navigation">
			<img src="img/logo.png" class="logo">
			<a id="index" href="./" title="Evaluation" class="active"><i class="fas fa-home"></i>Home</a>
		</div>
	</div>
	<div class="main">
		<div class="login-form">
			<img src="img/logo.png">
			<h1>Login</h1>
			<div class="login-form-body">
				<i class="login-icon fas fa-user"></i>
				<input id="username" placeholder="Username/Employee No." title="Username" autocomplete="off">
				<i class="login-icon fas fa-lock"></i>
				<input type="password" id="password" placeholder="Password" title="Password" autocomplete="off">
				<i class="login-icon fas fa-cog"></i>
				<select id="type" title="Login Type">
					<option value="" selected hidden>Login Type</option>
					<option value="admin">Admin</option>
					<option value="evaluationprocess">Evaluation Process</option>
					<option value="soppromotional">SOP Promotional</option>
				</select>
			</div>
			<button id="login-btn"><i class="fas fa-sign-in-alt"></i> Login</button>
		</div>
	</div>
	<div id="loader" title="Loading..." oncontextmenu="return false;" class="loader">
		<img src="img/logo.png">
	</div>
	<script>
		document.getElementById("index").addEventListener("click", function() {
			document.getElementById("loader").style.display = "inherit";
		});
	</script>
	<script>
		document.getElementById("login-btn").addEventListener("click", function() {
			var username = document.getElementById("username").value;
			var password = document.getElementById("password").value;
			var type = document.getElementById("type").value;
			if (username == "") {
				alert("Please input username.");
			}
			else if (password == "") {
				alert("Please input password.");
			}
			else if (type == "") {
				alert("Please select type.");
			}
			else {
				document.getElementById("loader").style.display = "inherit";
				$.ajax({
					url: "php/login.php",
					type: "post",
					data: {
						username: username,
						password: password,
						type: type,
					},
					success: function(response) {
						if (response == "success") {
							location.reload();
						}
						else {
							document.getElementById("loader").style.display = "none";
							alert(response);
						}
					}
				});
			}
		})
	</script>
</body>
</html>