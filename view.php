<?php
date_default_timezone_set("Asia/Manila");
include "php/connect.php";
include "vendor/autoload.php";

use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Cell\Coordinate;

if (isset($_GET["view"])) {
	$view = $_GET["view"];
}
else {
	echo "Import/Select file first.";
}

$reader = IOFactory::createReader("Xlsx");
if (isset($_GET["view"])) {
	$view = $_GET["view"];
	if ($view == "application-for-evaluation") {
		$fileName = $_COOKIE["application-for-evaluation-file"];
		$file = $reader->load("uploads/application-for-evaluation/$fileName");
	}
	else if ($view == "final-evaluation-result-form") {
		$fileName = $_COOKIE["final-evaluation-result-form-file"];
		$file = $reader->load("uploads/final-evaluation-result-form/$fileName");
	}
	else if ($view == "application-for-graduation"  || $view == "list-of-graduates" || $view == "create-diploma") {
		$fileName = $_COOKIE["application-for-graduation-file"];
		$file = $reader->load("uploads/application-for-graduation/$fileName");
	}
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

//CONVERT DATABASE COURSES TO ARRAY
$course = [];
$select = "SELECT * FROM course ORDER BY id ASC";
$result = $connect -> query($select);
if ($result -> num_rows > 0) {
	while ($row = mysqli_fetch_array($result)) {
		$dbCourseId = $row["id"];
		$dbCourse = $row["course"];

		array_push($course, "$dbCourseId-$dbCourse");
	}
}
//CONVERT DATABASE TAGALOG COURSES TO ARRAY
$kurso = [];
$select = "SELECT * FROM kurso ORDER BY id ASC";
$result = $connect -> query($select);
if ($result -> num_rows > 0) {
	while ($row = mysqli_fetch_array($result)) {
		$dbKursoId = $row["id"];
		$dbKurso = $row["course"];

		array_push($kurso, "$dbKursoId-$dbKurso");
	}
}
$major = [];
$select = "SELECT * FROM major ORDER BY id ASC";
$result = $connect -> query($select);
if ($result -> num_rows > 0) {
	while ($row = mysqli_fetch_array($result)) {
		$dbMajorId = $row["id"];
		$dbMajor = $row["major"];

		array_push($major, "$dbMajorId-$dbMajor");
	}
}
$medyor = [];
$select = "SELECT * FROM medyor ORDER BY id ASC";
$result = $connect -> query($select);
if ($result -> num_rows > 0) {
	while ($row = mysqli_fetch_array($result)) {
		$dbMedyorId = $row["id"];
		$dbMedyor = $row["major"];

		array_push($medyor, "$dbMedyorId-$dbMedyor");
	}
}
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
//GET COLLEGE FROM FILE
$fileCollegeId = $activeSheet->getCell("A1")->getValue();
$select = "SELECT * FROM college WHERE id=$fileCollegeId";
$result = $connect -> query($select);
if ($result -> num_rows > 0) {
	while ($row = mysqli_fetch_array($result)) {
		$college = $row["college"];
	}
}
//GET COURSE FROM FILE
$fileCourse = $activeSheet->getCell("B1")->getValue();
$select = "SELECT * FROM course WHERE id=$fileCourse";
$result = $connect -> query($select);
if ($result -> num_rows > 0) {
	while ($row = mysqli_fetch_array($result)) {
		$courseText = str_replace("Bachelor of Science", "BS", $row["course"]);
	}
}
//GET MAJOR FROM FILE
$fileMajor = $activeSheet->getCell("C1")->getValue();
if ($fileMajor != "") {
	$select = "SELECT * FROM major WHERE id=$fileMajor";
	$result = $connect -> query($select);
	if ($result -> num_rows > 0) {
		while ($row = mysqli_fetch_array($result)) {
			$dbmajor = $row["major"];
			$majorText = "Major in $dbMajor";
		}
	}
}
else {
	$majorText = "";
}
//GET PRESIDENT FROM DATABASE
$select = "SELECT * FROM head WHERE position='president'";
$result = $connect -> query($select);
if ($result -> num_rows > 0) {
	while ($row = mysqli_fetch_array($result)) {
		$president = $row["name"];
	}
}
//GET REGISTRAR FROM DATABASE
$select = "SELECT * FROM head WHERE position='registrar'";
$result = $connect -> query($select);
if ($result -> num_rows > 0) {
	while ($row = mysqli_fetch_array($result)) {
		$registrar = $row["name"];
	}
}
//GET DEAN FROM DATABASE
$select = "SELECT * FROM dean WHERE college=$fileCollegeId";
$result = $connect -> query($select);
if ($result -> num_rows > 0) {
	while ($row = mysqli_fetch_array($result)) {
		$dean = $row["dean"];
	}
}
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title><?php echo $view; ?>.pdf</title>
	<link href="img/icon.png" rel="icon">
	<link href="img/icon.png" rel="apple-touch-icon">
	<?php
	if ($view == "application-for-evaluation") {
		echo '<link rel="stylesheet" href="css/paper-application-evaluation.css?v=1.0">';
	}
	if ($view == "final-evaluation-result-form") {
		echo '<link rel="stylesheet" href="css/paper-final-evaluation.css?v=1.0">';
	}
	else if ($view == "application-for-graduation") {
		echo '<link rel="stylesheet" href="css/paper-application-graduation.css?v=1.0">';
	}
	else if ($view == "list-of-graduates") {
		echo '<link rel="stylesheet" href="css/paper-list-graduates.css?v=1.0">';
	}
	else if ($view == "create-diploma") {
		echo '<link rel="stylesheet" href="css/diploma.css">';
	}
	?>
	<link rel="stylesheet" href="css/style.css?v=1.0">
	<link rel="stylesheet" href="css/font-awesome.css?v=1.0">
	<style>
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
		.paper {
			height: 11.69in;
		}
		@media print {
			body {
				background-color: #ffffff;
			}
			.main {
				<?php
				if ($view == "create-diploma") {
					echo "width: auto;";
				}
				else {
					echo "width: 8.27in;";
				}
				?>
				margin-top: 0;
			}
			.all-header {
				display: none;
			}
			.paper {
				height: auto;
			}
			.diploma {
				margin-left: 0;
			}
		}
	</style>
	<script src="js/font-awesome.js"></script>
</head>
<body>
	<div class="all-header">
		<span><?php echo "$view.pdf"; ?></span>
		<span id="print-all-btn" title="Print all"><i class="fas fa-print"></i></span>
	</div>
	<div class="main">
		<div id="main-body" class="main-body">
			<div id="main-paper">
				<?php
				//APPLICATION FOR EVALUATION
				if ($view =="application-for-evaluation") {
					$username = $_COOKIE["evaluation-process"];
					$select = "SELECT * FROM user WHERE username='$username'";
					$result = $connect -> query($select);
					if ($result -> num_rows > 0) {
						while ($row = mysqli_fetch_array($result)) {
							$evaluator = $row["name"];
						}
					}
					for ($row=3; $row<=$highestRow; $row++) {
						$action = $activeSheet->getCell("W" . $row)->getValue();
						if ($action == "accepted" && $action != "") {
							include "php/all-application-evaluation.php";
						}
					}
				}
				//FINAL EVALUATION RESULT FORM
				else if ($view =="final-evaluation-result-form") {
					$username = $_COOKIE["evaluation-process"];
					$select = "SELECT * FROM user WHERE username='$username'";
					$result = $connect -> query($select);
					if ($result -> num_rows > 0) {
						while ($row = mysqli_fetch_array($result)) {
							$evaluator = $row["name"];
						}
					}
					
					$select = "SELECT * FROM course WHERE id=$fileCourse";
					$result = $connect -> query($select);
					if ($result -> num_rows > 0) {
						while ($row = mysqli_fetch_array($result)) {
							$courseacro = $row["acronym"];
						}
					}

					for ($row=3; $row<=$highestRow; $row++) {
						$action = $activeSheet->getCell("X" . $row)->getValue();
						if ($action == "accepted" && $action != "") {
							include "php/all-final-evaluation-result-form.php";
						}
					}
				}
				//APPLICATION FOR GRADUATION
				else if ($view =="application-for-graduation") {
					$number = 1;
					for ($row=3; $row<=$highestRow; $row++) {
						$action = $activeSheet->getCell("AB" . $row)->getValue();
						if ($action == "accepted") {
							include "php/all-application-graduation.php";
						}
					}
				}
				//LIST OF GRADUATES
				else if ($view =="list-of-graduates") {
					$number = 1;
					include "php/all-list-graduates.php";
				}
				//CREATE DIPLOMA
				else if ($view =="create-diploma") {
					//SPLIT ARRAY ENGLISH COURSE
					for ($j=0; $j<count($course); $j++) {
						$split = explode("-", $course[$j]);
						if ($fileCourse == $split[0]) {
							$courseEn = $split[1];
						}
					}
					//SPLIT ARRAY TAGALOG COURSE
					for ($j=0; $j<count($kurso); $j++) {
						$split = explode("-", $kurso[$j]);
						if ($fileCourse == $split[0]) {
							$courseTl = $split[1];
						}
					}
					if ($fileMajor != "") {
						for ($j=0; $j<count($major); $j++) {
							$split = explode("-", $major[$j]);
							if ($fileMajor == $split[0]) {
								$majorEn = $split[1];
							}
						}
						for ($j=0; $j<count($medyor); $j++) {
							$split = explode("-", $medyor[$j]);
							if ($fileMajor == $split[0]) {
								$majorTl = $split[1];
							}
						}
					}
					else {
						$majorEn = "";
						$majorTl = "";
					}
					if ($fileMajor == "") {
						echo '<link rel="stylesheet" href="css/diploma1.css?v=1.0">';
					}
					$diplomaFormat = $reader->load("format/bachelor-diploma.xlsx");
					$formatSheet = $diplomaFormat->getActiveSheet();

					$row1 = $formatSheet->getCell("A1")->getValue();
					$row2 = $formatSheet->getCell("A2")->getValue();
					$row3 = $formatSheet->getCell("A3")->getValue();
					$row4 = $formatSheet->getCell("A4")->getValue();
					$row5 = $formatSheet->getCell("A5")->getValue();
					$row6 = $formatSheet->getCell("A6")->getValue();
					$row7 = $formatSheet->getCell("A7")->getValue();
					$row8 = $formatSheet->getCell("A8")->getValue();
					$row9 = $formatSheet->getCell("A9")->getValue();
					$row10 = $formatSheet->getCell("A10")->getValue();
					$row11 = $formatSheet->getCell("A11")->getValue();
					$row12 = $formatSheet->getCell("A12")->getValue();
					$row13 = $formatSheet->getCell("A13")->getValue();
					$row14 = $formatSheet->getCell("A14")->getValue();
					$row16 = $formatSheet->getCell("A16")->getValue();
					$row17 = $formatSheet->getCell("A17")->getValue();
					$row22 = $formatSheet->getCell("A22")->getValue();
					$row23 = $formatSheet->getCell("A23")->getValue();
					$row24 = $formatSheet->getCell("A24")->getValue();
					$row25 = $formatSheet->getCell("A25")->getValue();
					$row26 = $formatSheet->getCell("A26")->getValue();
					$row27 = $formatSheet->getCell("A27")->getValue();
					$row28 = $formatSheet->getCell("A28")->getValue();
					$row29 = $formatSheet->getCell("A29")->getValue();
					for ($row=3; $row<=$highestRow; $row++) {
						include "php/all-diploma.php";
					}	
				}
				?>
			</div>
		</div>
	</div>
	<script>
		document.getElementById("print-all-btn").addEventListener("click", function() {
			window.print();
		});
	</script>
</body>
</html>