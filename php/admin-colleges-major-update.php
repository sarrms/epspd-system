<?php
include "connect.php";

$id = $_POST["id"];
$major = $_POST["major"];
$course = $_POST["course"];

$select = "SELECT * FROM major WHERE id=$id AND course=$course AND major='$major'";
$result = $connect -> query($select);
if ($result -> num_rows > 0) {
	echo "Failed to update since there is no data changes.";
}
else {
	$select1 = "SELECT * FROM major WHERE major='$major'";
	$result1 = $connect -> query($select1);
	if ($result1 -> num_rows > 0) {
		echo "Major was already exists.";
	}
	else {
		$update = "UPDATE major SET course=$course, major='$major' WHERE id=$id";
		if (mysqli_query($connect, $update)) {
			echo "success";
		}
		else {
			echo "Error updating in major database.";
		}
	}
}
?>