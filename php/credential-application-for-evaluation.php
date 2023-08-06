<?php
$file = $_COOKIE["application-for-evaluation-file"];
require "../vendor/autoload.php";

use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Cell\Coordinate;

$spreadsheet = IOFactory::load("../uploads/application-for-evaluation/" . $file);
$sheet = $spreadsheet->getActiveSheet();

$row = $_POST["row"];
$cbvalue = $_POST["checkbox"];
$checkbox = $_POST["checkboxnum"];

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
$savePath = "../uploads/application-for-evaluation/" . $file;
$writer->save($savePath);
?>