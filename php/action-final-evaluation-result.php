<?php
$file = $_COOKIE["final-evaluation-result-form-file"];
require "../vendor/autoload.php";

use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Cell\Coordinate;

$spreadsheet = IOFactory::load("../uploads/final-evaluation-result-form/$file");
$sheet = $spreadsheet->getActiveSheet();

$rows = $_POST["rows"];
foreach ($rows as $row) {
	if ($_POST["action"] == "accept") {
		$sheet->setCellValue("X" . $row, "accepted");
	}
	else {
		$sheet->setCellValue("X" . $row, "rejected");
	}
}

$writer = IOFactory::createWriter($spreadsheet, "Xlsx");
$savePath = "../uploads/final-evaluation-result-form/$file";
$writer->save($savePath);
?>