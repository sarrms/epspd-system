<?php
include "connect.php";

$code = $_POST["code"];
$title = $_POST["title"];
$unitlec = number_format($_POST["unitlec"], 1);
$unitlab = number_format($_POST["unitlab"], 1);

$select = "SELECT * FROM subject ORDER BY id DESC LIMIT 1";
$result = $connect -> query($select);
if ($result -> num_rows > 0) {
	while ($row = mysqli_fetch_array($result)) {
		$id = $row["id"];
	}
}
$nextId = $id + 1;

$select = "SELECT * FROM subject WHERE code='$code'";
$result = $connect -> query($select);
if ($result -> num_rows > 0) {
	echo "Subject code was already exists.";
}
else {
	$insert = "INSERT INTO subject VALUES ($nextId, '$code', '$title', '$unitlec', '$unitlab')";
	if (mysqli_query($connect, $insert)) {
		$insert1 = "INSERT INTO coursesubject (college, course, subject, yearlevel, semester) VALUES (0, 0, $nextId, 0, 0)";
		if (mysqli_query($connect, $insert1)) {
			echo "success";
		}
		else {
			echo "Error inserting in coursesubject database.";
		}
	}
	else {
		echo "Error inserting in subject database.";
	}
}
?>