<?php
include "connect.php";

if(isset($_COOKIE["course"]) && isset($_COOKIE["school-year"])) {
	$course = $_COOKIE["course"];
	$schoolYear = $_COOKIE["school-year"];
}
else {
	$course = $_POST["course"];
	$schoolYear = $_POST["schoolYear"];
}
?>
<div class="paper-report">
	<?php
	$select = "SELECT * FROM gradesheet WHERE course=$course AND schoolyear='$schoolYear' AND remarks='promoted'";
	$result = $connect1 -> query($select);
	if ($result -> num_rows > 0) {
		$promoted = mysqli_num_rows($result);
	}
	else {
		$promoted = 0;
	}
	echo "<span>Promoted: $promoted</span>";

	$select = "SELECT * FROM gradesheet WHERE course=$course AND schoolyear='$schoolYear' AND remarks='retained'";
	$result = $connect1 -> query($select);
	if ($result -> num_rows > 0) {
		$retained = mysqli_num_rows($result);
	}
	else {
		$retained = 0;
	}
	echo "<span>Retained: $retained</span>";
	?>
</div>
<div class="grade-sheet-header">
	<img src="img/earist-manila-logo.png" class="earist-manila-logo">
	<span>Republic of the Philippines</span>
	<span>Eulogio "Amang" Rodriguez</span>
	<span>Institute of Science and Technology</span>
	<span>Nagtahan, Sampaloc, Manila</span>
	<span>Special Opportunity Program</span>
	<span>Report of Promotions</span>
	<img src="img/lungsod-ng-maynila-pilipinas-logo.png" class="lungsod-ng-maynila-pilipinas-logo">
	<span>Graduation: <h id="graduation-date"></h></span>
	<table>
		<tr>
			<th>College: College of Industrial Technology</th>
			<th>Term: 1st Semester</th>
		</tr>
		<tr>
			<th>Course & Section: Electrical Installation and Maintenance</th>
			<th>School Year: 2014-2015</th>
		</tr>
	</table>
