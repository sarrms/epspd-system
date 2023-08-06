<?php
include "connect.php";

$id = $_POST["id"];
$acronym = $_POST["acronym"];
$college = $_POST["college"];

$select = "SELECT * FROM college WHERE id=$id AND acronym='$acronym' AND college='$college'";
$result = $connect -> query($select);
if ($result -> num_rows > 0) {
	echo "Failed to update college since there is no data changes.";
}
else {
	$select = "SELECT * FROM college WHERE college='$college'";
	$result = $connect -> query($select);
	if ($result -> num_rows > 0) {
		echo "College was already exists.";
	}
	else {
		$update = "UPDATE college SET acronym='$acronym', college='$college' WHERE id=$id";
		if (mysqli_query($connect, $update)) {
			echo "success";
		}
		else {
			echo "Error updating in college database.";
		}
	}
}
?>