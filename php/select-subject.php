<?php
include "connect.php";
require "../vendor/autoload.php";

use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;

$filename = $_COOKIE["application-for-evaluation-file"];
$spreadsheet = IOFactory::load("../uploads/application-for-evaluation/$filename");
$activeSheet = $spreadsheet->getActiveSheet();

$course = $activeSheet->getCell("B1")->getValue();

$textContent = [];
$optionValue = [];
$select = "SELECT * FROM subject ORDER BY code";
$result = $connect -> query($select);
if ($result -> num_rows > 0) {
	while ($row = mysqli_fetch_array($result)) {
		$subjectid = $row["id"];
		$subjectcode = $row["code"];
		$subjecttitle = $row["title"];
		
		$select1 = "SELECT * FROM coursesubject WHERE course=$course AND yearlevel!=4 OR semester!=2";
		$result1 = $connect -> query($select1);
		if ($result1 -> num_rows > 0) {
			while ($row1 = mysqli_fetch_array($result1)) {
				$subjectid1 = $row1["subject"];
				
				if ($subjectid == $subjectid1) {
					$select2 = "SELECT * FROM subjectprofessor WHERE subject=$subjectid1";
					$result2 = $connect -> query($select2);
					if ($result2 -> num_rows > 0) {
						while ($row2 = mysqli_fetch_array($result2)) {
							$professorid = $row2["professor"];

							$select3 = "SELECT * FROM professor WHERE id=$professorid";
							$result3 = $connect -> query($select3);
							if ($result3 -> num_rows > 0) {
								while ($row3 = mysqli_fetch_array($result3)) {
									$lastname = $row3["lastname"];
									$firstname = $row3["firstname"];
									$mname = $row3["middlename"];
									if ($mname != "") {
										$middlename = substr($mname, 0, 1) . ".";
									}
									else {
										$middlename = "";
									}

									array_push($textContent, "$subjectcode - $subjecttitle - $lastname, $firstname $middlename");
									array_push($optionValue, "$subjectid-$professorid");
								}
							}
						}
					}	
				}
			}
		}
	}
}

$response = array(
	"textContent" => $textContent,
	"optionValue" => $optionValue
);
echo json_encode($response);
?>