</div>
<table id="grade-sheet-body" class="grade-sheet-body">
	<tr>
		<th rowspan="2">No.</th>
		<th rowspan="2">
			<span>Full Name</span>
			<span>Surname, Given Name Middle Name</span>
		</th>
		<th rowspan="2">M.I.</th>
		<th rowspan="2">Student No.</th>
		<th rowspan="2">City Address</th>
		<th rowspan="2">Age</th>
		<th rowspan="2">Date of Birth</th>
		<th rowspan="2">Gender</th>
		<th rowspan="2">Total No. of Attendance</th>
		<th colspan="6">Unit Course/Blocks</th>
		<th rowspan="2">
			<span>Promoted</span>
			<span>or</span>
			<span>Retained</span>
		</th>
	</tr>
	<tr>
		<?php
		$select = "SELECT * FROM gsblocktitle WHERE course=$course AND schoolyear='$schoolYear'";
		$result = $connect1 -> query($select);
		if ($result -> num_rows > 0) {
			while ($row = mysqli_fetch_array($result)) {
				$block1title = $row["block1"];
				$block2title = $row["block2"];
				$block3title = $row["block3"];
				$block4title = $row["block4"];
				$block5title = $row["block5"];
				$block6title = $row["block6"];

				echo '<th><input value="' . $block1title . '" class="block1-title"></th>';
				echo '<th><input value="' . $block2title . '" class="block2-title"></th>';
				echo '<th><input value="' . $block3title . '" class="block3-title"></th>';
				echo '<th><input value="' . $block4title . '" class="block4-title"></th>';
				echo '<th><input value="' . $block5title . '" class="block5-title"></th>';
				echo '<th><input value="' . $block6title . '" class="block6-title"></th>';
			}
		}
		else {
			echo '<th><input class="block1-title"></th>';
			echo '<th><input class="block2-title"></th>';
			echo '<th><input class="block3-title"></th>';
			echo '<th><input class="block4-title"></th>';
			echo '<th><input class="block5-title"></th>';
			echo '<th><input class="block6-title"></th>';
		}
		?>
	</tr>
	<tr>
		<?php
		$select = "SELECT * FROM student WHERE course=$course ORDER BY lastname, firstname, middlename LIMIT 20";
		$result = $connect1 -> query($select);
		if ($result -> num_rows > 0) {
			$i = 0;
			while ($row = mysqli_fetch_array($result)) {
				$i = $i + 1;
				$studentnumber = $row["studentnumber"];
				$lastname = strtoupper($row["lastname"]);
				$firstname = ucwords(strtolower($row["firstname"]));
				$middlename = ucwords(strtolower($row["middlename"]));
				$address = ucwords(strtolower($row["address"]));
				$age = $row["age"];
				$birthday = $row["birthday"];
				$gender = $row["gender"];

				echo "<tr>";
					echo "<td>$i</td>";
					echo "<td>$lastname, $firstname $middlename</td>";
					echo "<td>" . substr($middlename, 0, 1) . ".</td>";
					echo '<td><input value="' . $studentnumber . '" class="student-number" disabled></td>';
					echo "<td>$address</td>";
					echo "<td>$age</td>";
					echo "<td>" . date("m-d-y", strtotime($birthday)) . "</td>";
					echo "<td>$gender</td>";
					echo "<td>";
					$select1 = "SELECT * FROM gradesheet WHERE studentnumber='$studentnumber' AND course=$course";
					$result1 = $connect1 -> query($select1);
					if ($result1 -> num_rows > 0) {
						while ($row1 = mysqli_fetch_array($result1)) {
							$attendance = $row1["attendance"];

							if ($attendance == "") {
								echo '<input type="number" value="' . $attendance . '" class="attendance">';
							}
							else {
								echo '<input type="number" value="' . $attendance . '" class="attendance submitted">';
							}
						}
					}
					else {
						echo '<input type="number" value="" class="attendance">';
					}
					echo "</td>";
					echo "<td>";
					$select1 = "SELECT * FROM gradesheet WHERE studentnumber='$studentnumber' AND course=$course";
					$result1 = $connect1 -> query($select1);
					if ($result1 -> num_rows > 0) {
						while ($row1 = mysqli_fetch_array($result1)) {
							$block1 = $row1["block1"];

							if ($block1 == "") {
								echo '<input type="number" value="' . $block1 . '" class="block1">';
							}
							else {
								echo '<input type="number" value="' . $block1 . '" class="block1 submitted">';
							}
						}
					}
					else {
						echo '<input type="number" value="" class="block1">';
					}
					echo "</td>";
					echo "<td>";
					$select1 = "SELECT * FROM gradesheet WHERE studentnumber='$studentnumber' AND course=$course";
					$result1 = $connect1 -> query($select1);
					if ($result1 -> num_rows > 0) {
						while ($row1 = mysqli_fetch_array($result1)) {
							$block2 = $row1["block2"];

							if ($block2 == "") {
								echo '<input type="number" value="' . $block2 . '" class="block2">';
							}
							else {
								echo '<input type="number" value="' . $block2 . '" class="block2 submitted">';
							}
						}
					}
					else {
						echo '<input type="number" value="" class="block2">';
					}
					echo "</td>";
					echo "<td>";
					$select1 = "SELECT * FROM gradesheet WHERE studentnumber='$studentnumber' AND course=$course";
					$result1 = $connect1 -> query($select1);
					if ($result1 -> num_rows > 0) {
						while ($row1 = mysqli_fetch_array($result1)) {
							$block3 = $row1["block3"];

							if ($block3 == "") {
								echo '<input type="number" value="' . $block3 . '" class="block3">';
							}
							else {
								echo '<input type="number" value="' . $block3 . '" class="block3 submitted">';
							}
						}
					}
					else {
						echo '<input type="number" value="" class="block3">';
					}
					echo "</td>";
					echo "<td>";
					$select1 = "SELECT * FROM gradesheet WHERE studentnumber='$studentnumber' AND course=$course";
					$result1 = $connect1 -> query($select1);
					if ($result1 -> num_rows > 0) {
						while ($row1 = mysqli_fetch_array($result1)) {
							$block4 = $row1["block4"];

							if ($block4 == "") {
								echo '<input type="number" value="' . $block4 . '" class="block4">';
							}
							else {
								echo '<input type="number" value="' . $block4 . '" class="block4 submitted">';
							}
						}
					}
					else {
						echo '<input type="number" value="" class="block4">';
					}
					echo "</td>";
					echo "<td>";
					$select1 = "SELECT * FROM gradesheet WHERE studentnumber='$studentnumber' AND course=$course";
					$result1 = $connect1 -> query($select1);
					if ($result1 -> num_rows > 0) {
						while ($row1 = mysqli_fetch_array($result1)) {
							$block5 = $row1["block5"];

							if ($block5 == "") {
								echo '<input type="number" value="' . $block5 . '" class="block5">';
							}
							else {
								echo '<input type="number" value="' . $block5 . '" class="block5 submitted">';
							}
						}
					}
					else {
						echo '<input type="number" value="" class="block5">';
					}
					echo "</td>";
					echo "<td>";
					$select1 = "SELECT * FROM gradesheet WHERE studentnumber='$studentnumber' AND course=$course";
					$result1 = $connect1 -> query($select1);
					if ($result1 -> num_rows > 0) {
						while ($row1 = mysqli_fetch_array($result1)) {
							$block6 = $row1["block6"];

							if ($block6 == "") {
								echo '<input type="number" value="' . $block6 . '" class="block6">';
							}
							else {
								echo '<input type="number" value="' . $block6 . '" class="block6 submitted">';
							}
						}
					}
					else {
						echo '<input type="number" value="" class="block6">';
					}
					echo "</td>";
					?>
					<td>
						<select class="remarks">
							<?php
							$select1 = "SELECT * FROM gradesheet WHERE studentnumber='$studentnumber' AND course=$course";
							$result1 = $connect1 -> query($select1);
							if ($result1 -> num_rows > 0) {
								while ($row1 = mysqli_fetch_array($result1)) {
									$remarks = $row1["remarks"];

									if ($remarks == "") {
										echo '<option value="" selected></option>';
										echo '<option value="promoted">Promoted</option>';
										echo '<option value="retained">Retained</option>';
									}
									else {
										if ($remarks == "promoted") {
											echo '<option value="" selected></option>';
											echo '<option value="promoted" selected>Promoted</option>';
											echo '<option value="retained">Retained</option>';
										}
										else {
											echo '<option value="" selected></option>';
											echo '<option value="promoted">Promoted</option>';
											echo '<option value="retained" selected>Retained</option>';
										}
									}
								}
							}
							else {
								echo '<option value="" selected></option>';
								echo '<option value="promoted">Promoted</option>';
								echo '<option value="retained">Retained</option>';
							}
							echo "</td>";
							?>
						</select>
					</td><?php
				echo "</tr>";
			}
		}
		else {
			echo '<td colspan="16">No enrolled students.</td>';
		}
		?>
	</tr>
