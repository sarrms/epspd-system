<?php
include "connect.php";

$id = $_POST["id"];

$select = "SELECT * FROM college WHERE id=$id";
$result = $connect -> query($select);
if ($result -> num_rows > 0) {
	$delete = "DELETE FROM college WHERE id=$id";
	if (mysqli_query($connect, $delete)) {
		echo "success";
	}
	else {
		echo "Error deleting in college database.";
	}
}
else {
	echo "College not found.";
}
?>