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
		<div class="container">
			<div>
				<i class="fas fa-user-tie"></i>
			</div>
			<div>
				<div>
					<?php
					$select = "SELECT * FROM head WHERE position='president'";
					$result = $connect -> query($select);
					if ($result -> num_rows > 0) {
						echo mysqli_num_rows($result);
					}
					else {
						echo 0;
					}
					?>
				</div>
				<div>President</div>
			</div>
		</div>
		<div class="container">
			<div>
				<i class="fas fa-user-tie"></i>
			</div>
			<div>
				<div>
					<?php
					$select = "SELECT * FROM head WHERE position='registrar'";
					$result = $connect -> query($select);
					if ($result -> num_rows > 0) {
						echo mysqli_num_rows($result);
					}
					else {
						echo 0;
					}
					?>
				</div>
				<div>Registrar</div>
			</div>
		</div>
		<div class="container">
			<div>
				<i class="fas fa-user-tie"></i>
			</div>
			<div>
				<div>
					<?php
					$select = "SELECT * FROM dean";
					$result = $connect -> query($select);
					if ($result -> num_rows > 0) {
						echo mysqli_num_rows($result);
					}
					else {
						echo 0;
					}
					?>
				</div>
				<div>Dean</div>
			</div>
		</div>
	</div>
	<div class="heads-header">
		<a href="?heads&president"><i class="fas fa-user-tie"></i> President</a>
		<a href="?heads&registrar"><i class="fas fa-user-tie"></i> Registrar</a>
		<a href="?heads&dean"><i class="fas fa-user-tie"></i> Dean</a>
		<button id="register-btn" title="Register head"><i class="fas fa-plus-circle"></i> Register</button>
	</div>
	<table>
		<?php
		if (isset($_GET["registrar"])) {
			$head = "registrar";
		}
		else if (isset($_GET["dean"])) {
			$head = "dean";
		}
		else {
			$head = "president";
		}

		if ($head == "president" || $head == "registrar") {
			echo "<tr>";
				echo "<th>ID</th>";
				echo "<th>Name</th>";
				echo "<th>Action</th>";
			echo "</tr>";
			if ($head == "president") {
				$select = "SELECT * FROM head WHERE position='president'";
			}
			else if ($head == "registrar") {
				$select = "SELECT * FROM head WHERE position='registrar'";
			}
			$result = $connect -> query($select);
			if ($result -> num_rows > 0) {
				while ($row = mysqli_fetch_array($result)) {
					$headid = $row["id"];
					$headname = $row["name"];

					echo "<tr style='text-align: center;'>";
						echo "<td style='width: 100px;'>$headid</td>";
						echo "<td>$headname</td>";
						echo "<td style='width: 165px;'>";
							echo "<button value='$headid' title='Edit $headname' class='edit-btn'><i class='fas fa-edit'></i></button>";
							echo "<button value='$headid' title='Delete $headname' class='delete-btn'><i class='fas fa-trash'></i></button>";
						echo "</td>";
					echo "</tr>";
				}
			}
		}
		else if ($head == "dean") {
			echo "<tr>";
				echo "<th>ID</th>";
				echo "<th>Name</th>";
				echo "<th>College</th>";
				echo "<th>Action</th>";
			echo "</tr>";
			$select = "SELECT * FROM dean ORDER BY college ASC";
			$result = $connect -> query($select);
			if ($result -> num_rows > 0) {
				while ($row = mysqli_fetch_array($result)) {
					$deanid = $row["id"];
					$deanname = $row["dean"];
					$deancollege = $row["college"];

					echo "<tr>";
						echo "<td style='width: 100px;'>$deanid</td>";
						echo "<td>$deanname</td>";
						$select1 = "SELECT * FROM college WHERE id=$deancollege";
						$result1 = $connect -> query($select1);
						if ($result1 -> num_rows > 0) {
							while ($row1 = mysqli_fetch_array($result1)) {
								$college = $row1["college"];
								$collegeacro = $row1["acronym"];
							}
						}
						echo "<td>$college ($collegeacro)</td>";
						echo "<td style='width: 165px;'>";
							echo "<button value='$deanid' title='Edit $deanname' class='edit-btn'><i class='fas fa-edit'></i></button>";
							echo "<button value='$deanid' title='Delete $deanname' class='delete-btn'><i class='fas fa-trash'></i></button>";
						echo "</td>";
					echo "</tr>";
				}
			}
		}
		?>
	</table>
</div>
<script>
	document.title = "Heads - Evaluation Process to Diploma System";
</script>
<script>
	document.getElementById("dashboard").classList.remove("active");
	document.getElementById("subjects").classList.remove("active");
	document.getElementById("professors").classList.remove("active");
	document.getElementById("heads").classList.add("active");
	document.getElementById("colleges").classList.remove("active");
</script>
<script>
	var parent = document.querySelectorAll(".heads-header a");
	<?php
	if (isset($_GET["registrar"])) {
		echo "var child = 1;";
	}
	else if (isset($_GET["dean"])) {
		echo "var child = 2;";
	}
	else {
		echo "var child = 0;";
	}
	?>
	parent[child].classList.add("active");
</script>
<script>
	document.getElementById("register-btn").addEventListener("click", function() {
		var modal = document.getElementById("modal");
		modal.style.opacity = "1";
		modal.style.pointerEvents = "auto";
		$.ajax({
			url: "php/modal-admin-heads-register.php",
			type: "post",
			data: {
				type: "<?php echo $head; ?>",
			},
			success: function(response) {
				$("#modal-content").html(response);
			}
		});
	});
</script>
<script>
	var editBtn = document.getElementsByClassName("edit-btn");
	for (let i=0; i<editBtn.length; i++) {
		editBtn[i].addEventListener("click", function() {
			var modal = document.getElementById("modal");
			modal.style.opacity = "1";
			modal.style.pointerEvents = "auto";
			$.ajax({
				url: "php/modal-admin-heads-edit.php",
				type: "post",
				data: {
					id: editBtn[i].value,
					type: "<?php echo $head; ?>",
				},
				success: function(response) {
					$("#modal-content").html(response);
				}
			});
		});
	}
</script>
<script>
	var deleteBtn = document.getElementsByClassName("delete-btn");
	for (let i=0; i<deleteBtn.length; i++) {
		deleteBtn[i].addEventListener("click", function() {
			const params = new URLSearchParams(window.location.search);
        	const president = params.get("president");
        	const registrar = params.get("registrar");
        	const dean = params.get("dean");
			if (president !== null || registrar !== null) {
				if (president !== null) {
					var head = "president";
				}
				else if (registrar !== null) {
					var head = "registrar";
				}
				if (confirm("Are you sure you want to remove this " + head + "? Once this " + head + " was already used, it may cause errors in some part of the system and needs to be fixed.")) {
					$.ajax({
						url: "php/admin-heads-delete.php",
						type: "post",
						data: {
							id: deleteBtn[i].value,
							type: head,
						},
						success: function(response) {
							if (response == "success") {
								if (!alert("Subject successfully deleted.")) {
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
			else if (dean !== null) {
				if (confirm("Are you sure you want to remove this dean? Once this dean was already used, it may cause errors in some part of the system and needs to be fixed.")) {
					$.ajax({
						url: "php/admin-heads-delete.php",
						type: "post",
						data: {
							id: deleteBtn[i].value,
							type: "dean",
						},
						success: function(response) {
							if (response == "success") {
								if (!alert("Subject successfully deleted.")) {
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