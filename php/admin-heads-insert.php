<?php
include "connect.php";

$name = $_POST["name"];
$type = $_POST["type"];

if ($type == "president" || $type == "registrar") {
	$select = "SELECT * FROM head ORDER BY id DESC LIMIT 1";
}
else if ($type == "dean") {
	$select = "SELECT * FROM dean ORDER BY id DESC LIMIT 1";
}
$result = $connect -> query($select);
if ($result -> num_rows > 0) {
	while ($row = mysqli_fetch_array($result)) {
		$id = $row["id"];
	}
}
$nextId = $id + 1;

if ($type == "president" || $type == "registrar") {
	$select = "SELECT * FROM head WHERE name='$name' AND position='$type'";
}
else if ($type == "dean") {
	$college = $_POST["college"];
	$select = "SELECT * FROM dean WHERE dean='$name' AND college='$college'";
}
$result = $connect -> query($select);
if ($result -> num_rows > 0) {
	echo "$name was already registered in the $type position.";
}
else {
	if ($type == "president" || $type == "registrar") {
		$insert = "INSERT INTO head VALUES ($nextId, '$name', '$type')";
	}
	else if ($type == "dean") {
		$insert = "INSERT INTO dean VALUES ($nextId, '$name', '$college')";
	}
	if (mysqli_query($connect, $insert)) {
		echo "success";
	}
	else {
		echo "Error inserting in head/dean database.";
	}
}
?>