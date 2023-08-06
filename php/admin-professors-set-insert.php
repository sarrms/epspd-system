<?php
include "connect.php";

$select = "SELECT * FROM subjectprofessor ORDER BY id DESC LIMIT 1";
$result = $connect -> query($select);
if ($result -> num_rows > 0) {
	while ($row = mysqli_fetch_array($result)) {
		$id = $row["id"];
	}
}
$nextId = $id + 1;

$subjectid = $_POST["subjectid"];
$profid = $_POST["profid"];

$select = "SELECT * FROM subjectprofessor WHERE subject=$subjectid AND professor=$profid";
$result = $connect -> query($select);
if ($result -> num_rows > 0) {
	echo "Professor was already added in this subject.";
}
else {
	$insert = "INSERT INTO subjectprofessor VALUES ($nextId, $subjectid, $profid)";
	if (mysqli_query($connect, $insert)) {
		echo "success";
	}
	else {
		echo "Error inserting in subjectprofessor database.";
	}
}
?>