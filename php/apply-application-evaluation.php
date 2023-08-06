<?php
include "connect.php";
require "../vendor/autoload.php";

use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;

$filename = $_COOKIE["application-for-evaluation-file"];
$spreadsheet = IOFactory::load("../uploads/application-for-evaluation/$filename");
$activeSheet = $spreadsheet->getActiveSheet();
?>

<style>
	body {
		background-color: #f0f2f5;
	}
	.paper-main-header {
		margin-top: -10px;
	}
</style>
<div class="apply-evaluation-main">
	<form id="apply-appforeval-form" method="post">
		<div class="apply-evaluation-header">Apply Application for Evaluation</div>
		<div class="apply-evaluation-body">
			<?php
			//COLLEGE
			$filecollege = $activeSheet->getCell("A1")->getValue();
			$select = "SELECT * FROM college WHERE id=$filecollege";
			$result = $connect -> query($select);
			if ($result -> num_rows > 0) {
				while ($row = mysqli_fetch_array($result)) {
					$collegeacronym = $row["acronym"];
					$college = $row["college"];

					echo "<input value='$college ($collegeacronym)' disabled>";
				}
			}
			//COURSE
			$filecourse = $activeSheet->getCell("B1")->getValue();
			$select = "SELECT * FROM course WHERE id=$filecourse";
			$result = $connect -> query($select);
			if ($result -> num_rows > 0) {
				while ($row = mysqli_fetch_array($result)) {
					$courseacronym = $row["acronym"];
					$course = $row["course"];

					echo "<input value='$course ($courseacronym)' disabled>";
				}
			}
			//MAJOR
			$filemajor = $activeSheet->getCell("C1")->getValue();
			if ($filemajor != "") {
				$select = "SELECT * FROM major WHERE id=$filemajor";
				$result = $connect -> query($select);
				if ($result -> num_rows > 0) {
					while ($row = mysqli_fetch_array($result)) {
						$major = $row["major"];

						echo "<input value='$major' disabled>";
					}
				}
			}
			?>
			<i class="input-icon fas fa-envelope"></i>
			<input name="email-address" placeholder="Email Address" autocomplete="off">
			<i class="input-icon fas fa-user"></i>
			<input name="student-number" placeholder="Student Number" autocomplete="off">
			<i title="Required" class="required-icon">*</i>
			<i class="input-icon fas fa-user"></i>
			<input name="last-name" placeholder="Last Name" autocomplete="off">
			<i title="Required" class="required-icon">*</i>
			<i class="input-icon fas fa-user"></i>
			<input name="first-name" placeholder="First Name" autocomplete="off">
			<i title="Required" class="required-icon">*</i>
			<i class="input-icon fas fa-user"></i>
			<input name="middle-name" placeholder="Middle Name" autocomplete="off">
			<i class="input-icon fas fa-phone"></i>
			<input name="contact-number" placeholder="Contact Number" autocomplete="off">
			<i class="input-icon fas fa-map-marked-alt"></i>
			<input name="permanent-address" placeholder="Permanent Address (House No., Street, Barangay, City/Municipality, Province)" autocomplete="off">
			<input type="date" name="birthday" title="Birthday">
			<i class="input-icon fas fa-map-marked-alt"></i>
			<input name="birth-place" placeholder="Birth Place (City, Province)" autocomplete="off">
			<i class="input-icon fas fa-user"></i>
			<input name="guardian-name" placeholder="Name of Guardian" autocomplete="off">
			<div class="course-subjects">
				<a id="add-enrolled-subject-btn" class="add-subject-btn"><i class="fas fa-plus-circle"></i> Add</a>
				<table id="course-subjects">
					<?php
					$select = "SELECT * FROM coursesubject WHERE yearlevel=4 AND semester=2";
					$result = $connect -> query($select);
					if ($result -> num_rows > 0) {
						while ($row = mysqli_fetch_array($result)) {
							$subjectid = $row["subject"];
							
							$select1 = "SELECT * FROM subject WHERE id=$subjectid";
							$result1 = $connect -> query($select1);
							if ($result1 -> num_rows > 0) {
								while ($row1 = mysqli_fetch_array($result1)) {
									$subjectid1 = $row1["id"];
									$subjectcode = $row1["code"];
									$subjecttitle = $row1["title"];
									
									echo "<tr>";
										echo '<td>
											<input type="checkbox" id="' . $subjectid1 . '" value="' . $subjectid1 . '" class="subject">
										</td>';
										echo '<td>
											<label for="' . $subjectid1 . '">' . $subjectcode . '</label>
										</td>';
										echo '<td>
											<label for="' . $subjectid1 . '">' . $subjecttitle . '</label>
										</td>';
										echo "<td>";
										echo '<select title="Professor" class="enrolled-subject-professor">';
											echo '<option value="" selected hidden>Professor</option>';
											$select2 = "SELECT * FROM subjectprofessor WHERE subject=$subjectid1";
											$result2 = $connect -> query($select2);
											if ($result2 -> num_rows > 0) {
												while ($row2 = mysqli_fetch_array($result2)) {
													$professorid = $row2["professor"];

													$select3 = "SELECT * FROM professor WHERE id=$professorid";
													$result3 = $connect -> query($select3);
													if ($result3 -> num_rows > 0) {
														while ($row3 = mysqli_fetch_array($result3)) {
															$professorid1 = $row3["id"];
															$professorprefix = $row3["prefix"];
															$professorlastname = $row3["lastname"];
															$professorfirstname = $row3["firstname"];
														}
													}
													echo "<option value='$professorid1'>$professorprefix $professorfirstname $professorlastname</option>";
												}
											}
											echo "</select>";
										echo "</td>";
									echo "</tr>";
								}
							}
						}
					}
					?>
				</table>
			</div>
			<div class="deficiency-verification-subjects">
				<a id="add-deficiency-verification-subject-btn" class="add-subject-btn"><i class="fas fa-plus-circle"></i> Add</a>
				<table id="deficiency-verification-subjects"></table>
			</div>
			<div class="lack-subjects">
				<a id="add-lack-subject-btn" class="add-subject-btn"><i class="fas fa-plus-circle"></i> Add</a>
				<table id="lack-subjects"></table>
			</div>
			<button id="apply-btn"><i class="fas fa-plus-circle"></i> Submit</button>
		</div>
	</form>
