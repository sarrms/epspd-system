<?php
date_default_timezone_set("Asia/Manila");
if (isset($_POST["rel"])) {
	include "connect.php";
	include "../vendor/autoload.php";
}
else {
	include "php/connect.php";
	include "vendor/autoload.php";
}
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Cell\Coordinate;

$fileName = $_COOKIE["application-for-graduation-file"];

$reader = IOFactory::createReader("Xlsx");
if (isset($_POST["rel"])) {
	$file = $reader->load("../uploads/application-for-graduation/$fileName");
}
else {
	$file = $reader->load("uploads/application-for-graduation/$fileName");
}
$activeSheet = $file->getActiveSheet();
$fileHighestRow = $activeSheet->getHighestDataRow();
$highestColumn = Coordinate::columnIndexFromString($activeSheet->getHighestDataColumn());
$vals = [];
$highestRow = 0;
for ($row=3; $row<=$fileHighestRow; $row++) {
	for ($col=1; $col<=$highestColumn; $col++) {
		$columnLetter = Coordinate::stringFromColumnIndex($col);
		$val = $activeSheet->getCell($columnLetter . $row)->getValue();
		if ($val != "") {
			array_push($vals, $val);
		}
	}
	if (count($vals) != 0) {
		$highestRow = $highestRow + 1;
	}
	array_splice($vals, 0);
}
$highestRow = $highestRow + 2;

$filecourse = $activeSheet->getCell("B1")->getValue();
$select = "SELECT * FROM course WHERE id=$filecourse";
$result = $connect -> query($select);
if ($result -> num_rows > 0) {
	while ($row = mysqli_fetch_array($result)) {
		$course = str_replace("Bachelor of Science", "BS", $row["course"]);
	}
}

$filemajor = $activeSheet->getCell("C1")->getValue();
if ($filemajor != "") {
	$select = "SELECT * FROM major WHERE id=$filemajor";
	$result = $connect -> query($select);
	if ($result -> num_rows > 0) {
		while ($row = mysqli_fetch_array($result)) {
			$major = "Major in " . $row["major"];
		}
	}
}
else {
	$major = "";
}

//CONVERT DATABASE SUBS TO ARRAY
$dbSubjects = [];
$select = "SELECT * FROM subject";
$result = $connect -> query($select);
if ($result -> num_rows > 0) {
	while ($row = mysqli_fetch_array($result)) {
		$subjectid = $row["id"];
		$subjectcode = $row["code"];
		array_push($dbSubjects, "$subjectid-$subjectcode");
	}
}

//CONVERT DATABASE PROFS TO ARRAY
$dbProfessors = [];
$select = "SELECT * FROM professor ORDER BY id ASC";
$result = $connect -> query($select);
if ($result -> num_rows > 0) {
	while ($row = mysqli_fetch_array($result)) {
		$dbProfId = $row["id"];
		$dbProfLastname = $row["lastname"];
		$dbProfFirstname = $row["firstname"];

		if ($row["middlename"] != "") {
			$dbProfMiddleinitial = substr($row["middlename"], 0, 1) . ".";
		}
		else {
			$dbProfMiddleinitial = "";
		}
		
		array_push($dbProfessors, "$dbProfId-$dbProfFirstname $dbProfLastname");
	}
}

//GRADE VALUES ARRAY
$gradeValue = ["1.00", "1.25", "1.50", "1.75", "2.00", "2.25", "2.50", "2.75", "3.00", "5.00", "INC", "DRP"];
?>
<div class="paper-report">
	<?php
	$accepted = 0;
	$rejected = 0;
	$notQualified = 0;
	$remaining = 0;
	for ($row=3; $row<=$highestRow; $row++) {
		$fileLackSub = $activeSheet->getCell("P" . $row)->getValue();
		$action = $activeSheet->getCell("AB" . $row)->getValue();
		if ($action == "accepted") {
			$accepted = $accepted + 1;
		}
		else if ($action == "rejected") {
			$rejected = $rejected + 1;
		}
		else if ($fileLackSub == "" && $action == "") {
			$remaining = $remaining + 1;
		}
		else {
			$notQualified = $notQualified + 1;
		}
	}
	?>
	<span>All: <?php echo $highestRow - 2; ?></span>
	<span>Accepted: <?php echo $accepted; ?></span>
	<span>Rejected: <?php echo $rejected; ?></span>
	<span>Not Qualified: <?php echo $notQualified; ?></span>
	<span>Remaining: <?php echo $remaining; ?></span>
