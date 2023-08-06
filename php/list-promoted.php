<?php
if (isset($_POST["rel"])) {
	include "connect.php";
}
else {
	include "php/connect.php";
}
?>
<link rel="stylesheet" href="css/list-promoted.css?v=1.0">
<div class="main-list-promoted">
	<div class="list-promoted-header">
		<select id="course">
			<?php
			if (!isset($_COOKIE["course"])) {
				echo '<option value="" selected hidden>Course</option>';
			}
			$select = "SELECT * FROM course ORDER BY id ASC";
			$result = $connect1 -> query($select);
			if ($result -> num_rows > 0) {
				while ($row = mysqli_fetch_array($result)) {
					$id = $row["id"];
					$course = $row["course"];

					if (isset($_COOKIE["course"])) {
						if ($id == $_COOKIE["course"]) {
							echo "<option value='$id' selected>$course</option>";
						}
						else {
							echo "<option value='$id'>$course</option>";
						}
					}
					else {
						echo "<option value='$id'>$course</option>";
					}
				}
			}
			?>
		</select>
		<select id="school-year">
			<?php
			if (!isset($_COOKIE["school-year"])) {
				echo '<option value="" selected hidden>School Year</option>';
			}
			$developmentyear = 2023;
			$currentyear = date("Y");
			for ($year=$currentyear; $year>=$developmentyear; $year--) {
				$schoolyear = $year-1 . "-" . $year;
				if (isset($_COOKIE["school-year"])) {
					if ($schoolyear == $_COOKIE["school-year"]) {
						echo "<option value='$schoolyear' selected>$schoolyear</option>";
					}
					else {
						echo "<option value='$schoolyear'>$schoolyear</option>";
					}
				}
				else {
					echo "<option value='$schoolyear'>$schoolyear</option>";
				}
			}
			?>
		</select>
		<button id="view-btn"><i class="fas fa-eye"></i> View</button>
	</div>
	<div class="list-promoted-option">
		<button id="print-btn"><i class="fas fa-print"></i> Print</button>
		<button id="export-btn"><i class="fas fa-print"></i> Export</button>
	</div>
	<div class="list-promoted-body">
		<?php
		if (isset($_COOKIE["course"]) && isset($_COOKIE["school-year"])) {
			$courseid = $_COOKIE["course"];
			$schoolyear = $_COOKIE["school-year"];

			//DISPLAY TABLE OF ALL PROMOTED STUDENTS
			$select = "SELECT * FROM gradesheet WHERE remarks='promoted' AND course=$courseid AND schoolyear='$schoolyear'";
			$result = $connect1 -> query($select);
			if ($result -> num_rows > 0) {
				$i = 0;
				$select1 = "SELECT * FROM course WHERE id=$courseid";
				$result1 = $connect1 -> query($select1);
				if ($result1 -> num_rows > 0) {
					while ($row1 = mysqli_fetch_array($result1)) {
						$course = $row1["course"];
					}
				}
				echo "<div class='row1'><span>College:</span> <span>Sample College</span></div>";
				echo "<div class='row2'><span>Course & Section:</span> <span>$course</span></div>";
				echo "<div class='row3'><span>Trainor:</span> <span>Sample Trainor</span></div>";
				echo "<div class='row4'><span>SOP 2nd Sem January - June 2014-2015 (June 20, 2015)</span></div>";
				echo "<table>";
					echo "<tr>";
						echo "<th></th>";
						echo "<th>Fullname</th>";
						echo "<th>M.I.</th>";
					echo "</tr>";
					while ($row = mysqli_fetch_array($result)) {
						$studentnumber = $row["studentnumber"];

						$select1 = "SELECT * FROM student WHERE studentnumber='$studentnumber'";
						$result1 = $connect1 -> query($select1);
						if ($result1 -> num_rows > 0) {
							while ($row1 = mysqli_fetch_array($result1)) {
								$lastname = $row1["lastname"];
								$firstname = $row1["firstname"];
								$middleinitial = substr($row1["middlename"], 0, 1);
							}
						}
						$i = $i + 1;

						echo "<tr>";
							echo "<td>$i.</td>";
							echo "<td>$lastname, $firstname</td>";
							echo "<td>$middleinitial</td>";
						echo "</tr>";
					}
				echo "</table>";
			}
		}
		?>
	</div>
</div>
<script>
	//Setting page name
	document.title = "List of Promoted- SOP Promotional to Certificate System";
</script>
<script>
	//Setting active sub navigation class name
	document.getElementById("promotional").classList.remove("active");
	document.getElementById("grade-sheet").classList.remove("active");
	document.getElementById("list-promoted").classList.add("active");
	document.getElementById("create-sop-diploma").classList.remove("active");
</script>
<script>
	document.getElementById("view-btn").addEventListener("click", function() {
		var course = document.getElementById("course").value;
		var sy = document.getElementById("school-year").value;
		if (course == "") {
			alert("Please select course.");
		}
		else if (sy == "") {
			alert("Please select school year.");
		}
		else {
			document.getElementById("loader").style.display = "inherit";
			$.ajax({
				url: "php/paper-grade-sheet.php",
				type: "post",
				data: {
					course: course,
					schoolYear: sy,
				},
				success: function(response) {
					var date = new Date();
					date.setDate(date.getDate() + 1);
					var expires = "; expires=" + date.toLocaleDateString();
					document.cookie = "course=" + course + expires + ";";
					document.cookie = "school-year=" + sy + expires + ";";
					location.reload();
				}
			});
		}
	});
</script>
<script>
	document.getElementById("print-btn").addEventListener("click", function() {
		window.print();
	});
</script>