</table>
<table class="grade-sheet-footer">
	<tr>
		<td>
			<?php
			$select = "SELECT * FROM head WHERE position='registrar'";
			$result = $connect -> query($select);
			if ($result -> num_rows > 0) {
				while ($row = mysqli_fetch_array($result)) {
					$registrar = $row["name"];

					echo "<span>$registrar</span>";		
				}
			}
			?>
		</td>
		<td>
			<span>Giovanni L. Ahunin</span>
		</td>
		<td>
			<span>Rolf Irwin C. Dangla Cruz</span>
		</td>
	</tr>
	<tr>
		<td>Registrar</td>
		<td>Dean</td>
		<td>Trainor</td>
		<td>
			<?php
			$promotedMale = 0;
			$promotedFemale = 0;
			$select = "SELECT * FROM gradesheet WHERE course=$course AND schoolyear='$schoolYear' AND remarks='promoted'";
			$result = $connect1 -> query($select);
			if ($result -> num_rows > 0) {
				while ($row = mysqli_fetch_array($result)) {
					$studentnumber = $row["studentnumber"];

					$select1 = "SELECT * FROM student WHERE studentnumber='$studentnumber'";
					$result1 = $connect1 -> query($select1);
					if ($result1 -> num_rows > 0) {
						while ($row1 = mysqli_fetch_array($result1)) {
							$gender = $row1["gender"];

							if ($gender == "M") {
								$promotedMale = $promotedMale + 1;
							}
							else {
								$promotedFemale = $promotedFemale + 1;
							}
						}
					}
				}
			}

			$retainedMale = 0;
			$retainedFemale = 0;
			$select = "SELECT * FROM gradesheet WHERE course=$course AND schoolyear='$schoolYear' AND remarks='retained'";
			$result = $connect1 -> query($select);
			if ($result -> num_rows > 0) {
				while ($row = mysqli_fetch_array($result)) {
					$studentnumber = $row["studentnumber"];

					$select1 = "SELECT * FROM student WHERE studentnumber='$studentnumber'";
					$result1 = $connect1 -> query($select1);
					if ($result1 -> num_rows > 0) {
						while ($row1 = mysqli_fetch_array($result1)) {
							$gender = $row1["gender"];

							if ($gender == "M") {
								$retainedMale = $retainedMale + 1;
							}
							else {
								$retainedFemale = $retainedFemale + 1;
							}
						}
					}
				}
			}

			$totalPromoted = $promotedMale + $promotedFemale;
			$totalRetained = $retainedMale + $retainedFemale;
			$totalMale = $promotedMale + $retainedMale;
			$totalFemale = $promotedFemale + $retainedFemale;
			$total = $totalMale + $totalFemale;
			?>
			<table>
				<tr>
					<td>Summary:</td>
					<td>Male</td>
					<td>Female</td>
					<td>Total</td>
				</tr>
				<tr>
					<td>Promoted</td>
					<td><?php echo $promotedMale; ?></td>
					<td><?php echo $promotedFemale; ?></td>
					<td><?php echo $totalPromoted; ?></td>
				</tr>
				<tr>
					<td>Retained</td>
					<td><?php echo $retainedMale; ?></td>
					<td><?php echo $retainedFemale; ?></td>
					<td><?php echo $totalRetained; ?></td>
				</tr>
				<tr>
					<td>Total</td>
					<td><?php echo $totalMale; ?></td>
					<td><?php echo $totalFemale; ?></td>
					<td><?php echo $total; ?></td>
				</tr>
			</table>
		</td>
	</tr>