</div>
<table class="application-graduation-table">
	<tr>
		<th colspan="7"><?php echo "$course $major"; ?></th>
	</tr>
	<tr>
		<th>Student Number</th>
		<th>Name</th>
		<th colspan="3">Enrolled Subject/s</th>
		<th>Graduation Fee</th>
		<th>Action</th>
	</tr>
	<?php
	for ($row=3; $row<=$highestRow; $row++) {
		$studentNumber = $activeSheet->getCell("B" . $row)->getValue();
		$surname = ucwords(strtolower($activeSheet->getCell("C" . $row)->getValue()));
		$givenName = ucwords(strtolower($activeSheet->getCell("D" . $row)->getValue()));
		$middleName = ucwords(strtolower($activeSheet->getCell("E" . $row)->getValue()));
		//GET ENROLLED SUBJECTS
		$fileEnrolledSub = $activeSheet->getCell("K" . $row)->getValue();
		$enrolledSub = explode(", ", $fileEnrolledSub);
		$enrolledSubSize = count($enrolledSub);
		
		//GET ENROLLED SUBJECTS PROFESSOR
		$fileEnrolledSubProf = $activeSheet->getCell("L" . $row)->getValue();
		$enrolledSubProf = explode(", ", $fileEnrolledSubProf);
		$enrolledSubProfSize = count($enrolledSubProf);

		//GET ENROLLED SUBJECTS GRADE
		$fileEnrolledSubGrade = $activeSheet->getCell("M" . $row)->getValue();
		if ($fileEnrolledSubGrade != "") {
			$enrolledSubGrade = explode(", ", $fileEnrolledSubGrade);
			$enrolledSubSize = count($enrolledSub);
		}
		
		$action = $activeSheet->getCell("AB" . $row)->getValue();
		
		echo "<tr>";
			echo "<td>$studentNumber</td>";
			echo "<td>$surname, $givenName $middleName</td>";
			echo "<td>";
				//DISPLAY ENROLLED SUBJECTS IN TABLE
				if ($enrolledSubSize > 0) {
					for ($i=0; $i<$enrolledSubSize; $i++) {
						for ($j=0; $j<count($dbSubjects); $j++) {
							$split = explode("-", $dbSubjects[$j]);
							if ($enrolledSub[$i] == $split[0]) {
								echo "$split[1]<br>";
							}
						}
					}
				}
			echo "</td>";
			echo "<td>";
				//DISPLAY ENROLLED SUBJECTS PROFESSOR IN TABLE
				if ($enrolledSubProfSize > 0) {
					for ($i=0; $i<$enrolledSubProfSize; $i++) {
						for ($j=0; $j<count($dbProfessors); $j++) {
							$split = explode("-", $dbProfessors[$j]);
							if ($enrolledSubProf[$i] == $split[0]) {
								echo "$split[1]<br>";
							}
						}
					}
				}
			echo "</td>";
			echo "<td>";
				$fileEnrolledSubGrade = explode(", ", $activeSheet->getCell("M" . $row)->getValue());
				for ($i=0; $i<count($fileEnrolledSubGrade); $i++) {
					for ($j=0; $j<count($dbSubjects); $j++) {
						$split = explode("-", $dbSubjects[$j]);
						if ($enrolledSub[$i] == $split[0]) {
							?><select title="<?php echo $split[1]; ?> Grade" class="select-grade">
								<?php
								for ($k=0; $k<count($gradeValue); $k++) {
									if ($fileEnrolledSubGrade[$i] == 0) {
										if ($k == 0) {
											echo "<option value='' selected hidden>Select Grade</option>";
											echo "<option value='$row-" . $k + 1 . "'>$gradeValue[$k]</option>";
										}
										else {
											echo "<option value='$row-" . $k + 1 . "'>$gradeValue[$k]</option>";
										}
									}
									else {
										if ($fileEnrolledSubGrade[$i] == $k + 1) {
											echo "<option value='$row-" . $k + 1 . "' selected>$gradeValue[$k]</option>";
										}
										else {
											echo "<option value='$row-" . $k + 1 . "'>$gradeValue[$k]</option>";
										}
									}
								}
								?>
							</select><?php
						}
					}
				}
			echo "</td>";
			echo "<td>";
				if ($fileLackSub == "") {
					echo "<button value='$row' class='view-modal-btn'>View</button>";
				}
			echo "</td>";
			echo "<td>";
				if ($action == "accepted") {
					echo "<span class='accepted-span'>Accepted</span>";
					?><button class="reject-btn" value="<?php echo $row; ?>" title="Reject application"><i class="fas fa-user-times"></i> Reject</button><?php
				}
				else if ($action == "rejected") {
					?><button class="accept-btn" value="<?php echo $row; ?>" title="Accept application"><i class="fas fa-user-check"></i> Accept</button><?php
					echo "<span class='rejected-span'>Rejected</span>";
				}
				else {
					?><button class="accept-btn" value="<?php echo $row; ?>" title="Accept application"><i class="fas fa-user-check"></i> Accept</button>
					<button class="reject-btn" value="<?php echo $row; ?>" title="Reject application"><i class="fas fa-user-times"></i> Reject</button><?php
				}
			echo "</td>";
		echo "</tr>";
	}
	?>
