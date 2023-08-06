<?php
//connect to database
include "connect.php";

//get value of username
if (isset($_POST["username"])) {
	$username = $_POST["username"];
}
else {
	$username = "";
}

//get value of password
if (isset($_POST["password"])) {
	$password = $_POST["password"];
}
else {
	$password = "";
}

//get value of login type
if (isset($_POST["type"])) {
	$type = $_POST["type"];
}
else {
	$type = "";
}

//check if username containts special character
if (preg_match("/[^a-zA-Z0-9-]/", $username)) {
	echo "Username containts special character.";
}
//check if password containts special character
else if (preg_match("/[^a-zA-Z0-9]/", $password)) {
	echo "Password containts special character.";
}
//check if login type containts special character
else if (preg_match("/[^a-zA-Z0-9]/", $type)) {
	echo "Login Type containts special character.";
}
//if username, password, login type does not containts special character
else {
	if ($type == "admin") {
		//select username to database
		$select = "SELECT * FROM admin WHERE username='$username' OR employeenumber='$username'";
		$result = $connect -> query($select);
		//if username is found
		if ($result -> num_rows > 0) {
			while ($row = mysqli_fetch_array($result)) {
				//get user info
				$dbusername = $row["username"];
				$dbpassword = $row["password"];

				//if inputted password is matched to database password
				if ($password == $dbpassword) {
					if (isset($_COOKIE["evaluation-process"])) {
						setcookie("evaluation-process", "", time() - 1, "/");
					}
					else if (isset($_COOKIE["sop-promotional"])) {
						setcookie("sop-promotional", "", time() - 1, "/");
					}
					else {
						setcookie("admin", $dbusername, time() + 86400, "/epspd-system");
					}
					echo "success";
				}
				//if inputted password does not match to the database password
				else {
					echo "Incorrect account password.";
				}
			}
		}
		//if username does not found
		else {
			echo "$username does not exist.";
		}
	}
	//if type is evaluation process
	else if ($type == "evaluationprocess") {
		//select username to database
		$select = "SELECT * FROM user WHERE username='$username' OR employeenumber='$username'";
		$result = $connect -> query($select);
		//if username is found
		if ($result -> num_rows > 0) {
			while ($row = mysqli_fetch_array($result)) {
				//get user info
				$dbusername = $row["username"];
				$dbpassword = $row["password"];

				//if inputted password is matched to database password
				if ($password == $dbpassword) {
					if (isset($_COOKIE["sop-promotional"])) {
						$cookie = $_COOKIE["sop-promotional"];
						if ($cookie == $dbusername) {
							setcookie("sop-promotional", "", time() - 1, "/");
							setcookie("evaluation-process", $dbusername, time() + 86400, "/epspd-system");
						}
					}
					else {
						setcookie("evaluation-process", $dbusername, time() + 86400, "/epspd-system");
					}
					echo "success";
				}
				//if inputted password does not match to the database password
				else {
					echo "Incorrect account password.";
				}
			}
		}
		//if username does not found
		else {
			echo "$username does not exist.";
		}
	}
	//if type is sop promotional
	else if ($type == "soppromotional") {
		$select = "SELECT * FROM user WHERE username='$username' OR employeenumber='$username'";
		$result = $connect1 -> query($select);
		if ($result -> num_rows > 0) {
			while ($row = mysqli_fetch_array($result)) {
				$dbusername = $row["username"];
				$dbpassword = $row["password"];

				if ($password == $dbpassword) {
					if (isset($_COOKIE["evaluation-process"])) {
						$cookie = $_COOKIE["evaluation-process"];
						if ($cookie == $dbusername) {
							setcookie("evaluation-process", "", time() - 1, "/");
							setcookie("sop-promotional", $dbusername, time() + 86400, "/epspd-system");
						}
					}
					else {
						setcookie("sop-promotional", $dbusername, time() + 86400, "/epspd-system");
					}
					echo "success";
				}
				else {
					echo "Incorrect account password.";
				}
			}
		}
		else {
			echo "Account does not exist.";
		}
	}
	//if type is not evaluation process or sop promotional
	else {
		echo "Invalid Login Type.";
	}
}
?>