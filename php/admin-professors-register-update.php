<?php
include "connect.php";

$id = $_POST["id"];
$prefix = $_POST["prefix"];
if (strpos($prefix, ".") == true) {
	$fixedprefix = ucfirst($prefix);
}
else {
	$fixedprefix = ucfirst($prefix) . ".";
}
$lastname = $_POST["lastname"];
$firstname = $_POST["firstname"];
$middlename = $_POST["middlename"];

$select = "SELECT * FROM professor WHERE prefix='$fixedprefix' AND lastname='$lastname' AND firstname='$firstname' AND middlename='$middlename'";
$result = $connect -> query($select);
if ($result -> num_rows > 0) {
	echo "Failed to update professor since there is no data changes.";
}
else {
	$select1 = "SELECT * FROM professor WHERE id=$id";
	$result1 = $connect -> query($select1);
	if ($result1 -> num_rows > 0) {
		$update = "UPDATE professor SET prefix='$fixedprefix', lastname='$lastname', firstname='$firstname', middlename='$middlename' WHERE id=$id";
		if (mysqli_query($connect, $update)) {
			echo "success";
		}
		else {
			echo "Error updating in professor database.";
		}
	}
	else {
		echo "Professor not found";
	}
}
?>