</table>
<script>
	var block1title = document.getElementsByClassName("block1-title");
	for (let i=0; i<block1title.length; i++) {
		block1title[i].addEventListener("change", function() {
			var course = document.getElementById("course").value;
			var schoolYear = document.getElementById("school-year").value;
			var blockTitle = block1title[i].value;
			$.ajax({
				url: "php/sop-promotional-block-title.php",
				type: "post",
				data: {
					block: "block1",
					course: course,
					schoolYear: schoolYear,
					blockTitle: blockTitle,
				},
				success: function(response) {
					if (response != "success") {
						alert(response);
					}
				}
			});
		});
	}
</script>
<script>
	var block2title = document.getElementsByClassName("block2-title");
	for (let i=0; i<block2title.length; i++) {
		block2title[i].addEventListener("change", function() {
			var course = document.getElementById("course").value;
			var schoolYear = document.getElementById("school-year").value;
			var blockTitle = block2title[i].value;
			$.ajax({
				url: "php/sop-promotional-block-title.php",
				type: "post",
				data: {
					block: "block2",
					course: course,
					schoolYear: schoolYear,
					blockTitle: blockTitle,
				},
				success: function(response) {
					if (response != "success") {
						alert(response);
					}
				}
			});
		});
	}
</script>
<script>
	var block3title = document.getElementsByClassName("block3-title");
	for (let i=0; i<block3title.length; i++) {
		block3title[i].addEventListener("change", function() {
			var course = document.getElementById("course").value;
			var schoolYear = document.getElementById("school-year").value;
			var blockTitle = block3title[i].value;
			$.ajax({
				url: "php/sop-promotional-block-title.php",
				type: "post",
				data: {
					block: "block3",
					course: course,
					schoolYear: schoolYear,
					blockTitle: blockTitle,
				},
				success: function(response) {
					if (response != "success") {
						alert(response);
					}
				}
			});
		});
	}
</script>
<script>
	var block4title = document.getElementsByClassName("block4-title");
	for (let i=0; i<block4title.length; i++) {
		block4title[i].addEventListener("change", function() {
			var course = document.getElementById("course").value;
			var schoolYear = document.getElementById("school-year").value;
			var blockTitle = block4title[i].value;
			$.ajax({
				url: "php/sop-promotional-block-title.php",
				type: "post",
				data: {
					block: "block4",
					course: course,
					schoolYear: schoolYear,
					blockTitle: blockTitle,
				},
				success: function(response) {
					if (response != "success") {
						alert(response);
					}
				}
			});
		});
	}
</script>
<script>
	var block5title = document.getElementsByClassName("block5-title");
	for (let i=0; i<block5title.length; i++) {
		block5title[i].addEventListener("change", function() {
			var course = document.getElementById("course").value;
			var schoolYear = document.getElementById("school-year").value;
			var blockTitle = block5title[i].value;
			$.ajax({
				url: "php/sop-promotional-block-title.php",
				type: "post",
				data: {
					block: "block5",
					course: course,
					schoolYear: schoolYear,
					blockTitle: blockTitle,
				},
				success: function(response) {
					if (response != "success") {
						alert(response);
					}
				}
			});
		});
	}
