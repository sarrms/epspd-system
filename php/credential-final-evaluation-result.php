<?php
$file = $_COOKIE["final-evaluation-result-form-file"];
require "../vendor/autoload.php";

use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Cell\Coordinate;

$spreadsheet = IOFactory::load("../uploads/final-evaluation-result-form/" . $file);
$sheet = $spreadsheet->getActiveSheet();

$row = $_POST["row"];
$checkbox = $_POST["checkboxnum"];
if ($checkbox == "checkbox5") {
	$cb5value = $_POST["checkbox"];
	$fileCb5Value = $sheet->getCell("U" . $row)->getValue();
	if ($fileCb5Value == "") {
		$explode = [];
	}
	else {
		$explode = explode(", ", $fileCb5Value);
	}
	
	if ($cb5value == 1) {
		if (in_array("CWTS 1", $explode)) {
			$index = array_search("CWTS 1", $explode);
			unset($explode[$index]);
		}
		else {
			array_push($explode, "CWTS 1");
		}
	}
	else if ($cb5value == 2) {
		if (in_array("CWTS 2", $explode)) {
			$index = array_search("CWTS 2", $explode);
			unset($explode[$index]);
		}
		else {
			array_push($explode, "CWTS 2");
		}
	}
	else if ($cb5value == 3) {
		if (in_array("MTS 1", $explode)) {
			$index = array_search("MTS 1", $explode);
			unset($explode[$index]);
		}
		else {
			array_push($explode, "MTS 1");
		}
	}
	else if ($cb5value == 4) {
		if (in_array("MTS 2", $explode)) {
			$index = array_search("MTS 2", $explode);
			unset($explode[$index]);
		}
		else {
			array_push($explode, "MTS 2");
		}
	}

	$cbvalue = implode(", ", $explode);
}
else {
	$cbvalue = $_POST["checkbox"];
}

if ($checkbox == "checkbox1") {
	$column = "Q";
}
else if ($checkbox == "checkbox2") {
	$column = "R";
}
else if ($checkbox == "checkbox3") {
	$column = "S";
}
else if ($checkbox == "checkbox4") {
	$column = "T";
}
else if ($checkbox == "checkbox5") {
	$column = "U";
}
else if ($checkbox == "checkbox6") {
	$column = "V";
}

$sheet->setCellValue($column . $row, $cbvalue);
$writer = IOFactory::createWriter($spreadsheet, "Xlsx");
$savePath = "../uploads/final-evaluation-result-form/" . $file;
$writer->save($savePath);
?>