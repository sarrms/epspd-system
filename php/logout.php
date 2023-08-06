<?php
include "connect.php";

if (isset($_COOKIE["admin"])) {
	setcookie("admin", "", time() - 3600, "/epspd-system");
	$process = "success";
}
else if (isset($_COOKIE["evaluation-process"])) {
	setcookie("evaluation-process", "", time() - 3600, "/epspd-system");
	$process = "success";
}
else if (isset($_COOKIE["sop-promotional"])) {
	setcookie("sop-promotional", "", time() - 3600, "/epspd-system");
	$process = "success";
}
else {
	echo "There was an error while logging out.";
}

if ($process == "success") {
	if (isset($_COOKIE["application-for-evaluation-file"])) {
		setcookie("application-for-evaluation-file", "", time() - 3600, "/epspd-system");
	}
	if (isset($_COOKIE["final-evaluation-result-form-file"])) {
		setcookie("final-evaluation-result-form-file", "", time() - 3600, "/epspd-system");
	}
	if (isset($_COOKIE["application-for-graduation-file"])) {
		setcookie("application-for-graduation-file", "", time() - 3600, "/epspd-system");
	}
	echo $process;
}
?>