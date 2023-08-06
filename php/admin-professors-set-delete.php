<?php
include "connect.php";

$subjectid = $_POST["subjectid"];
$profid = $_POST["profid"];

$select = "SELECT * FROM subjectprofessor WHERE subject=$subjectid AND professor=$profid";
$result = $connect -> query($select);
if ($result -> num_rows > 0) {
	$delete = "DELETE FROM subjectprofessor WHERE subject=$subjectid AND professor=$profid";
	if (mysqli_query($connect, $delete)) {
		echo "success";
	}
	else {
		echo "Error deleting in subjectprofessor database.";
	}
}
else {
	echo "There was an error occured while selecting subject and professor.";
}
?>