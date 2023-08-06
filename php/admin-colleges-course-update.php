<?php
include "connect.php";

$id = $_POST["id"];
$acronym = $_POST["acronym"];
$course = $_POST["course"];
$college = $_POST["college"];

$select = "SELECT * FROM course WHERE id=$id AND acronym='$acronym' AND course='$course' AND college=$college";
$result = $connect -> query($select);
if ($result -> num_rows > 0) {
	echo "Failed to update course since there is no data changes.";
}
else {
	$select1 = "SELECT * FROM course WHERE course='$course'";
	$result1 = $connect -> query($select1);
	if ($result1 -> num_rows > 0) {
		echo "Course was already exists.";
	}
	else {
		$update = "UPDATE course SET acronym='$acronym', course='$course', college=$college WHERE id=$id";
		if (mysqli_query($connect, $update)) {
			echo "success";
		}
		else {
			echo "Error updating in course database.";
		}
	}
}
?>