</table>
<script>
	var selectGrade = document.getElementsByClassName("select-grade");
	for (let i=0; i<selectGrade.length; i++) {
		if (selectGrade[i].value == "") {
			selectGrade[i].style.color = "#65676b";
		}
		else {
			selectGrade[i].style.color = "#000000";
		}
	}
</script>
<script>
	var selectGrade = document.getElementsByClassName("select-grade");
	for (let i=0; i<selectGrade.length; i++) {
		selectGrade[i].addEventListener("change", function() {
			$.ajax({
				url: "php/update-grade.php",
				type: "post",
				data: {
					loc: i,
					grade: selectGrade[i].value,
				},
				success: function(response) {
					selectGrade[i].style.color = "#000000";
				}
			});
		});
	}
</script>
<script>
	var viewModalBtn = document.getElementsByClassName("view-modal-btn");
	for (let i=0; i<viewModalBtn.length; i++) {
		viewModalBtn[i].addEventListener("click", function() {
			var modal = document.getElementById("modal");
			modal.style.opacity = "1";
			modal.style.pointerEvents = "auto";
			$.ajax({
				url: "php/modal-gradfee-application-graduation.php",
				type: "post",
				data: {
					row: viewModalBtn[i].value,
				},
				success: function(response) {
					$("#modal-content").html(response);
				}
			});
		});
	}
</script>
<script>
	var acceptBtn = document.getElementsByClassName("accept-btn");
	for (let i=0; i<acceptBtn.length; i++) {
		acceptBtn[i].addEventListener("click", function() {
			var row = this.value;
			document.getElementById("loader").style.display = "inherit";
			$.ajax({
				url: "php/accept-application-for-graduation.php",
				type: "post",
				data: {
					row: row,
				},
				success: function(response) {
					if (response == "success") {
						location.reload();
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
	var rejectBtn = document.getElementsByClassName("reject-btn");
	for (let i=0; i<rejectBtn.length; i++) {
		rejectBtn[i].addEventListener("click", function() {
			var row = this.value;
			document.getElementById("loader").style.display = "inherit";
			$.ajax({
				url: "php/reject-application-for-graduation.php",
				type: "post",
				data: {
					row: row,
				},
				success: function(response) {
					if (response == "success") {
						location.reload();
					}
					else {
						alert(response);
					}
				}
			});
		});
	}
</script>