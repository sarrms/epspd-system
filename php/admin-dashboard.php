<?php
date_default_timezone_set("Asia/Manila");
include "php/connect.php";
$username = $_COOKIE["admin"];
$select = "SELECT * FROM admin WHERE username='$username'";
$result = $connect -> query($select);
if ($result -> num_rows > 0) {
	while ($row = mysqli_fetch_array($result)) {
		$type = $row["type"];
	}
}
?>
<div class="main-grade-sheet">
</div>
<script>
	document.title = "Dashboard - <?php
	if ($type == "evaluation-process") {
		echo 'Evaluation Process to Diploma System';
	}
	else {
		echo 'SOP Promotional to Diploma System';
	}
	?>";
</script>
<script>
	document.getElementById("dashboard").classList.add("active");
	document.getElementById("subjects").classList.remove("active");
	document.getElementById("professors").classList.remove("active");
	document.getElementById("heads").classList.remove("active");
	document.getElementById("users").classList.remove("active");
</script>