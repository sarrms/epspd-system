<?php
include "connect.php";

$select = "SELECT * FROM college ORDER BY id DESC LIMIT 1";
$result = $connect -> query($select);
if ($result -> num_rows > 0) {
	while ($row = mysqli_fetch_array($result)) {
		$id = $row["id"];
	}
}
$nextId = $id + 1;

$acronym = $_POST["acronym"];
$college = $_POST["college"];

$select = "SELECT * FROM college WHERE college='$college'";
$result = $connect -> query($select);
if ($result -> num_rows > 0) {
	echo "College was already exists.";
}
else {
	$insert = "INSERT INTO college VALUES ($nextId, '$acronym', '$college')";
	if (mysqli_query($connect, $insert)) {
		echo "success";
	}
	else {
		echo "Error inserting in college database.";
	}
}
?>