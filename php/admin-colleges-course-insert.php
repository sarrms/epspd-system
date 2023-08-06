<?php
include "connect.php";

$select = "SELECT * FROM course ORDER BY id DESC LIMIT 1";
$result = $connect -> query($select);
if ($result -> num_rows > 0) {
	while ($row = mysqli_fetch_array($result)) {
		$id = $row["id"];
	}
}
$nextId = $id + 1;

$acronym = $_POST["acronym"];
$course = $_POST["course"];
$college = $_POST["college"];

$select = "SELECT * FROM course WHERE course='$course'";
$result = $connect -> query($select);
if ($result -> num_rows > 0) {
	echo "Course was already exists.";
}
else {
	$insert = "INSERT INTO course VALUES ($nextId, '$acronym', '$course', $college)";
	if (mysqli_query($connect, $insert)) {
		echo "success";
	}
	else {
		echo "Error inserting in course database.";
	}
}
?>