<?php
include "connect.php";

$select = "SELECT * FROM major ORDER BY id DESC LIMIT 1";
$result = $connect -> query($select);
if ($result -> num_rows > 0) {
	while ($row = mysqli_fetch_array($result)) {
		$id = $row["id"];
	}
}
$nextId = $id + 1;

$major = $_POST["major"];
$course = $_POST["course"];

$select = "SELECT * FROM major WHERE major='$major'";
$result = $connect -> query($select);
if ($result -> num_rows > 0) {
	echo "Major was already exists.";
}
else {
	$insert = "INSERT INTO major VALUES ($nextId, $course, '$major')";
	if (mysqli_query($connect, $insert)) {
		echo "success";
	}
	else {
		echo "Error inserting in major database.";
	}
}
?>