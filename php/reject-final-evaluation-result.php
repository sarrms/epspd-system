<?php
$file = $_COOKIE["final-evaluation-result-form-file"];
require "../vendor/autoload.php";

use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Cell\Coordinate;

$spreadsheet = IOFactory::load("../uploads/final-evaluation-result-form/" . $file);
$sheet = $spreadsheet->getActiveSheet();

$row = $_POST["row"];
$sheet->setCellValue("X" . $row, "rejected");
$writer = IOFactory::createWriter($spreadsheet, "Xlsx");
$savePath = "../uploads/final-evaluation-result-form/" . $file;
$writer->save($savePath);
clearstatcache(true, $savePath);
if (file_exists($savePath)) {
	echo "success";
}
else {
	echo "Failed to reject application.";
}
?>