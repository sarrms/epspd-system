<?php
include "connect.php";

$id = $_POST["id"];

$select = "SELECT * FROM course WHERE id=$id";
$result = $connect -> query($select);
if ($result -> num_rows > 0) {
	$delete = "DELETE FROM course WHERE id=$id";
	if (mysqli_query($connect, $delete)) {
		echo "success";
	}
	else {
		echo "Error deleting in course database.";
	}
}
else {
	echo "Course not found.";
}
?>