<?php
date_default_timezone_set("Asia/Manila");
include "php/connect.php";
?>
<link rel="stylesheet" href="css/admin.css?v=1.0">
<div class="main-body">
	<div class="admin-header">
		<div class="container">
			<div>
				<i class="fas fa-university"></i>
			</div>
			<div>
				<div>
					<?php
					$select = "SELECT * FROM college";
					$result = $connect -> query($select);
					if ($result -> num_rows > 0) {
						echo mysqli_num_rows($result);
					}
					else {
						echo 0;
					}
					?>
				</div>
				<div>Colleges</div>
			</div>
		</div>
		<div class="container">
			<div>
				<i class="fas fa-graduation-cap"></i>
			</div>
			<div>
				<div>
					<?php
					$select = "SELECT * FROM course";
					$result = $connect -> query($select);
					if ($result -> num_rows > 0) {
						echo mysqli_num_rows($result);
					}
					else {
						echo 0;
					}
					?>
				</div>
				<div>Courses</div>
			</div>
		</div>
		<div class="container">
			<div>
				<i class="fas fa-graduation-cap"></i>
			</div>
			<div>
				<div>
				<?php
					$select = "SELECT * FROM major";
					$result = $connect -> query($select);
					if ($result -> num_rows > 0) {
						echo mysqli_num_rows($result);
					}
					else {
						echo 0;
					}
					?>
				</div>
				<div>Majors</div>
			</div>
		</div>
	</div>
	<div class="colleges-header">
		<a href="?colleges"><i class="fas fa-university"></i> College</a>
		<a href="?colleges&course"><i class="fas fa-graduation-cap"></i> Course</a>
		<a href="?colleges&major"><i class="fas fa-graduation-cap"></i> Major</a>
		<button id="create-btn" title="Create"><i class="fas fa-plus-circle"></i> Create</button>
	</div>
	<table>
		<?php
		if (isset($_GET["course"])) {
			echo "<tr>";
				echo "<th>ID</th>";
				echo "<th>College</th>";
				echo "<th>Course Acronym</th>";
				echo "<th>Course</th>";
				echo "<th>Action</th>";
			echo "</tr>";
			$select = "SELECT * FROM course ORDER BY college, course";
			$result = $connect -> query($select);
			if ($result -> num_rows > 0) {
				while ($row = mysqli_fetch_array($result)) {
					$courseid = $row["id"];
					$courseacro = $row["acronym"];
					$course = $row["course"];
					$coursecollege = $row["college"];

					echo "<tr>";
						echo "<td>$courseid</td>";
						$select1 = "SELECT * FROM college ORDER BY id=$coursecollege";
						$result1 = $connect -> query($select1);
						if ($result1 -> num_rows > 0) {
							while ($row1 = mysqli_fetch_array($result1)) {
								$collegename = $row1["college"];
							}
						}
						echo "<td>$collegename</td>";
						echo "<td>$courseacro</td>";
						echo "<td>$course</td>";
						echo "<td>";
							echo "<button value='$courseid' title='Edit $course ($courseacro)' class='edit-btn'><i class='fas fa-edit'></i></button>";
							echo "<button value='$courseid' title='Delete $course ($courseacro)' class='delete-btn'><i class='fas fa-trash'></i></button>";
						echo "</td>";
					echo "</tr>";
				}
			}
		}
		else if (isset($_GET["major"])) {
			echo "<tr>";
				echo "<th>ID</th>";
				echo "<th>Course</th>";
				echo "<th>Major</th>";
				echo "<th>Action</th>";
			echo "</tr>";
			$select = "SELECT * FROM major ORDER BY course, major";
			$result = $connect -> query($select);
			if ($result -> num_rows > 0) {
				while ($row = mysqli_fetch_array($result)) {
					$majorid = $row["id"];
					$major = $row["major"];
					$course = $row["course"];

					echo "<tr>";
						echo "<td>$majorid</td>";
						$select1 = "SELECT * FROM course ORDER BY id=$course";
						$result1 = $connect -> query($select1);
						if ($result1 -> num_rows > 0) {
							while ($row1 = mysqli_fetch_array($result1)) {
								$coursename = $row1["course"];
							}
						}
						echo "<td>$coursename</td>";
						echo "<td>$major</td>";
						echo "<td>";
							echo "<button value='$majorid' title='Edit $major' class='edit-btn'><i class='fas fa-edit'></i></button>";
							echo "<button value='$majorid' title='Delete $major' class='delete-btn'><i class='fas fa-trash'></i></button>";
						echo "</td>";
					echo "</tr>";
				}
			}
		}
		else {
			echo "<tr>";
				echo "<th>ID</th>";
				echo "<th>College Acronym</th>";
				echo "<th>College</th>";
				echo "<th>Action</th>";
			echo "</tr>";
			$select = "SELECT * FROM college ORDER BY college";
			$result = $connect -> query($select);
			if ($result -> num_rows > 0) {
				while ($row = mysqli_fetch_array($result)) {
					$collegeid = $row["id"];
					$collegeacro = $row["acronym"];
					$college = $row["college"];

					echo "<tr>";
						echo "<td>$collegeid</td>";
						echo "<td style='text-align: center;'>$collegeacro</td>";
						echo "<td>$college</td>";
						echo "<td>";
							echo "<button value='$collegeid' title='Edit $college ($collegeacro)' class='edit-btn'><i class='fas fa-edit'></i></button>";
							echo "<button value='$collegeid' title='Delete $college ($collegeacro)' class='delete-btn'><i class='fas fa-trash'></i></button>";
						echo "</td>";
					echo "</tr>";
				}
			}
		}
		?>
	</table>
