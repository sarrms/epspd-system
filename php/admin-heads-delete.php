<?php
include "connect.php";

$id = $_POST["id"];
$type = $_POST["type"];

if ($type == "president" || $type == "registrar") {
	$select = "SELECT * FROM head WHERE id=$id AND position='$type'";
}
else if ($type == "dean") {
	$select = "SELECT * FROM dean WHERE id=$id";
}
$result = $connect -> query($select);
if ($result -> num_rows > 0) {
	if ($type == "president" || $type == "registrar") {
		$delete = "DELETE FROM head WHERE id=$id AND position='$type'";
	}
	else if ($type == "dean") {
		$delete = "DELETE FROM dean WHERE id=$id";
	}
	if (mysqli_query($connect, $delete)) {
		echo "success";
	}
	else {
		echo "Error deleting in professor database.";
	}
}
else {
	echo "Head not found.";
}
?>