<?php
include "connect.php";

$course = $_POST["course"];
$schoolyear = $_POST["schoolYear"];
$studentnumber = $_POST["studentNumber"];
$attendance = $_POST["numAttendance"];

$select = "SELECT * FROM gradesheet WHERE studentnumber='$studentnumber' AND course=$course  AND schoolyear='$schoolyear'";
$result = $connect1 -> query($select);
if ($result -> num_rows > 0) {
	$update = "UPDATE gradesheet SET attendance='$attendance' WHERE studentnumber='$studentnumber' AND course=$course AND schoolyear='$schoolyear'";
	if (mysqli_query($connect1, $update)) {
		echo "success";
	}
	else {
		die("Error updating in gradesheet database.");
	}
}
else {
	$insert = "INSERT INTO gradesheet (studentnumber, attendance, course, schoolyear) VALUES ('$studentnumber', '$attendance', $course, '$schoolyear')";
	if (mysqli_query($connect1, $insert)) {
		echo "success";
	} 
	else {
		die("Error inserting in gradesheet database.");
	}
}
?>