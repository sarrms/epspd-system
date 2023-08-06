<?php
include "connect.php";
include "../vendor/autoload.php";

use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;

$reader = IOFactory::createReader("Xlsx");
if (isset($_COOKIE["final-evaluation-result-form-file"])) {
	$fileName = $_COOKIE["final-evaluation-result-form-file"];
}
$file = $reader->load("../uploads/final-evaluation-result-form/$fileName");
$activeSheet = $file->getActiveSheet();
//GET THE HIGHEST ROW
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

//CONVERT DATABASE SUBJECTS TO ARRAY
$subject = [];
$select = "SELECT * FROM subject ORDER BY id ASC";
$result = $connect -> query($select);
if ($result -> num_rows > 0) {
	while ($row = mysqli_fetch_array($result)) {
		$dbSubjectId = $row["id"];
		$dbSubjectCode = $row["code"];

		array_push($subject, "$dbSubjectId-$dbSubjectCode");
	}
}
//CONVERT DATABASE PROFS TO ARRAY
$professor = [];
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
		
		array_push($professor, "$dbProfId-$dbProfFirstname $dbProfLastname");
	}
}
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>result-of-application-for-evaluation.pdf</title>
	<link rel="stylesheet" href="../css/font-awesome.css">
	<link href="../img/icon.png" rel="icon">
	<link href="../img/icon.png" rel="apple-touch-icon">
	<style>
		* {
			margin: 0;
			padding: 0;
		}
		body {
			background-color: #525659;
		}
		.all-header {
			font-family: Helvetica;
			color: #ffffff;
			position: fixed;
			top: 0;
			height: 56px;
			width: 100%;
			z-index: 1;
			background-color: #323639;
		}
		.all-header span {
			font-size: 14px;
			display: inline-block;
			padding: 19.9px;
		}
		.all-header span:nth-child(1) {
			margin-left: 47px;
		}
		.all-header span:nth-child(2) {
			cursor: pointer;
			position: absolute;
			right: 0;
			margin-right: 30px;
		}
		.all-header span:nth-child(2):hover {
			margin: 7.8px;
			margin-right: 38px;
			padding: 12px;
			border-radius: 50%;
			background-color: #424649;
		}
		.main {
			margin-top: 66px;
		}
		.main-paper {
			min-height: 8.5in;
			height: auto;
			width: 14in;
			margin: auto;
			padding: 0.4in;
			background-color: #ffffff;
		}
		.main-paper div:nth-child(1) span {
			font-family: Arial;
			font-size: 10pt;
			font-weight: bold;
			display: block;
		}
		.main-paper div:nth-child(1) span:nth-child(1) {
			text-transform: uppercase;
		}
		.main-paper .view-body,
		.view-list-footer {
			width: 100%;
			border-spacing: 0;
			border-collapse: collapse;
			margin: auto;
			table-layout: fixed;
			border: 1.5px solid #000000;
			background-color: #ffffff;
		}
		.main-paper .view-body th,
		.main-paper .view-body td,
		.view-list-footer th,
		.view-list-footer td {
			font-family: Arial;
			font-size: 10pt;
			height: 24px;
			width: auto;
		}
		.main-paper .view-body th,
		.view-list-footer th {
			border-bottom: 1.5px solid #000000;
			background-color: #d6dce4;
		}
		.main-paper .view-body td,
		.view-list-footer td {
			padding: 0 3px;
			border-bottom: 1px solid #000000;
		}
		.main-paper .view-body td:nth-child(1),
		.view-list-footer td:nth-child(1) {
			text-align: center;
		}
		.view-footer {
			table-layout: auto;
			border: none;
			margin-top: 20px;
		}
		.view-footer th,
		.view-footer td {
			font-family: Arial;
			font-size: 11pt;
		}
		.view-footer th:nth-child(1) {
			text-align: left;
		}
		.view-footer th:nth-child(1) span,
		.view-footer td:nth-child(1) span {
			margin-left: 30.66px;
		}
		.view-footer td:nth-child(2) {
			width: 297.32px;
		}
		.view-footer td:nth-child(2) span {
			display: block;
			text-align: center;
			width: 162.66px;
		}
		.view-list-footer-header {
			font-family: Arial;
			font-size: 11pt;
			font-weight: bold;
			text-transform: uppercase;
			display: block;
			margin-top: 14.25pt;
		}
		@media print {
			@page {
				size: landscape;
				margin: auto;
			}
			body {
				background-color: transparent;
			}
			.all-header {
				display: none;
			}
			.main {
				margin-top: 0;
			}
			.main-paper {
				min-height: auto;
				width: auto;
				margin: none;
				padding: 0;
			}
		}
	</style>
	<script src="../js/font-awesome.js"></script>
