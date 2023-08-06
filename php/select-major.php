<?php
include "connect.php";

if (isset($_POST["course"])) {
	$course = $_POST["course"];

	$select = "SELECT * FROM major WHERE course=$course";
	$result = $connect -> query($select);
	if ($result -> num_rows > 0) {
		echo '<option value="" selected hidden>Major</option>';
		while ($row = mysqli_fetch_array($result)) {
			$majorid = $row["id"];
			$major = $row["major"];

			echo '<option value="' . $majorid . '">' . $major . '</option>';
		}
	}
	else {
		echo '<option value="" selected>none</option>';
	}
}
else {
	echo "error";
}
?>