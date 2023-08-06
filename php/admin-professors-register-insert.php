<?php
include "connect.php";

$select = "SELECT * FROM professor ORDER BY id DESC LIMIT 1";
$result = $connect -> query($select);
if ($result -> num_rows > 0) {
	while ($row = mysqli_fetch_array($result)) {
		$id = $row["id"];
	}
}
$nextId = $id + 1;

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
	echo "Professor was already registered.";
}
else {
	$insert = "INSERT INTO professor VALUES ($nextId, '$fixedprefix', '$lastname', '$firstname', '$middlename')";
	if (mysqli_query($connect, $insert)) {
		echo "success";
	}
	else {
		echo "Error inserting in professor database.";
	}
}
?>