</div>
<script>
	document.getElementById("add-enrolled-subject-btn").addEventListener("click", function() {
		var newRow = document.createElement("tr");
		var cell = document.createElement("td");
		cell.setAttribute("colspan", "4");

		var select = document.createElement("select");
		select.classList.add("added-enrolled-subject");

		var blankoption = document.createElement("option");
		blankoption.textContent = "none";
		blankoption.value = "";
		blankoption.selected = true;
		select.appendChild(blankoption);

		$.ajax({
			url: "php/select-subject.php",
			type: "post",
			data: "",
			success: function(response) {
				var data = JSON.parse(response);
				var textContent = data.textContent;
				var optionValue = data.optionValue;

				for (var i=0; i<textContent.length; i++) {
					var option = document.createElement("option");
					option.textContent = textContent[i];
					option.value = optionValue[i];
					select.appendChild(option);
				}
				cell.appendChild(select);
				newRow.appendChild(cell);
				var table = document.getElementById("course-subjects");
				table.appendChild(newRow);
			}
		});
	});
</script>
<script>
	document.getElementById("add-deficiency-verification-subject-btn").addEventListener("click", function() {
		var newRow = document.createElement("tr");
		var cell = document.createElement("td");
		cell.setAttribute("colspan", "4");

		var select = document.createElement("select");
		select.classList.add("added-deficiency-verification-subject");

		var blankoption = document.createElement("option");
		blankoption.textContent = "none";
		blankoption.value = "";
		blankoption.selected = true;
		select.appendChild(blankoption);
		
		$.ajax({
			url: "php/select-subject.php",
			type: "post",
			data: "",
			success: function(response) {
				var data = JSON.parse(response);
				var textContent = data.textContent;
				var optionValue = data.optionValue;

				for (var i=0; i<textContent.length; i++) {
					var option = document.createElement("option");
					option.textContent = textContent[i];
					option.value = optionValue[i];
					select.appendChild(option);
				}
				cell.appendChild(select);
				newRow.appendChild(cell);
				var table = document.getElementById("deficiency-verification-subjects");
				table.appendChild(newRow);
			}
		});
	});
</script>
<script>
	document.getElementById("add-lack-subject-btn").addEventListener("click", function() {
		var newRow = document.createElement("tr");
		var cell = document.createElement("td");
		cell.setAttribute("colspan", "4");

		var select = document.createElement("select");
		select.classList.add("added-lack-subject");

		var blankoption = document.createElement("option");
		blankoption.textContent = "none";
		blankoption.value = "";
		blankoption.selected = true;
		select.appendChild(blankoption);
		
		$.ajax({
			url: "php/select-subject.php",
			type: "post",
			data: "",
			success: function(response) {
				var data = JSON.parse(response);
				var textContent = data.textContent;
				var optionValue = data.optionValue;

				for (var i=0; i<textContent.length; i++) {
					var option = document.createElement("option");
					option.textContent = textContent[i];
					option.value = optionValue[i];
					select.appendChild(option);
				}
				cell.appendChild(select);
				newRow.appendChild(cell);
				var table = document.getElementById("lack-subjects");
				table.appendChild(newRow);
			}
		});
	});
</script>
<script>
	$(document).ready(function() {
		$("#apply-btn").on("click", function(event) {
			event.preventDefault();
			document.getElementById("loader").style.display = "inherit";

			var formData = new FormData($("#apply-appforeval-form")[0]);

			var subject = document.getElementsByClassName("subject");
			for (let i=0; i<subject.length; i++) {
				if (subject[i].checked) {
					formData.append("subject[]", subject[i].value);
				}
			}
			var enrolledSubProf = document.getElementsByClassName("enrolled-subject-professor");
			for (let i=0; i<enrolledSubProf.length; i++) {
				formData.append("enrolled-subject-professor[]", enrolledSubProf[i].value);
			}

			var addedEnSub = document.getElementsByClassName("added-enrolled-subject");
			for (let i=0; i<addedEnSub.length; i++) {
				formData.append("added-enrolled-subject[]", addedEnSub[i].value);
			}

			var addedDefVerSub = document.getElementsByClassName("added-deficiency-verification-subject");
			for (let i=0; i<addedDefVerSub.length; i++) {
				formData.append("added-deficiency-verification-subject[]", addedDefVerSub[i].value);
			}

			var addedLackSub = document.getElementsByClassName("added-lack-subject");
			for (let i=0; i<addedLackSub.length; i++) {
				formData.append("added-lack-subject[]", addedLackSub[i].value);
			}

			$.ajax({
				url: "php/apply-appforeval.php",
				type: "post",
				data: formData,
				processData: false,
				contentType: false,
				success: function(response) {
					document.getElementById("loader").style.display = "none";
					alert(response);
				}
			});
		});
	});
</script>