<?php
$file = $_COOKIE["final-evaluation-result-form-file"];
require "../vendor/autoload.php";

use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Cell\Coordinate;

$spreadsheet = IOFactory::load("../uploads/final-evaluation-result-form/" . $file);
$sheet = $spreadsheet->getActiveSheet();

$row = $_POST["row"];
$details = $_POST["detail"];

$sheet->setCellValue("W" . $row, $details);
$writer = IOFactory::createWriter($spreadsheet, "Xlsx");
$savePath = "../uploads/final-evaluation-result-form/" . $file;
$writer->save($savePath);
?>