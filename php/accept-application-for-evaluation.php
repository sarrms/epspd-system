<?php
$file = $_COOKIE["application-for-evaluation-file"];
require "../vendor/autoload.php";

use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Cell\Coordinate;

$spreadsheet = IOFactory::load("../uploads/application-for-evaluation/" . $file);
$sheet = $spreadsheet->getActiveSheet();

$row = $_POST["row"];
$sheet->setCellValue("W" . $row, "accepted");
$writer = IOFactory::createWriter($spreadsheet, "Xlsx");
$savePath = "../uploads/application-for-evaluation/" . $file;
$writer->save($savePath);
clearstatcache(true, $savePath);
if (file_exists($savePath)) {
	echo "success";
}
else {
	echo "Failed to accept application.";
}
?>