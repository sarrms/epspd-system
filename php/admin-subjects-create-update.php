<?php
include "connect.php";

$id = $_POST["id"];
$code = $_POST["code"];
$title = $_POST["title"];
$unitlec = number_format($_POST["unitlec"], 1);
$unitlab = number_format($_POST["unitlab"], 1);

$select = "SELECT * FROM subject WHERE code='$code' AND title='$title' AND unitlec='$unitlec' AND unitlab='$unitlab'";
$result = $connect -> query($select);
if ($result -> num_rows > 0) {
	echo "Failed to update subject since there is no data changes.";
}
else {
	$select1 = "SELECT * FROM subject WHERE id=$id";
	$result1 = $connect -> query($select1);
	if ($result1 -> num_rows > 0) {
		$update = "UPDATE subject SET code='$code', title='$title', unitlec='$unitlec', unitlab='$unitlab' WHERE id=$id";
		if (mysqli_query($connect, $update)) {
			echo "success";
		}
		else {
			echo "Error updating in subject database.";
		}
	}
	else {
		echo "Subject not found";
	}
}
?>