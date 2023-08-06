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

$fileName = $_COOKIE["final-evaluation-result-form-file"];

$reader = IOFactory::createReader("Xlsx");
if (isset($_POST["rel"])) {
	$file = $reader->load("../uploads/final-evaluation-result-form/$fileName");
}
else {
	$file = $reader->load("uploads/final-evaluation-result-form/$fileName");
}
$activeSheet = $file->getActiveSheet();
$fileHighestRow = $activeSheet->getHighestDataRow();
$highestColumn = $activeSheet->getHighestDataColumn();
$vals = [];
$highestRow = 0;
for ($row=3; $row<=$fileHighestRow; $row++) {
	for ($col="A"; $col<=$highestColumn; $col++) {
		$val = $activeSheet->getCell($col . $row)->getValue();
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
?>
<div class="paper-report">
	<?php
	$accepted = 0;
	$rejected = 0;
	$notQualified = 0;
	$remaining = 0;
	for ($row=3; $row<=$highestRow; $row++) {
		$fileLackSub = $activeSheet->getCell("O" . $row)->getValue();
		$action = $activeSheet->getCell("X" . $row)->getValue();
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
<table class="final-evaluation-result-table">
	<tr>
		<th colspan="10"><?php echo "$course $major"; ?></th>
	</tr>
	<tr>
		<th>Student Number</th>
		<th>Name</th>
		<th colspan="2">Enrolled Subject/s</th>
		<th colspan="2">Deficiency/Verification Subject/s</th>
		<th colspan="2">Lack Subject/s</th>
		<th>Submitted Credentials</th>
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
		if ($fileEnrolledSub != "") {
			$enrolledSub = explode(", ", $fileEnrolledSub);
			$enrolledSubSize = count($enrolledSub);
		}
		else {
			$enrolledSubSize = 0;
		}
		//GET ENROLLED SUBJECTS PROFESSOR
		$fileEnrolledSubProf = $activeSheet->getCell("L" . $row)->getValue();
		if ($fileEnrolledSubProf != "") {
			$enrolledSubProf = explode(", ", $fileEnrolledSubProf);
			$enrolledSubProfSize = count($enrolledSubProf);
		}
		else {
			$enrolledSubProfSize = 0;
		}
		//GET DEFICIENCY/VERIFICATION SUBJECTS
		$fileDeficiencySub = $activeSheet->getCell("M" . $row)->getValue();
		if ($fileDeficiencySub != "") {
			$deficiencySub = explode(", ", $fileDeficiencySub);
			$deficiencySubSize = count($deficiencySub);
		}
		else {
			$deficiencySubSize = 0;
		}
		//GET DEFICIENCY/VERIFICATION SUBJECTS PROFESSOR
		$fileDeficiencySubProf = $activeSheet->getCell("N" . $row)->getValue();
		if ($fileDeficiencySubProf != "") {
			$deficiencySubProf = explode(", ", $fileDeficiencySubProf);
			$deficiencySubProfSize = count($deficiencySubProf);
		}
		else {
			$deficiencySubProfSize = 0;
		}
		//GET LACK SUBJECTS
		$fileLackSub = $activeSheet->getCell("O" . $row)->getValue();
		if ($fileLackSub != "") {
			$lackSub = explode(", ", $fileLackSub);
			$lackSubSize = count($lackSub);
		}
		else {
			$lackSubSize = 0;
		}
		//GET LACK SUBJECTS PROFESSOR
		$fileLackSubProf = $activeSheet->getCell("P" . $row)->getValue();
		if ($fileLackSubProf != "") {
			$fileLackSubProf = explode(", ", $fileLackSubProf);
			$fileLackSubProfSize = count($fileLackSubProf);
		}
		else {
			$fileLackSubProfSize = 0;
		}
		$action = $activeSheet->getCell("X" . $row)->getValue();
		
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
				//DISPLAY DEFICIENCY/VERIFICATION SUBJECTS IN TABLE
				if ($deficiencySubSize > 0) {
					for ($i=0; $i<$deficiencySubSize; $i++) {
						for ($j=0; $j<count($dbSubjects); $j++) {
							$split = explode("-", $dbSubjects[$j]);
							if ($deficiencySub[$i] == $split[0]) {
								echo "$split[1]<br>";
							}
						}
					}
				}
			echo "</td>";
			echo "<td>";
				//DISPLAY DEFICIENCY/VERIFICATION SUBJECTS PROFESSOR IN TABLE
				if ($deficiencySubProfSize > 0) {
					for ($i=0; $i<$deficiencySubProfSize; $i++) {
						for ($j=0; $j<count($dbProfessors); $j++) {
							$split = explode("-", $dbProfessors[$j]);
							if ($deficiencySubProf[$i] == $split[0]) {
								echo "$split[1]<br>";
							}
						}
					}
				}
			echo "</td>";
			echo "<td>";
				//DISPLAY LACK SUBJECTS IN TABLE
				if ($lackSubSize > 0) {
					for ($i=0; $i<$lackSubSize; $i++) {
						for ($j=0; $j<count($dbSubjects); $j++) {
							$split = explode("-", $dbSubjects[$j]);
							if ($lackSub[$i] == $split[0]) {
								echo "$split[1]<br>";
							}
						}
					}
				}
			echo "</td>";
			echo "<td>";
				//DISPLAY LACK SUBJECTS PROFESSOR IN TABLE
				if ($fileLackSubProfSize > 0) {
					for ($i=0; $i<$fileLackSubProfSize; $i++) {
						for ($j=0; $j<count($dbProfessors); $j++) {
							$split = explode("-", $dbProfessors[$j]);
							if ($fileLackSubProf[$i] == $split[0]) {
								echo "$split[1]<br>";
							}
						}
					}
				}
			echo "</td>";
			?>
			<td>
				<?php
				if ($fileLackSub == "" && $action != "rejected") {
					echo "<button value='$row' class='view-modal-btn'>View</button>";
				}
				?>
			</td>
			<?php
			echo "<td>";
				if ($fileLackSub == "") {
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
				}
			echo "</td>";
		echo "</tr>";
	}
	?>
</table>
<script>
	document.title = "Application for Evaluation - Evaluation Process to Diploma System";
</script>
<script>
	document.getElementById("application-evaluation").classList.add("active");
	document.getElementById("final-evaluation-result-form").classList.remove("active");
	document.getElementById("application-graduation").classList.remove("active");
	document.getElementById("list-graduates").classList.remove("active");
	document.getElementById("create-diploma").classList.remove("active");
</script>
<script>
	document.getElementById("import-application-evaluation").addEventListener("click", function() {
		document.getElementById("loader").style.display = "inherit";
		location.reload();
	});
</script>
<script>
	document.getElementById("apply-application-evaluation").addEventListener("click", function() {
		document.getElementById("loader").style.display = "inherit";
		$.ajax({
			url: "php/apply-application-evaluation.php",
			type: "post",
			data: {
				data: "",
			},
			success: function(response) {
				document.getElementById("loader").style.display = "none";
				document.getElementById("import-application-evaluation").classList.remove("active");
				document.getElementById("apply-application-evaluation").classList.add("active");
				$("#main-paper").html(response);
			}
		});
	});
</script>
<script>
	var viewModalBtn = document.getElementsByClassName("view-modal-btn");
	for (let i=0; i<viewModalBtn.length; i++) {
		viewModalBtn[i].addEventListener("click", function() {
			var modal = document.getElementById("modal");
			modal.style.opacity = "1";
			modal.style.pointerEvents = "auto";
			$.ajax({
				url: "php/modal-final-evaluation-result.php",
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
				url: "php/accept-final-evaluation-result.php",
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
				url: "php/reject-final-evaluation-result.php",
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