</script>
<script>
	var block6title = document.getElementsByClassName("block6-title");
	for (let i=0; i<block6title.length; i++) {
		block6title[i].addEventListener("change", function() {
			var course = document.getElementById("course").value;
			var schoolYear = document.getElementById("school-year").value;
			var blockTitle = block6title[i].value;
			$.ajax({
				url: "php/sop-promotional-block-title.php",
				type: "post",
				data: {
					block: "block6",
					course: course,
					schoolYear: schoolYear,
					blockTitle: blockTitle,
				},
				success: function(response) {
					if (response != "success") {
						alert(response);
					}
				}
			});
		});
	}
</script>
<script>
	var attendance = document.getElementsByClassName("attendance");
	for (let i=0; i<attendance.length; i++) {
		attendance[i].addEventListener("change", function() {
			var course = document.getElementById("course").value;
			var schoolYear = document.getElementById("school-year").value;
			var studentNumber = document.getElementsByClassName("student-number")[i].value;
			var numAttendance = attendance[i].value;
			if (numAttendance < 0) {
				alert("You cannot input value that is less than 0.");
			}
			else {
				$.ajax({
					url: "php/sop-promotional-attendance.php",
					type: "post",
					data: {
						course: course,
						schoolYear: schoolYear,
						studentNumber: studentNumber,
						numAttendance: numAttendance,
					},
					success: function(response) {
						if (response == "success") {
							if (numAttendance == "") {
								attendance[i].classList.remove("submitted");
							}
							else {
								attendance[i].classList.add("submitted");
							}
						}
						else {
							alert(response);
						}
					}
				});
			}
		});
	}
</script>
<script>
	var block1 = document.getElementsByClassName("block1");
	for (let i=0; i<block1.length; i++) {
		block1[i].addEventListener("change", function() {
			var course = document.getElementById("course").value;
			var schoolYear = document.getElementById("school-year").value;
			var studentNumber = document.getElementsByClassName("student-number")[i].value;
			var blockGrade = block1[i].value;
			if (blockGrade < 0) {
				alert("You cannot input value that is less than 0.");
			}
			else {
				$.ajax({
					url: "php/sop-promotional-block.php",
					type: "post",
					data: {
						block: "block1",
						course: course,
						schoolYear: schoolYear,
						studentNumber: studentNumber,
						blockGrade: blockGrade,
					},
					success: function(response) {
						if (response == "success") {
							if (blockGrade == "") {
								block1[i].classList.remove("submitted");
							}
							else {
								block1[i].classList.add("submitted");
							}
						}
						else {
							alert(response);
						}
					}
				});
			}
		});
	}
</script>
<script>
	var block2 = document.getElementsByClassName("block2");
	for (let i=0; i<block2.length; i++) {
		block2[i].addEventListener("change", function() {
			var course = document.getElementById("course").value;
			var schoolYear = document.getElementById("school-year").value;
			var studentNumber = document.getElementsByClassName("student-number")[i].value;
			var blockGrade = block2[i].value;
			if (blockGrade < 0) {
				alert("You cannot input value that is less than 0.");
			}
			else {
				$.ajax({
					url: "php/sop-promotional-block.php",
					type: "post",
					data: {
						block: "block2",
						course: course,
						schoolYear: schoolYear,
						studentNumber: studentNumber,
						blockGrade: blockGrade,
					},
					success: function(response) {
						if (response == "success") {
							if (blockGrade == "") {
								block2[i].classList.remove("submitted");
							}
							else {
								block2[i].classList.add("submitted");
							}
						}
						else {
							alert(response);
						}
					}
				});
			}
		});
	}
</script>
<script>
	var block3 = document.getElementsByClassName("block3");
	for (let i=0; i<block3.length; i++) {
		block3[i].addEventListener("change", function() {
			var course = document.getElementById("course").value;
			var schoolYear = document.getElementById("school-year").value;
			var studentNumber = document.getElementsByClassName("student-number")[i].value;
			var blockGrade = block3[i].value;
			if (blockGrade < 0) {
				alert("You cannot input value that is less than 0.");
			}
			else {
				$.ajax({
					url: "php/sop-promotional-block.php",
					type: "post",
					data: {
						block: "block3",
						course: course,
						schoolYear: schoolYear,
						studentNumber: studentNumber,
						blockGrade: blockGrade,
					},
					success: function(response) {
						if (response == "success") {
							if (blockGrade == "") {
								block3[i].classList.remove("submitted");
							}
							else {
								block3[i].classList.add("submitted");
							}
						}
						else {
							alert(response);
						}
					}
				});
			}
		});
	}
