<?php
if (isset($_POST["rel"])) {
	include "connect.php";
}
else {
	include "php/connect.php";
}
?>
<link rel="stylesheet" href="css/sop-diploma.css?v=1.0">
<div class="main-diploma">
	<div class="diploma-header">
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
	<div class="diploma-option">
		<button id="print-btn"><i class="fas fa-print"></i> Print</button>
		<button id="export-btn"><i class="fas fa-print"></i> Export</button>
	</div>
</div>
<script>
	document.title = "Create Diploma - SOP Promotional to Certificate System";
</script>
<script>
	document.getElementById("promotional").classList.remove("active");
	document.getElementById("grade-sheet").classList.remove("active");
	document.getElementById("list-promoted").classList.remove("active");
	document.getElementById("create-sop-diploma").classList.add("active");
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