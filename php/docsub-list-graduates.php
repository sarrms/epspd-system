<?php
$file = $_COOKIE["application-for-graduation-file"];
require "../vendor/autoload.php";

use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Cell\Coordinate;

$spreadsheet = IOFactory::load("../uploads/application-for-graduation/$file");
$sheet = $spreadsheet->getActiveSheet();

$row = $_POST["row"];
$col = $_POST["column"];
$val = $_POST["value"];

$sheet->setCellValue($col . $row, $val);

$writer = IOFactory::createWriter($spreadsheet, "Xlsx");
$savePath = "../uploads/application-for-graduation/$file";
$writer->save($savePath);
?>