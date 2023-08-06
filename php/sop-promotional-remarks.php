<?php
include "connect.php";

$course = $_POST["course"];
$schoolyear = $_POST["schoolYear"];
$studentnumber = $_POST["studentNumber"];
$remarks = $_POST["remarks"];

$select = "SELECT * FROM gradesheet WHERE studentnumber='$studentnumber' AND course=$course  AND schoolyear='$schoolyear'";
$result = $connect1 -> query($select);
if ($result -> num_rows > 0) {
	$update = "UPDATE gradesheet SET remarks='$remarks' WHERE studentnumber='$studentnumber' AND course=$course AND schoolyear='$schoolyear'";
	if (mysqli_query($connect1, $update)) {
		echo "success";
	}
	else {
		die("Error updating in gradesheet database.");
	}
}
else {
	$insert = "INSERT INTO gradesheet (studentnumber, remarks, course, schoolyear) VALUES ('$studentnumber', '$remarks', $course, '$schoolyear')";
	if (mysqli_query($connect1, $insert)) {
		echo "success";
	} 
	else {
		die("Error inserting in gradesheet database.");
	}
}
?>