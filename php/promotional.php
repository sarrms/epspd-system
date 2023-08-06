<?php
if (isset($_POST["rel"])) {
	include "connect.php";
}
else {
	include "php/connect.php";
}
?>
<link rel="stylesheet" href="css/promotional.css?v=1.0">
<div class="promotional">
	<form id="promotional-form" method="post">
		<div class="promotional-form-header">Promotional</div>
		<div class="promotional-form-body">
			<select name="status" title="Status">
				<option value="new" selected>New</option>
				<option value="old">Old</option>
			</select>
			<i title="Required" class="required-icon">*</i>
			<i class="input-icon fas fa-user"></i>
			<input id="student-number" name="student-number" placeholder="Student Number" title="Student Number" autocomplete="off">
			<i title="Required" class="required-icon">*</i>
			<select id="course" name="course" title="Course">
				<option value="" selected hidden>Course</option>
				<?php
				$select = "SELECT * FROM course ORDER BY course ASC";
				$result = $connect1 -> query($select);
				if ($result -> num_rows > 0) {
					while ($row = mysqli_fetch_array($result)) {
						$id = $row["id"];
						$course = $row["course"];

						echo "<option value='$id'>$course</option>";
					}
				}
				?>
			</select>
			<i title="Required" class="required-icon">*</i>
			<i class="input-icon fas fa-user"></i>
			<input id="last-name" name="last-name" placeholder="Last Name" title="Last Name" autocomplete="off">
			<i title="Required" class="required-icon">*</i>
			<i class="input-icon fas fa-user"></i>
			<input id="first-name" name="first-name" placeholder="First Name" title="First Name" autocomplete="off">
			<i title="Required" class="required-icon">*</i>
			<i class="input-icon fas fa-user"></i>
			<input name="middle-name" placeholder="Middle Name" title="Middle Name" autocomplete="off">
			<select id="gender" name="gender" title="Gender">
				<option value="" selected hidden>Gender</option>
				<option value="M">Male</option>
				<option value="F">Female</option>
			</select>
			<i title="Required" class="required-icon">*</i>
			<input type="date" id="birthday" name="birthday" title="Birthday">
			<i class="input-icon fas fa-user"></i>
			<input type="number" name="age" placeholder="Age" title="Age" autocomplete="off">
			<i class="input-icon fas fa-envelope"></i>
			<input name="email-address" placeholder="Email Address" title="Email Address" autocomplete="off">
			<i class="input-icon fas fa-phone"></i>
			<input name="contact-number" placeholder="Contact Number" title="Contact Number" autocomplete="off">
			<i class="input-icon fas fa-map-marked-alt"></i>
			<input name="permanent-address" placeholder="Permanent Address (House No., Street, Barangay, City/Municipality, Province)" title="Permanent Address" autocomplete="off">
			<i class="input-icon fas fa-male"></i>
			<input name="father-name" placeholder="Father's Name" title="Father's Name" autocomplete="off">
			<i class="input-icon fas fa-male"></i>
			<input name="father-occupation" placeholder="Father's Occupation" title="Father's Occupation" autocomplete="off">
			<i class=" input-icon fas fa-female"></i>
			<input name="mother-name" placeholder="Mother's Name" title="Mother's Name" autocomplete="off">
			<i class=" input-icon fas fa-female"></i>
			<input name="mother-occupation" placeholder="Mother's Occupation" title="Mother's Occupation" autocomplete="off">
			<button id="submit-btn"><i class="fas fa-save"></i> Submit</button>
		</div>
	</form>
</div>
<script>
	document.title = "Promotional - SOP Promotional to Certificate System";
</script>
<script>
	document.getElementById("promotional").classList.add("active");
	document.getElementById("grade-sheet").classList.remove("active");
	document.getElementById("list-promoted").classList.remove("active");
	document.getElementById("create-sop-diploma").classList.remove("active");
</script>
<script>
	$(document).ready(function() {
		$("#submit-btn").on("click", function(event) {
			event.preventDefault();
			if ($("#student-number").val() == "") {
				alert("Please input student number.");
			}
			else if ($("#student-number").val().indexOf('-') === -1) {
				alert('Please input valid student number. Must include hypen ("-").');
			}
			else if ($("#course").val() == "") {
				alert("Please select course.");
			}
			else if ($("#last-name").val() == "") {
				alert("Please input last name.");
			}
			else if ($("#first-name").val() == "") {
				alert("Please input first name.");
			}
			else if ($("#birthday").val() == "") {
				alert("Please select birthday.");
			}
			else if ($("#gender").val() == "") {
				alert("Please select gender.");
			}
			else {
				document.getElementById("loader").style.display = "inherit";
				var formData = new FormData($("#promotional-form")[0]);
				$.ajax({
					url: "php/insert-promotional.php",
					type: "post",
					data: formData,
					processData: false,
					contentType: false,
					success: function(response) {
						document.getElementById("loader").style.display = "none";
						alert(response);
					}
				});
			}
		});
	});
</script>