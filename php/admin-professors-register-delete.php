<?php
include "connect.php";

$id = $_POST["id"];
$select = "SELECT * FROM professor WHERE id=$id";
$result = $connect -> query($select);
if ($result -> num_rows > 0) {
	$delete = "DELETE FROM professor WHERE id=$id";
	if (mysqli_query($connect, $delete)) {
		$select1 = "SELECT * FROM subjectprofessor WHERE professor=$id";
		$result1 = $connect -> query($select1);
		if ($result1 -> num_rows > 0) {
			$delete1 = "DELETE FROM subjectprofessor WHERE professor=$id";
			if (mysqli_query($connect, $delete1)) {
				echo "success";
			}
			else {
				echo "Error deleting in subjectprofessor database.";
			}
		}
		else {
			echo "success";
		}
	}
	else {
		echo "Error deleting in professor database.";
	}
}
else {
	echo "Professor not found.";
}
?>