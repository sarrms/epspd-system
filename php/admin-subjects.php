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
?>
<link rel="stylesheet" href="css/admin.css?v=1.0">
<div class="main-body">
	<div class="admin-header">
		<?php
		$select = "SELECT * FROM coursesubject";
		$result = $connect -> query($select);
		if ($result -> num_rows > 0) {
			$subjects = mysqli_num_rows($result);
		}

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
		$result = $connect -> query($select);
		if ($result -> num_rows > 0) {
			$displaysubjects = mysqli_num_rows($result);
		}
		else {
			$displaysubjects = 0;
		}
		?>
		<div class="container">
			<div>
				<i class="far fa-file-alt"></i>
			</div>
			<div>
				<div>
					<?php echo $subjects; ?>
				</div>
				<div>Subjects</div>
			</div>
		</div>
		<?php
		if (isset($_GET["subjects"]) && isset($_GET["set"])) {
			?><div class="container">
				<div>
					<i class="far fa-file-alt"></i>
				</div>
				<div>
					<div>
						<?php echo $displaysubjects; ?>
					</div>
					<div>Displayed</div>
				</div>
			</div><?php
		}
		?>
	</div>
	<div class="subjects-header">
		<?php
		if (isset($_GET["set"])) {
			echo "<a href='?subjects&create'><i class='fas fa-plus-circle'></i> Create</a>";
			echo "<a href='?subjects&set' class='active'><i class='fas fa-cog'></i> Set</a>";
		}
		else {
			echo "<a href='?subjects&create' class='active'><i class='fas fa-plus-circle'></i> Create</a>";
			echo "<a href='?subjects&set'><i class='fas fa-cog'></i> Set</a>";
		}
		
		if (isset($_GET["subjects"]) && !isset($_GET["set"])) {
			echo "<button id='create-btn' title='Create subject'><i class='fas fa-plus-circle'></i> Create</button>";
		}
		?>
	</div>
	<div class="subjects-subheader">
		<?php
		if (isset($_GET["subjects"]) && isset($_GET["set"])) {
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
				<option value="0" selected>All</option>
				<?php
				for ($i=1; $i<=4; $i++) {
					if (isset($_GET["yearlevel"])) {
						$yearlevel = $_GET["yearlevel"];
						if ($i == $yearlevel) {
							echo "<option value='$yearlevel' selected>$yearlevel</option>";
						}
						else {
							echo "<option value='$i'>$i</option>";
						}
					}
					else {
						echo "<option value='$i'>$i</option>";
					}
				}
				?>
				?>
			</select>
			<select id="select-semester" title="Semester">
				<option value="0" selected>All</option>
				<?php
				for ($i=1; $i<=2; $i++) {
					if (isset($_GET["semester"])) {
						if ($i == $_GET["semester"]) {
							echo "<option value='$i' selected>$i</option>";
						}
						else {
							echo "<option value='$i'>$i</option>";
						}
					}
					else {
						echo "<option value='$i'>$i</option>";
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
				include "php/admin-subjects-set.php";
			}
			else {
				include "php/admin-subjects-create.php";
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
	document.title = "Subjects - <?php
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
	document.getElementById("subjects").classList.add("active");
	document.getElementById("professors").classList.remove("active");
	document.getElementById("heads").classList.remove("active");
	document.getElementById("colleges").classList.remove("active");
</script>
<?php
if (isset($_GET["subjects"]) && isset($_GET["set"])) {
	?><script>
		var college = document.getElementById("select-college");
		college.addEventListener("change", function() {
			document.getElementById("loader").style.display = "inherit";
			var yearlevel = document.getElementById("select-year-level").value;
			var semester = document.getElementById("select-semester").value;
			var href = ["subjects", "set"];
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
			var href = ["subjects", "set"];
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
			var href = ["subjects", "set"];
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
			var href = ["subjects", "set"];
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
	</script><?php
}
if (isset($_GET["subjects"]) && !isset($_GET["set"])) {
	?><script>
		document.getElementById("create-btn").addEventListener("click", function() {
			var modal = document.getElementById("modal");
			modal.style.opacity = "1";
			modal.style.pointerEvents = "auto";
			$.ajax({
				url: "php/modal-admin-subjects-create.php",
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