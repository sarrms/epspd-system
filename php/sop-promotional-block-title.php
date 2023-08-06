<?php
include "connect.php";

$block = $_POST["block"];
$course = $_POST["course"];
$schoolyear = $_POST["schoolYear"];
$title = $_POST["blockTitle"];

$select = "SELECT * FROM gsblocktitle WHERE course=$course  AND schoolyear='$schoolyear'";
$result = $connect1 -> query($select);
if ($result -> num_rows > 0) {
	$update = "UPDATE gsblocktitle SET $block='$title' WHERE course=$course AND schoolyear='$schoolyear'";
	if (mysqli_query($connect1, $update)) {
		echo "success";
	}
	else {
		die("Error updating in gsblocktitle database.");
	}
}
else {
	$insert = "INSERT INTO gsblocktitle ($block, course, schoolyear) VALUES ('$title', $course, '$schoolyear')";
	if (mysqli_query($connect1, $insert)) {
		echo "success";
	} 
	else {
		die("Error inserting in gsblocktitle database.");
	}
}
?>