<option value="" selected hidden>Course</option>
<?php
include "connect.php";

if (isset($_POST["college"])) {
	$college = $_POST["college"];

	$select = "SELECT * FROM course WHERE college=$college";
	$result = $connect -> query($select);
	if ($result -> num_rows > 0) {
		while ($row = mysqli_fetch_array($result)) {
			$courseid = $row["id"];
			$courseacronym = $row["acronym"];
			$course = $row["course"];

			echo '<option value="' . $courseid . '">' . $course . ' (' . $courseacronym . ')' . '</option>';
		}
	}
}
else {
	echo "error";
}
?>