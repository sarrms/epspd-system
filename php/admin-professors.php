<?php
date_default_timezone_set("Asia/Manila");
include "php/connect.php";
$username = $_COOKIE["admin"];
$select = "SELECT * FROM admin WHERE username='$username'";
$result = $connect -> query($select);
if ($result -> num_rows > 0) {
	while ($row = mysqli_fetch_array($result)) {
		$type = $row["type"];
	}
}

function addNumberSuffix($number) {
	if (($number % 100 >= 11) && ($number % 100 <= 13)) {
		return $number . "th";
	}
	else {
		$suffixes = array("th", "st", "nd", "rd", "th", "th", "th", "th", "th", "th");
		return $number . $suffixes[$number % 10];
	}
}
?>
<link rel="stylesheet" href="css/admin.css?v=1.0">
<div class="main-body">
	<div class="admin-header">
		<div class="container">
			<div>
				<i class="fas fa-chalkboard-teacher"></i>
			</div>
			<div>
				<div>
					<?php
					$select = "SELECT * FROM professor";
					$result = $connect -> query($select);
					if ($result -> num_rows > 0) {
						echo mysqli_num_rows($result);
					}
					else {
						echo 0;
					}
					?>
				</div>
				<div>Professors</div>
			</div>
		</div>
	</div>
	<div class="professors-header">
		<?php
		if (isset($_GET["set"])) {
			echo "<a href='?professors&register'><i class='fas fa-plus-circle'></i> Register</a>";
			echo "<a href='?professors&set' class='active'><i class='fas fa-cog'></i> Set</a>";
		}
		else {
			echo "<a href='?professors&register' class='active'><i class='fas fa-plus-circle'></i> Register</a>";
			echo "<a href='?professors&set'><i class='fas fa-cog'></i> Set</a>";
		}

		if (isset($_GET["professors"]) && !isset($_GET["set"])) {
			echo "<button id='register-btn' title='Register professor'><i class='fas fa-plus-circle'></i> Register</button>";
		}
		?>
	</div>
	<div class="subjects-subheader">
		<?php
		if (isset($_GET["professors"]) && isset($_GET["set"])) {
			?><select id="select-college" title="College">
				<option value="0" selected>All</option>
				<?php
				$select = "SELECT * FROM college";
				$result = $connect -> query($select);
				if ($result -> num_rows > 0) {
					while ($row = mysqli_fetch_array($result)) {
						$collegeid = $row["id"];
						$collegeacro = $row["acronym"];
						$college = $row["college"];

						if (isset($_GET["college"])) {
							if ($collegeid == $_GET["college"]) {
								echo "<option value='$collegeid' selected>$college ($collegeacro)</option>";
							}
							else {
								echo "<option value='$collegeid'>$college ($collegeacro)</option>";
							}
						}
						else {
							echo "<option value='$collegeid'>$college ($collegeacro)</option>";
						}
					}
				}
				?>
			</select>
			<select id="select-course" title="Course">
				<option value="0" selected>All</option>
				<?php
				if (isset($_GET["college"])) {
					$college = $_GET["college"];
					$select = "SELECT * FROM course WHERE college=$college";
				}
				else {
					$select = "SELECT * FROM course";
				}
				$result = $connect -> query($select);
				if ($result -> num_rows > 0) {
					while ($row = mysqli_fetch_array($result)) {
						$courseid = $row["id"];
						$courseacro = $row["acronym"];
						$course = $row["course"];

						if (isset($_GET["course"])) {
							if ($courseid == $_GET["course"]) {
								echo "<option value='$courseid' selected>$course ($courseacro)</option>";
							}
							else {
								echo "<option value='$courseid'>$course ($courseacro)</option>";
							}
						}
						else {
							echo "<option value='$courseid'>$course ($courseacro)</option>";
						}
					}
				}
				?>
			</select>
			<select id="select-year-level" title="Year Level">
				<option value="0" selected>All Year Level</option>
				<?php
				for ($i=1; $i<=4; $i++) {
					if (isset($_GET["yearlevel"])) {
						$yearlevel = $_GET["yearlevel"];
						if ($i == $yearlevel) {
							echo "<option value='$yearlevel' selected>" . addNumberSuffix($yearlevel) . " Year</option>";
						}
						else {
							echo "<option value='$i'>" . addNumberSuffix($i) . " Year</option>";
						}
					}
					else {
						echo "<option value='$i'>" . addNumberSuffix($i) . " Year</option>";
					}
				}
				?>
				?>
			</select>
			<select id="select-semester" title="Semester">
				<option value="0" selected>All Semester</option>
				<?php
				for ($i=1; $i<=2; $i++) {
					if (isset($_GET["semester"])) {
						if ($i == $_GET["semester"]) {
							echo "<option value='$i' selected>" . addNumberSuffix($i) . " Semester</option>";
						}
						else {
							echo "<option value='$i'>" . addNumberSuffix($i) . " Semester</option>";
						}
					}
					else {
						echo "<option value='$i'>" . addNumberSuffix($i) . " Semester</option>";
					}
				}
				?>
			</select>
			<select id="select-subject" title="Subject">
				<option value="0" selected>None</option>
				<?php
				$selects = [];
				if (isset($_GET["college"])) {
					$college = $_GET["college"];
					array_push($selects, "college='$college'");
				}
				if (isset($_GET["course"])) {
					$course = $_GET["course"];
					array_push($selects, "course='$course'");
				}
				if (isset($_GET["yearlevel"])) {
					$yearlevel = $_GET["yearlevel"];
					array_push($selects, "yearlevel='$yearlevel'");
				}
				if (isset($_GET["semester"])) {
					$semester = $_GET["semester"];
					array_push($selects, "semester='$semester'");
				}
				$newSelects = implode(" AND ", $selects);
				$select = "SELECT * FROM coursesubject";
				if (!empty($newSelects)) {
					$select .= " WHERE " . $newSelects;
				}
				$select .= " ORDER BY college, course, yearlevel, semester, subject ASC";
				$result = $connect -> query($select);
				if ($result -> num_rows > 0) {
					while ($row = mysqli_fetch_array($result)) {
						$subject = $row["subject"];

						$select1 = "SELECT * FROM subject WHERE id=$subject";
						$result1 = $connect -> query($select1);
						if ($result1 -> num_rows > 0) {
							while ($row1 = mysqli_fetch_array($result1)) {
								$subjectid = $row1["id"];
								$subjectcode = $row1["code"];
								$subjectitle = $row1["title"];

								if (isset($_GET["subject"])) {
									if ($subjectid == $_GET["subject"]) {
										echo "<option value='$subjectid' selected>$subjectitle ($subjectcode)</option>";
									}
									else {
										echo "<option value='$subjectid'>$subjectitle ($subjectcode)</option>";
									}
								}
								else {
									echo "<option value='$subjectid'>$subjectitle ($subjectcode)</option>";
								}
							}
						}
					}
				}
				?>
			</select><?php
		}
		?>
	</div>
	<table>
		<?php
		if ($type == "evaluation-process") {
			if (isset($_GET["set"])) {
				include "php/admin-professors-set.php";
			}
			else {
				include "php/admin-professors-register.php";
			}
		}
		else if ($type == "sop-promotional") {
			$select = "SELECT * FROM admin";
			$result = $connect -> query($select);
			if ($result -> num_rows > 0) {
				while ($row = mysqli_fetch_array($result)) {
					
				}
			}
		}
		?>
	</table>
