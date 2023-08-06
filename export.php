<?php
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Cell\Coordinate;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

include "vendor/autoload.php";

$type = $_GET["type"];
if ($type == "application-for-evaluation") {
	$fileName = $_COOKIE["application-for-evaluation-file"];
	$spreadsheet = IOFactory::load("uploads/application-for-evaluation/$fileName");
	$activeSheet = $spreadsheet->getActiveSheet();

	$writer = IOFactory::createWriter($spreadsheet, "Xlsx");

	header('Content-Type: application/octet-stream');
	header('Content-Disposition: attachment; filename="' . $fileName . '"');

	$writer->save("php://output");
}
else if ($type == "final-evaluation-result-form") {
	$fileName = $_COOKIE["final-evaluation-result-form-file"];
	$spreadsheet = IOFactory::load("uploads/final-evaluation-result-form/$fileName");
	$activeSheet = $spreadsheet->getActiveSheet();

	$writer = IOFactory::createWriter($spreadsheet, "Xlsx");

	header('Content-Type: application/octet-stream');
	header('Content-Disposition: attachment; filename="' . $fileName . '"');

	$writer->save("php://output");
}
else if ($type == "application-for-graduation") {
	$fileName = $_COOKIE["application-for-graduation-file"];
	$spreadsheet = IOFactory::load("uploads/application-for-graduation/$fileName");
	$activeSheet = $spreadsheet->getActiveSheet();

	$writer = IOFactory::createWriter($spreadsheet, "Xlsx");

	header('Content-Type: application/octet-stream');
	header('Content-Disposition: attachment; filename="' . $fileName . '"');

	$writer->save("php://output");
}
?>