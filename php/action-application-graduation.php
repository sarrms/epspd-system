<?php
$file = $_COOKIE["application-for-graduation-file"];
require "../vendor/autoload.php";

use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Cell\Coordinate;

$spreadsheet = IOFactory::load("../uploads/application-for-graduation/$file");
$sheet = $spreadsheet->getActiveSheet();

$rows = $_POST["rows"];
foreach ($rows as $row) {
	if ($_POST["action"] == "accept") {
		$sheet->setCellValue("AB" . $row, "accepted");
	}
	else {
		$sheet->setCellValue("AB" . $row, "rejected");
	}
}

$writer = IOFactory::createWriter($spreadsheet, "Xlsx");
$savePath = "../uploads/application-for-graduation/$file";
$writer->save($savePath);
?>