</div>
<script>
	document.title = "Professors - <?php
	if ($type == "evaluation-process") {
		echo 'Evaluation Process to Diploma System';
	}
	else {
		echo 'SOP Promotional to Diploma System';
	}
	?>";
</script>
<script>
	document.getElementById("dashboard").classList.remove("active");
	document.getElementById("subjects").classList.remove("active");
	document.getElementById("professors").classList.add("active");
	document.getElementById("heads").classList.remove("active");
	document.getElementById("colleges").classList.remove("active");
</script>
<?php
if (isset($_GET["professors"]) && isset($_GET["set"])) {
	?><script>
		var college = document.getElementById("select-college");
		college.addEventListener("change", function() {
			document.getElementById("loader").style.display = "inherit";
			var yearlevel = document.getElementById("select-year-level").value;
			var semester = document.getElementById("select-semester").value;
			var href = ["professors", "set"];
			if (college.value != 0) {
				href.push("college=" + college.value);
			}
			if (yearlevel != 0) {
				href.push("yearlevel=" + yearlevel);
			}
			if (semester != 0) {
				href.push("semester=" + semester);
			}
			location.href = "?" + href.join("&");
		});
	</script>
	<script>
		var course = document.getElementById("select-course");
		course.addEventListener("change", function() {
			document.getElementById("loader").style.display = "inherit";
			var college = document.getElementById("select-college").value;
			var yearlevel = document.getElementById("select-year-level").value;
			var semester = document.getElementById("select-semester").value;
			var href = ["professors", "set"];
			if (college != 0) {
				href.push("college=" + college);
			}
			if (course.value != 0) {
				href.push("course=" + course.value);
			}
			if (yearlevel != 0) {
				href.push("yearlevel=" + yearlevel);
			}
			if (semester != 0) {
				href.push("semester=" + semester);
			}
			location.href = "?" + href.join("&");
		});
	</script>
	<script>
		var yearlevel = document.getElementById("select-year-level");
		yearlevel.addEventListener("change", function() {
			document.getElementById("loader").style.display = "inherit";
			var college = document.getElementById("select-college").value;
			var course = document.getElementById("select-course").value;
			var semester = document.getElementById("select-semester").value;
			var href = ["professors", "set"];
			if (college != 0) {
				href.push("college=" + college);
			}
			if (course != 0) {
				href.push("course=" + course);
			}
			if (yearlevel.value != 0) {
				href.push("yearlevel=" + yearlevel.value);
			}
			if (semester != 0) {
				href.push("semester=" + semester);
			}
			location.href = "?" + href.join("&");
		});
	</script>
	<script>
		var semester = document.getElementById("select-semester");
		semester.addEventListener("change", function() {
			document.getElementById("loader").style.display = "inherit";
			var college = document.getElementById("select-college").value;
			var course = document.getElementById("select-course").value;
			var yearlevel = document.getElementById("select-year-level").value;
			var href = ["professors", "set"];
			if (college != 0) {
				href.push("college=" + college);
			}
			if (course != 0) {
				href.push("course=" + course);
			}
			if (yearlevel != 0) {
				href.push("yearlevel=" + yearlevel);
			}
			if (semester.value != 0) {
				href.push("semester=" + semester.value);
			}
			location.href = "?" + href.join("&");
		});
	</script>
	<script>
		var subject = document.getElementById("select-subject");
		subject.addEventListener("change", function() {
			document.getElementById("loader").style.display = "inherit";
			var college = document.getElementById("select-college").value;
			var course = document.getElementById("select-course").value;
			var yearlevel = document.getElementById("select-year-level").value;
			var semester = document.getElementById("select-semester").value;
			var href = ["professors", "set"];
			if (college != 0) {
				href.push("college=" + college);
			}
			if (course != 0) {
				href.push("course=" + course);
			}
			if (yearlevel != 0) {
				href.push("yearlevel=" + yearlevel);
			}
			if (semester != 0) {
				href.push("semester=" + semester);
			}
			if (subject.value != 0) {
				href.push("subject=" + subject.value);
			}
			location.href = "?" + href.join("&");
		});
	</script><?php
}
if (isset($_GET["professors"]) && !isset($_GET["set"])) {
	?><script>
		document.getElementById("register-btn").addEventListener("click", function() {
			var modal = document.getElementById("modal");
			modal.style.opacity = "1";
			modal.style.pointerEvents = "auto";
			$.ajax({
				url: "php/modal-admin-professors-register.php",
				type: "post",
				data: "",
				success: function(response) {
					$("#modal-content").html(response);
				}
			});
		});
	</script><?php
}
?>