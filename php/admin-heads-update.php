<?php
include "connect.php";

$id = $_POST["id"];
$name = $_POST["name"];
$type = $_POST["type"];

if ($type == "president" || $type == "registrar") {
	$select = "SELECT * FROM head WHERE name='$name' AND position='$type'";
}
else if ($type == "dean") {
	$college = $_POST["college"];
	$select = "SELECT * FROM dean WHERE dean='$name' AND college=$college";
}
$result = $connect -> query($select);
if ($result -> num_rows > 0) {
	echo "Failed to update professor since there is no data changes.";
}
else {
	if ($type == "president" || $type == "registrar") {
		$select1 = "SELECT * FROM head WHERE id=$id";
	}
	else if ($type == "dean") {
		$select1 = "SELECT * FROM dean WHERE id=$id";
	}
	$result1 = $connect -> query($select1);
	if ($result1 -> num_rows > 0) {
		if ($type == "president" || $type == "registrar") {
			$update = "UPDATE head SET name='$name', position='$type' WHERE id=$id";
		}
		else if ($type == "dean") {
			$update = "UPDATE dean SET dean='$name', college='$college' WHERE id=$id";
		}
		if (mysqli_query($connect, $update)) {
			echo "success";
		}
		else {
			echo "Error updating in head/dean database.";
		}
	}
	else {
		echo "Head not found";
	}
}
?>