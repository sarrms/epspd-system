<?php
date_default_timezone_set("Asia/Manila");
if (isset($_POST["rel"])) {
	include "connect.php";
}
else {
	include "php/connect.php";
}
?>
<link rel="stylesheet" href="css/grade-sheet.css?v=1.0">
<div class="main-grade-sheet">
	<div class="main-grade-sheet-header">
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
							echo '<option value="' . $id . '" selected>' . $course . '</option>';
						}
						else {
							echo '<option value="' . $id . '">' . $course . '</option>';
						}
					}
					else {
						echo '<option value="' . $id . '">' . $course . '</option>';
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
						echo '<option value="' . $schoolyear . '" selected>' . $schoolyear . '</option>';
					}
					else {
						echo '<option value="' . $schoolyear . '">' . $schoolyear . '</option>';
					}
				}
				else {
					echo '<option value="' . $schoolyear . '">' . $schoolyear . '</option>';
				}
			}
			?>
		</select>
		<button id="view-btn"><i class="fas fa-eye"></i> View</button>
	</div>
	<div class="grade-sheet-option">
		<button id="print-btn"><i class="fas fa-print"></i> Print</button>
		<button id="export-btn"><i class="fas fa-print"></i> Export</button>
	</div>
	<?php
	if(isset($_COOKIE["course"]) && isset($_COOKIE["school-year"])) {
		if (isset($_POST["rel"])) {
			include "paper-grade-sheet.php";
		}
		else {
			include "php/paper-grade-sheet.php";
		}
	}
	?>
</div>
<script>
	document.title = "Grade Sheet - SOP Promotional to Certificate System";
</script>
<script>
	document.getElementById("promotional").classList.remove("active");
	document.getElementById("grade-sheet").classList.add("active");
	document.getElementById("list-promoted").classList.remove("active");
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
	function getCurrentDateFormatted() {
		var currentDate = new Date();
		var year = currentDate.getFullYear();
		var month = String(currentDate.getMonth() + 1).padStart(2, '0');
		var day = String(currentDate.getDate()).padStart(2, '0');

		return year + "-" + month + "-" + day;
	}

	document.getElementById("print-btn").addEventListener("click", function() {
		if (confirm("Note! If there is data changes, make sure to reload the page first before printing so the data in the print is updated.")) {
			var defaultDate = getCurrentDateFormatted();
			var dateInput = window.prompt("Enter a date of graduation (yyyy-mm-dd):", defaultDate);
			var datePattern = /^\d{4}-\d{2}-\d{2}$/;
			if (dateInput !== null) {
				if (dateInput !== "") {
					if (datePattern.test(dateInput)) {
						var dateObj = new Date(dateInput);
						var options = { year: "numeric", month: "long", day: "numeric" };
						var formatter = new Intl.DateTimeFormat('en-US', options);
						var convertedDate = formatter.format(dateObj);
						document.getElementById("graduation-date").innerHTML = convertedDate;
						window.print();
					}
					else {
						alert("Invalid date format. Please use the format yyyy-mm-dd.");
					}
				}
				else {
					alert("Please enter date.");
				}
			}
		}
	});
</script>