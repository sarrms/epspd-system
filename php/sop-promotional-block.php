<?php
include "connect.php";

$block = $_POST["block"];
$course = $_POST["course"];
$schoolyear = $_POST["schoolYear"];
$studentnumber = $_POST["studentNumber"];
$grade = $_POST["blockGrade"];

$select = "SELECT * FROM gradesheet WHERE studentnumber='$studentnumber' AND course=$course  AND schoolyear='$schoolyear'";
$result = $connect1 -> query($select);
if ($result -> num_rows > 0) {
	$update = "UPDATE gradesheet SET $block='$grade' WHERE studentnumber='$studentnumber' AND course=$course AND schoolyear='$schoolyear'";
	if (mysqli_query($connect1, $update)) {
		echo "success";
	}
	else {
		die("Error updating in gradesheet database.");
	}
}
else {
	$insert = "INSERT INTO gradesheet (studentnumber, $block, course, schoolyear) VALUES ('$studentnumber', '$grade', $course, '$schoolyear')";
	if (mysqli_query($connect1, $insert)) {
		echo "success";
	} 
	else {
		die("Error inserting in gradesheet database.");
	}
}
?>