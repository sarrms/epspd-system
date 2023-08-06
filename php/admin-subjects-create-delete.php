<?php
include "connect.php";

$id = $_POST["id"];
$select = "SELECT * FROM subject WHERE id=$id";
$result = $connect -> query($select);
if ($result -> num_rows > 0) {
	$delete = "DELETE FROM subject WHERE id=$id";
	if (mysqli_query($connect, $delete)) {
		$delete1 = "DELETE FROM coursesubject WHERE subject=$id";
		if (mysqli_query($connect, $delete1)) {
			echo "success";
		}
		else {
			echo "Error deleting in coursesubject database.";
		}
	}
	else {
		echo "Error deleting in subject database.";
	}
}
else {
	echo "Subject not found.";
}
?>