</div>
<script>
	document.title = "Colleges - Evaluation Process to Diploma System";
</script>
<script>
	document.getElementById("dashboard").classList.remove("active");
	document.getElementById("colleges").classList.add("active");
	document.getElementById("subjects").classList.remove("active");
	document.getElementById("professors").classList.remove("active");
	document.getElementById("heads").classList.remove("active");
</script>
<script>
	var parent = document.querySelectorAll(".colleges-header a");
	<?php
	if (isset($_GET["course"])) {
		echo "var child = 1;";
	}
	else if (isset($_GET["major"])) {
		echo "var child = 2;";
	}
	else {
		echo "var child = 0;";
	}
	?>
	parent[child].classList.add("active");
</script>
<script>
	document.getElementById("create-btn").addEventListener("click", function() {
		var modal = document.getElementById("modal");
		modal.style.opacity = "1";
		modal.style.pointerEvents = "auto";
		const params = new URLSearchParams(window.location.search);
		const course = params.get("course");
		const major = params.get("major");
		if (course !== null) {
			$.ajax({
				url: "php/modal-admin-colleges-course-create.php",
				type: "post",
				success: function(response) {
					$("#modal-content").html(response);
				}
			});
		}
		else if (major !== null) {
			$.ajax({
				url: "php/modal-admin-colleges-major-create.php",
				type: "post",
				success: function(response) {
					$("#modal-content").html(response);
				}
			});
		}
		else {
			$.ajax({
				url: "php/modal-admin-colleges-create.php",
				type: "post",
				success: function(response) {
					$("#modal-content").html(response);
				}
			});
		}
	});
</script>
<script>
	var editBtn = document.getElementsByClassName("edit-btn");
	for (let i=0; i<editBtn.length; i++) {
		editBtn[i].addEventListener("click", function() {
			var modal = document.getElementById("modal");
			modal.style.opacity = "1";
			modal.style.pointerEvents = "auto";
			const params = new URLSearchParams(window.location.search);
			const course = params.get("course");
			const major = params.get("major");
			if (course !== null) {
				$.ajax({
					url: "php/modal-admin-colleges-course-edit.php",
					type: "post",
					data: {
						id: editBtn[i].value,
					},
					success: function(response) {
						$("#modal-content").html(response);
					}
				});
			}
			else if (major !== null) {
				$.ajax({
					url: "php/modal-admin-colleges-major-edit.php",
					type: "post",
					data: {
						id: editBtn[i].value,
					},
					success: function(response) {
						$("#modal-content").html(response);
					}
				});
			}
			else {
				$.ajax({
					url: "php/modal-admin-colleges-edit.php",
					type: "post",
					data: {
						id: editBtn[i].value,
					},
					success: function(response) {
						$("#modal-content").html(response);
					}
				});
			}
		});
	}
</script>
<script>
	var deleteBtn = document.getElementsByClassName("delete-btn");
	for (let i=0; i<deleteBtn.length; i++) {
		deleteBtn[i].addEventListener("click", function() {
			const params = new URLSearchParams(window.location.search);
			const course = params.get("course");
			const major = params.get("major");
			if (course !== null) {
				if (confirm("Are you sure you want to remove this course? Once this course was already used, it may cause errors in some part of the system and needs to be fixed.")) {
					$.ajax({
						url: "php/admin-colleges-course-delete.php",
						type: "post",
						data: {
							id: deleteBtn[i].value,
						},
						success: function(response) {
							if (response == "success") {
								if (!alert("Course successfully removed.")) {
									location.reload();
								}
							}
							else {
								alert(response);
							}
						}
					});
				}
			}
			else if (major !== null) {
				if (confirm("Are you sure you want to remove this major? Once this major was already used, it may cause errors in some part of the system and needs to be fixed.")) {
					$.ajax({
						url: "php/admin-colleges-major-delete.php",
						type: "post",
						data: {
							id: deleteBtn[i].value,
						},
						success: function(response) {
							if (response == "success") {
								if (!alert("Major successfully removed.")) {
									location.reload();
								}
							}
							else {
								alert(response);
							}
						}
					});
				}
			}
			else {
				if (confirm("Are you sure you want to remove this college? Once this college was already used, it may cause errors in some part of the system and needs to be fixed.")) {
					$.ajax({
						url: "php/admin-colleges-delete.php",
						type: "post",
						data: {
							id: deleteBtn[i].value,
						},
						success: function(response) {
							if (response == "success") {
								if (!alert("College successfully deleted.")) {
									location.reload();
								}
							}
							else {
								alert(response);
							}
						}
					});
				}
			}
		});
	}
</script>