</script>
<script>
	var block4 = document.getElementsByClassName("block4");
	for (let i=0; i<block4.length; i++) {
		block4[i].addEventListener("change", function() {
			var course = document.getElementById("course").value;
			var schoolYear = document.getElementById("school-year").value;
			var studentNumber = document.getElementsByClassName("student-number")[i].value;
			var blockGrade = block4[i].value;
			if (blockGrade < 0) {
				alert("You cannot input value that is less than 0.");
			}
			else {
				$.ajax({
					url: "php/sop-promotional-block.php",
					type: "post",
					data: {
						block: "block4",
						course: course,
						schoolYear: schoolYear,
						studentNumber: studentNumber,
						blockGrade: blockGrade,
					},
					success: function(response) {
						if (response == "success") {
							if (blockGrade == "") {
								block4[i].classList.remove("submitted");
							}
							else {
								block4[i].classList.add("submitted");
							}
						}
						else {
							alert(response);
						}
					}
				});
			}
		});
	}
</script>
<script>
	var block5 = document.getElementsByClassName("block5");
	for (let i=0; i<block5.length; i++) {
		block5[i].addEventListener("change", function() {
			var course = document.getElementById("course").value;
			var schoolYear = document.getElementById("school-year").value;
			var studentNumber = document.getElementsByClassName("student-number")[i].value;
			var blockGrade = block5[i].value;
			if (blockGrade < 0) {
				alert("You cannot input value that is less than 0.");
			}
			else {
				$.ajax({
					url: "php/sop-promotional-block.php",
					type: "post",
					data: {
						block: "block5",
						course: course,
						schoolYear: schoolYear,
						studentNumber: studentNumber,
						blockGrade: blockGrade,
					},
					success: function(response) {
						if (response == "success") {
							if (blockGrade == "") {
								block5[i].classList.remove("submitted");
							}
							else {
								block5[i].classList.add("submitted");
							}
						}
						else {
							alert(response);
						}
					}
				});
			}
		});
	}
</script>
<script>
	var block6 = document.getElementsByClassName("block6");
	for (let i=0; i<block6.length; i++) {
		block6[i].addEventListener("change", function() {
			var course = document.getElementById("course").value;
			var schoolYear = document.getElementById("school-year").value;
			var studentNumber = document.getElementsByClassName("student-number")[i].value;
			var blockGrade = block6[i].value;
			if (blockGrade < 0) {
				alert("You cannot input value that is less than 0.");
			}
			else {
				$.ajax({
					url: "php/sop-promotional-block.php",
					type: "post",
					data: {
						block: "block6",
						course: course,
						schoolYear: schoolYear,
						studentNumber: studentNumber,
						blockGrade: blockGrade,
					},
					success: function(response) {
						if (response == "success") {
							if (blockGrade == "") {
								block6[i].classList.remove("submitted");
							}
							else {
								block6[i].classList.add("submitted");
							}
						}
						else {
							alert(response);
						}
					}
				});
			}
		});
	}
</script>
<script>
	var remarks = document.getElementsByClassName("remarks");
	for (let i=0; i<remarks.length; i++) {
		remarks[i].addEventListener("change", function() {
			var course = document.getElementById("course").value;
			var schoolYear = document.getElementById("school-year").value;
			var studentNumber = document.getElementsByClassName("student-number")[i].value;
			var remarksValue = remarks[i].value;
			$.ajax({
				url: "php/sop-promotional-remarks.php",
				type: "post",
				data: {
					course: course,
					schoolYear: schoolYear,
					studentNumber: studentNumber,
					remarks: remarksValue,
				},
				success: function(response) {
					if (response == "success") {
						if (remarksValue == "") {
							remarks[i].classList.remove("submitted");
						}
						else {
							remarks[i].classList.add("submitted");
						}
					}
					else {
						alert(response);
					}
				}
			});
		});
	}
</script>
<script>
	var remarks = document.getElementsByClassName("remarks");
	for (let i=0; i<remarks.length; i++) {
		var remarksValue = remarks[i].value;
		if (remarksValue != "") {
			remarks[i].classList.add("submitted");
		}
	}
</script>