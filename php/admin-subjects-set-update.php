<?php
include "connect.php";

$subject = $_POST["subject"];
$college = $_POST["college"];
$course = $_POST["course"];
if ($course == "") {
	$newcourse = 0;
}
else {
	$newcourse = $course;
}
$yearlevel = $_POST["yearlevel"];
$semester = $_POST["semester"];

$select = "SELECT * FROM coursesubject WHERE college=$college AND course=$newcourse AND subject=$subject AND yearlevel=$yearlevel AND semester=$semester";
$result = $connect -> query($select);
if ($result -> num_rows > 0) {
	echo "Failed to set subject since there is no data changes.";
}
else {
	$select1 = "SELECT * FROM coursesubject WHERE subject=$subject";
	$result1 = $connect -> query($select1);
	if ($result1 -> num_rows > 0) {
		$update = "UPDATE coursesubject SET college=$college, course=$newcourse, yearlevel=$yearlevel, semester=$semester WHERE subject=$subject";
		if (mysqli_query($connect, $update)) {
			echo "success";
		}
		else {
			echo "Error updating in coursesubject database.";
		}
	}
	else {
		echo "Subject not found.";
	}
}
?>