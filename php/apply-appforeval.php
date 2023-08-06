<?php
//FOR MANUAL SUBMITION OF APPLICATION FOR EVALUATION
include "connect.php";
require "../vendor/autoload.php";

use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;

$filename = $_COOKIE["application-for-evaluation-file"];
$spreadsheet = IOFactory::load("../uploads/application-for-evaluation/$filename");
$activeSheet = $spreadsheet->getActiveSheet();
$highestRow = $activeSheet->getHighestDataRow();
$rowNumber = $highestRow + 1;

$emailaddress = $_POST["email-address"];
$studentnumber = $_POST["student-number"];
$lastname = $_POST["last-name"];
$firstname = $_POST["first-name"];
$middlename = $_POST["middle-name"];
$contactnumber = $_POST["contact-number"];
$permanentaddress = $_POST["permanent-address"];
$birthday = $_POST["birthday"];
$birthplace = $_POST["birth-place"];
$guardian = $_POST["guardian-name"];

//DECLARE ARRAYS
$allSubjects = [];
$subjects = [];
$enrolledSubProfs = [];
$deficiencysubjects = [];
$deficiencySubProfs = [];
$lacksubjects = [];
$lackSubProfs = [];

//ADD FILE'S STUDENT NUMBERS TO ARRAY
$studentNumbers = [];
for ($row=3; $row<=$highestRow; $row++) {
	$fileStudentNumber = $activeSheet->getCell("B" . $row)->getValue();
	array_push($studentNumbers, $fileStudentNumber);
}

if ($studentnumber == "") {
	echo "Please input Student Number.";
}
else if (strpos($studentnumber, "-") === false) {
	echo "Invalid format of Student Number, must inclue hypen (-).";
}
else if ($lastname == "") {
	echo "Please input Last Name";
}
else if ($firstname == "") {
	echo "Please input First Name";
}
else if (in_array($studentnumber, $studentNumbers)) {
	echo "Student number already exists.";
}
else {
	//ENROLLED SUBJECTS
	if (isset($_POST["subject"])) {
		$subject = $_POST["subject"];
		$subjectSize = count($subject);
		if ($subjectSize != 0) {
			for ($i=0; $i<$subjectSize; $i++) {
				if ($subject[$i] > 0) {
					array_push($subjects, $subject[$i]);
					array_push($allSubjects, $subject[$i]);
				}
			}
		}
	}
	else {
		$subjectSize = 0;
	}
	//ENROLLED SUBJECTS PROFESSOR
	if (isset($_POST["enrolled-subject-professor"])) {
		$enrolledSubProf = $_POST["enrolled-subject-professor"];
		$enrolledSubProfSize = count($enrolledSubProf);
		for ($i=0; $i<$enrolledSubProfSize; $i++) {
			if ($enrolledSubProf[$i] > 0) {
				array_push($enrolledSubProfs, $enrolledSubProf[$i]);
			}
		}
	}
	//ADDED ENROLLED SUBJECTS
	if (isset($_POST["added-enrolled-subject"])) {
		$addedEnrSub = $_POST["added-enrolled-subject"];
		$addedEnrSubSize = count($addedEnrSub);
		if ($addedEnrSubSize != 0) {
			for ($i=0; $i<$addedEnrSubSize; $i++) {
				if ($addedEnrSub[$i] > 0) {
					$split = explode("-", $addedEnrSub[$i]);
					array_push($subjects, $split[0]);
					array_push($allSubjects, $split[0]);
					array_push($enrolledSubProfs, $split[1]);
				}
			}
		}
	}
	else {
		$addedEnrSubSize = 0;
	}

	//ADDED DEFICIENCY/VERIFICATION SUBJECTS
	if (isset($_POST["added-deficiency-verification-subject"])) {
		$addedDefVerSub = $_POST["added-deficiency-verification-subject"];
		$addedDefVerSubSize = count($addedDefVerSub);
		if ($addedDefVerSubSize != 0) {
			for ($i=0; $i<$addedDefVerSubSize; $i++) {
				if ($addedDefVerSub[$i] > 0) {
					$split = explode("-", $addedDefVerSub[$i]);
					array_push($deficiencysubjects, $split[0]);
					array_push($allSubjects, $split[0]);
					array_push($deficiencySubProfs, $split[1]);
				}
			}
		}
	}
	else {
		$addedDefVerSubSize = 0;
	}

	//ADDED LACK SUBJECTS
	if (isset($_POST["added-lack-subject"])) {
		$addedLackSub = $_POST["added-lack-subject"];
		$addedLackSubSize = count($addedLackSub);
		if ($addedLackSubSize != 0) {
			for ($i=0; $i<$addedLackSubSize; $i++) {
				if ($addedLackSub[$i] > 0) {
					$split = explode("-", $addedLackSub[$i]);
					array_push($lacksubjects, $split[0]);
					if (!in_array($split[0], $subjects)) {
						array_push($allSubjects, $split[0]);
					}
					array_push($lackSubProfs, $split[1]);
				}
			}
		}
	}
	else {
		$addedLackSubSize = 0;
	}

	//CHECK IF SUBJECT WAS DUPLICATED
	$duplicateSubjects = array_unique(array_diff_assoc($allSubjects, array_unique($allSubjects)));

	if ($subjectSize == 0 && $addedEnrSubSize == 0) {
		echo "Please select/add enrolled subject/s.";
	}
	else if ($subjectSize > 0 && count($enrolledSubProfs) == 0) {
		echo "Please select subject professor in your enrolled subject.";
	}
	else if (count($duplicateSubjects) > 0) {
		echo "You have selected duplicate subject.";
	}
	else {
		$activeSheet->setCellValue("A" . $rowNumber, $emailaddress);
		$activeSheet->setCellValue("B" . $rowNumber, $studentnumber);
		$activeSheet->setCellValue("C" . $rowNumber, $lastname);
		$activeSheet->setCellValue("D" . $rowNumber, $firstname);
		$activeSheet->setCellValue("E" . $rowNumber, $middlename);
		$activeSheet->setCellValue("F" . $rowNumber, $contactnumber);
		$activeSheet->setCellValue("G" . $rowNumber, $permanentaddress);
		$activeSheet->setCellValue("H" . $rowNumber, $birthday);
		$activeSheet->setCellValue("I" . $rowNumber, $birthplace);
		$activeSheet->setCellValue("J" . $rowNumber, $guardian);
		$activeSheet->setCellValue("K" . $rowNumber, implode(", ", $subjects));
		$activeSheet->setCellValue("L" . $rowNumber, implode(", ", $enrolledSubProfs));
		if ($addedDefVerSubSize > 0) {
			$activeSheet->setCellValue("M" . $rowNumber, implode(", ", $deficiencysubjects));
			$activeSheet->setCellValue("N" . $rowNumber, implode(", ", $deficiencySubProfs));
		}
		if ($addedLackSubSize > 0) {
			$activeSheet->setCellValue("O" . $rowNumber, implode(", ", $lacksubjects));
			$activeSheet->setCellValue("P" . $rowNumber, implode(", ", $lackSubProfs));
		}
		//$activeSheet->setCellValue("K" . $rowNumber, implode("\n", $subjects));
		//$activeSheet->getStyle("K" . $rowNumber)->getAlignment()->setWrapText(true);
		$writer = IOFactory::createWriter($spreadsheet, "Xlsx");
		$writer->save("../uploads/application-for-evaluation/$filename");
		echo "Successfully applied student in Application for Evaluation.";
	}
}
?>