</head>
<body>
	<div class="all-header">
		<span>result-of-application-for-evaluation.pdf</span>
		<span id="print-all-btn" title="Print all"><i class="fas fa-print"></i></span>
	</div>
	<div class="main">
		<div id="main-body" class="main-body">
			<div id="main-paper" class="main-paper">
				<!-- LIST OF QUALIFIED AND WITH QUESTION MARK STUDENTS IN APPLICATION FOR EVALUATION REPORT -->
				<div>
					<span>Result of Final Evaluation</span>
					<span>SY <?php echo date("Y")-1 . "-" . date("Y"); ?></span>
					<?php
					$fileCourse = $activeSheet->getCell("B1")->getValue();
					$select = "SELECT * FROM course WHERE id=$fileCourse";
					$result = $connect -> query($select);
					if ($result -> num_rows > 0) {
						while ($row = mysqli_fetch_array($result)) {
							$course = str_replace("Bachelor of Science", "BS", $row["course"]);
						}
					}
					echo "<span style='display: inline-block;'>$course</span>";
					$fileMajor = $activeSheet->getCell("C1")->getValue();
					if ($fileMajor != "") {
						$select = "SELECT * FROM major WHERE id=$fileMajor";
						$result = $connect -> query($select);
						if ($result -> num_rows > 0) {
							while ($row = mysqli_fetch_array($result)) {
								$major = $row["major"];
								echo "<span style='display: inline-block; margin-left: 5px;'>Major in $major</span>";
							}
						}
					}
					?>
				</div>
				<table class="view-body">
					<tr>
						<th>No.</th>
						<th>Last Name</th>
						<th>First Name</th>
						<th>Middle Name</th>
						<th>Student Number</th>
						<th colspan="2">Enrolled Subject/s</th>
						<th colspan="2">Deficiency/Verification Subject/s</th>
						<th colspan="2">Lack Subject/s</th>
					</tr>
					<?php
					$num = 1;
					for ($row=3; $row<=$highestRow; $row++) {
						$studentnumber = $activeSheet->getCell("B" . $row)->getValue();
						$lastname = ucwords(strtolower($activeSheet->getCell("C" . $row)->getValue()));
						$firstname = ucwords(strtolower($activeSheet->getCell("D" . $row)->getValue()));
						$middlename = ucwords(strtolower($activeSheet->getCell("E" . $row)->getValue()));
						$enrolledsub = explode(", ", $activeSheet->getCell("K" . $row)->getValue());
						$enrolledsubprof = explode(", ", $activeSheet->getCell("L" . $row)->getValue());
						$deficiencysub = $activeSheet->getCell("M" . $row)->getValue();
						if ($deficiencysub != "") {
							$deficiencysub = explode(", ", $deficiencysub);
							$deficiencysubsize = count($deficiencysub);
						}
						else {
							$deficiencysubsize = 0;
						}
						$deficiencysubprof = $activeSheet->getCell("N" . $row)->getValue();
						if ($deficiencysubprof != "") {
							$deficiencysubprof = explode(", ", $deficiencysubprof);
							$deficiencysubprofsize = count($deficiencysubprof);
						}
						else {
							$deficiencysubprofsize = 0;
						}
						$lacksub = $activeSheet->getCell("O" . $row)->getValue();
						if ($lacksub != "") {
							$lacksub = explode(", ", $lacksub);
							$lacksubsize = count($lacksub);
						}
						else {
							$lacksubsize = 0;
						}
						$lacksubprof = $activeSheet->getCell("P" . $row)->getValue();
						if ($lacksubprof != "") {
							$lacksubprof = explode(", ", $lacksubprof);
							$lacksubprofsize = count($lacksubprof);
						}
						else {
							$lacksubprofsize = 0;
						}
						$action = $activeSheet->getCell("X" . $row)->getValue();
						if ($lacksub == "" && $action == "accepted") {
							if ($deficiencysub != "" || $action == "") {
								echo '<tr style="background-color: #ffffcc;">';
							}
							else {
								echo "<tr>";
							}
								echo "<td>$num</td>";
								echo "<td>$lastname</td>";
								echo "<td>$firstname</td>";
								echo "<td>$middlename</td>";
								echo "<td>$studentnumber</td>";
								echo "<td>";
									for ($i=0; $i<count($enrolledsub); $i++) {
										for ($j=0; $j<count($subject); $j++) {
											$split = explode("-", $subject[$j]);
											if ($enrolledsub[$i] == $split[0]) {
												echo "$split[1]<br>";
											}
										}
									}
								echo "</td>";
								echo "<td>";
									for ($i=0; $i<count($enrolledsubprof); $i++) {
										for ($j=0; $j<count($professor); $j++) {
											$split = explode("-", $professor[$j]);
											if ($enrolledsubprof[$i] == $split[0]) {
												echo "$split[1]<br>";
											}
										}
									}
								echo "</td>";
								echo "<td>";
									if ($deficiencysubsize > 0) {
										for ($i=0; $i<$deficiencysubsize; $i++) {
											for ($j=0; $j<count($subject); $j++) {
												$split = explode("-", $subject[$j]);
												if ($deficiencysub[$i] == $split[0]) {
													echo "$split[1]<br>";
												}
											}
										}
									}
								echo "</td>";
								echo "<td>";
									if ($deficiencysubprofsize > 0) {
										for ($i=0; $i<$deficiencysubprofsize; $i++) {
											for ($j=0; $j<count($professor); $j++) {
												$split = explode("-", $professor[$j]);
												if ($deficiencysubprof[$i] == $split[0]) {
													echo "$split[1]<br>";
												}
											}
										}
									}
								echo "</td>";
								echo "<td>";
									if ($lacksubsize > 0) {
										for ($i=0; $i<$lacksubsize; $i++) {
											for ($j=0; $j<count($subject); $j++) {
												$split = explode("-", $subject[$j]);
												if ($lacksub[$i] == $split[0]) {
													echo "$split[1]<br>";
												}
											}
										}
									}
								echo "</td>";
								echo "<td>";
									if ($lacksubprofsize > 0) {
										for ($i=0; $i<$lacksubprofsize; $i++) {
											for ($j=0; $j<count($professor); $j++) {
												$split = explode("-", $professor[$j]);
												if ($lacksubprof[$i] == $split[0]) {
													echo "$split[1]<br>";
												}
											}
										}
									}
								echo "</td>";
							echo "</tr>";
							$num = $num + 1;
						}
					}
					?>
				</table>
				<!-- SUMMARY REPORT OF APPLICATION FOR EVALUATION -->
				<table class="view-footer">
					<tr>
						<th>
							<span>Summary Report</span>
						</th>
					</tr>
					<tr>
						<td>
							<span>No. of Students Qualified for College Deliberation</span>
						</td>
						<td>
							<span>
								<?php
								$i = 0;
								for ($row=3; $row<=$highestRow; $row++) {
									$deficiencysub = $activeSheet->getCell("M" . $row)->getValue();
									$lacksub = $activeSheet->getCell("O" . $row)->getValue();
									$action = $activeSheet->getCell("X" . $row)->getValue();
									if ($deficiencysub == "" && $lacksub == "" && $action == "accepted") {
										$i = $i + 1;
									}
								}
								echo $i;
								?>
							</span>
						</td>
					</tr>
					<tr>
						<td>
							<span>No. of Students with Question Mark</span>
						</td>
						<td>
							<span>
								<?php
								$i = 0;
								for ($row=3; $row<=$highestRow; $row++) {
									$deficiencysub = $activeSheet->getCell("M" . $row)->getValue();
									$lacksub = $activeSheet->getCell("O" . $row)->getValue();
									$action = $activeSheet->getCell("X" . $row)->getValue();
									if ($deficiencysub != "" && $lacksub == "" && $action == "accepted") {
										$i = $i + 1;
									}
								}
								echo $i;
								?>
							</span>
						</td>
					</tr>
					<tr>
						<td>
							<span>No. of Student/s Remove from the List</span>
						</td>
						<td>
							<span style="border-bottom: 1px solid #000000;">
								<?php
								$i = 0;
								for ($row=3; $row<=$highestRow; $row++) {
									$lacksub = $activeSheet->getCell("O" . $row)->getValue();
									$action = $activeSheet->getCell("X" . $row)->getValue();
									if ($lacksub != "" || $action == "rejected") {
										$i = $i + 1;
									}
								}
								echo $i;
								?>
							</span>
						</td>
					</tr>
					<tr>
						<th style="text-align: right;">
							<span>Total:</span>
						</th>
						<td>
							<?php
							$total = 0;
							for ($row=3; $row<=$highestRow; $row++) {
								$action = $activeSheet->getCell("X" . $row)->getValue();
								if ($action != "") {
									$total = $total + 1;
								}
							}
							echo "<span>$total</span>";
							?>
						</td>
					</tr>
				</table>
				<!-- LIST OF STUDENT REMOVED FROM LIST IN APPLICATION FOR EVALUATION -->
				<span class="view-list-footer-header">List of Student Removed From List</span>
				<table class="view-list-footer">
					<tr>
						<th>No.</th>
						<th>Last Name</th>
						<th>First Name</th>
						<th>Middle Name</th>
						<th>Student Number</th>
						<th colspan="2">Enrolled Subject/s</th>
						<th colspan="2">Deficiency/Verification Subject/s</th>
						<th colspan="2">Lack Subject/s</th>
					</tr>
					<?php
					$num = 1;
					for ($row=3; $row<=$highestRow; $row++) {
						$studentnumber = $activeSheet->getCell("B" . $row)->getValue();
						$lastname = ucwords(strtolower($activeSheet->getCell("C" . $row)->getValue()));
						$firstname = ucwords(strtolower($activeSheet->getCell("D" . $row)->getValue()));
						$middlename = ucwords(strtolower($activeSheet->getCell("E" . $row)->getValue()));
						$enrolledsub = explode(", ", $activeSheet->getCell("K" . $row)->getValue());
						$enrolledsubprof = explode(", ", $activeSheet->getCell("L" . $row)->getValue());
						$deficiencysub = $activeSheet->getCell("M" . $row)->getValue();
						if ($deficiencysub != "") {
							$deficiencysub = explode(", ", $deficiencysub);
							$deficiencysubsize = count($deficiencysub);
						}
						else {
							$deficiencysubsize = 0;
						}
						$deficiencysubprof = $activeSheet->getCell("N" . $row)->getValue();
						if ($deficiencysubprof != "") {
							$deficiencysubprof = explode(", ", $deficiencysubprof);
							$deficiencysubprofsize = count($deficiencysubprof);
						}
						else {
							$deficiencysubprofsize = 0;
						}
						$lacksub = $activeSheet->getCell("O" . $row)->getValue();
						if ($lacksub != "") {
							$lacksub = explode(", ", $lacksub);
							$lacksubsize = count($lacksub);
						}
						else {
							$lacksubsize = 0;
						}
						$lacksubprof = $activeSheet->getCell("P" . $row)->getValue();
						if ($lacksubprof != "") {
							$lacksubprof = explode(", ", $lacksubprof);
							$lacksubprofsize = count($lacksubprof);
						}
						else {
							$lacksubprofsize = 0;
						}
						$action = $activeSheet->getCell("X" . $row)->getValue();

						if ($lacksub != "" || $action == "rejected") {
							echo "<tr>";
								echo "<td>$num</td>";
								echo "<td>$lastname</td>";
								echo "<td>$firstname</td>";
								echo "<td>$middlename</td>";
								echo "<td>$studentnumber</td>";
								echo "<td>";
									for ($i=0; $i<count($enrolledsub); $i++) {
										for ($j=0; $j<count($subject); $j++) {
											$split = explode("-", $subject[$j]);
											if ($enrolledsub[$i] == $split[0]) {
												echo "$split[1]<br>";
											}
										}
									}
								echo "</td>";
								echo "<td>";
									for ($i=0; $i<count($enrolledsubprof); $i++) {
										for ($j=0; $j<count($professor); $j++) {
											$split = explode("-", $professor[$j]);
											if ($enrolledsubprof[$i] == $split[0]) {
												echo "$split[1]<br>";
											}
										}
									}
								echo "</td>";
								echo "<td>";
									if ($deficiencysubsize > 0) {
										for ($i=0; $i<$deficiencysubsize; $i++) {
											for ($j=0; $j<count($subject); $j++) {
												$split = explode("-", $subject[$j]);
												if ($deficiencysub[$i] == $split[0]) {
													echo "$split[1]<br>";
												}
											}
										}
									}
								echo "</td>";
								echo "<td>";
									if ($deficiencysubprofsize > 0) {
										for ($i=0; $i<$deficiencysubprofsize; $i++) {
											for ($j=0; $j<count($professor); $j++) {
												$split = explode("-", $professor[$j]);
												if ($deficiencysubprof[$i] == $split[0]) {
													echo "$split[1]<br>";
												}
											}
										}
									}
								echo "</td>";
								echo "<td>";
									if ($lacksubsize > 0) {
										for ($i=0; $i<$lacksubsize; $i++) {
											for ($j=0; $j<count($subject); $j++) {
												$split = explode("-", $subject[$j]);
												if ($lacksub[$i] == $split[0]) {
													echo "$split[1]<br>";
												}
											}
										}
									}
								echo "</td>";
								echo "<td>";
									if ($lacksubprofsize > 0) {
										for ($i=0; $i<$lacksubprofsize; $i++) {
											for ($j=0; $j<count($professor); $j++) {
												$split = explode("-", $professor[$j]);
												if ($lacksubprof[$i] == $split[0]) {
													echo "$split[1]<br>";
												}
											}
										}
									}
								echo "</td>";
							echo "</tr>";
							$num = $num + 1;
						}
					}
					?>
				</table>
			</div>
		</div>
	</div>
	<script>
		document.getElementById("print-all-btn").addEventListener("click", function() {
			window.print();
		});
	</script>
	<script>
		var viewportWidth = document.documentElement.clientWidth;
		var mainPaper = document.getElementById("main-paper");
		if (mainPaper.offsetWidth > viewportWidth) {
			var fixedWidth = (viewportWidth/(mainPaper.offsetWidth + 20))*100;
			mainPaper.style.zoom = fixedWidth + "%";
		}
	</script>
</body>
</html>