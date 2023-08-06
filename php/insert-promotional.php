<?php
date_default_timezone_set("Asia/Manila");
include "connect.php";

$studentnumber = $_POST["student-number"];
$course = $_POST["course"];
$lastname = $_POST["last-name"];
$firstname = $_POST["first-name"];
$middlename = $_POST["middle-name"];
if ($_POST["age"] == "") {
	$currentDate = new DateTime();
	$inputbirthday = new DateTime($_POST["birthday"]);
	$ageInterval = date_diff($currentDate, $inputbirthday);
	$age = $ageInterval->y;
}
else {
	$age = $_POST["age"];
}
$address = $_POST["permanent-address"];
$email = $_POST["email-address"];
$contactnumber = $_POST["contact-number"];
$gender = $_POST["gender"];
$birthday = $_POST["birthday"];
$status = $_POST["status"];
$father = $_POST["father-name"];
$fatheroccupation = $_POST["father-occupation"];
$mother = $_POST["mother-name"];
$motheroccupation = $_POST["mother-occupation"];

$select = "SELECT * FROM student WHERE studentnumber='$studentnumber'";
$result = $connect1 -> query($select);
if ($result -> num_rows > 0) {
	echo "Student Number already registered.";
}
else {
	$insert = "INSERT INTO student (studentnumber, course, lastname, firstname, middlename, age, address, email, contactnumber, gender, birthday, status, father, fatheroccupation, mother, motheroccupation) VALUES ('$studentnumber', $course, '$lastname', '$firstname', '$middlename', $age, '$address', '$email', '$contactnumber', '$gender', '$birthday', '$status', '$father', '$fatheroccupation', '$mother', '$motheroccupation')";
	if (mysqli_query($connect1, $insert)) {
		echo "Student successfully promoted.";
	}
	else {
		die("Error inserting in student database.");
	}
}
?>