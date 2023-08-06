<?php
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Cell\Coordinate;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

include "../vendor/autoload.php";

$from = $_POST["from"];
$to = $_POST["to"];

if ($from == "application-for-evaluation") {
	$fileName = $_COOKIE["application-for-evaluation-file"];
	$spreadsheet = IOFactory::load("../uploads/$from/$fileName");
	$activeSheet = $spreadsheet->getActiveSheet();
	$highestRow = $activeSheet->getHighestDataRow();
	$rowsToDelete = [];

	for ($row=3; $row<=$highestRow; $row++) {
		$lackSub = $activeSheet->getCell("O" . $row)->getValue();
		$status = $activeSheet->getCell("W" . $row)->getValue();
		if ($lackSub != "" || $status != "accepted") {
			array_push($rowsToDelete, $row);
		}
	}
	$rowsToDelete = array_reverse($rowsToDelete);
	foreach ($rowsToDelete as $rowToDelete) {
		if ($rowToDelete == $highestRow) {
			$highestColumn = $activeSheet->getHighestDataColumn();
			for ($col="A"; $col<=$highestColumn; $col++) {
				$activeSheet->setCellValue($col . $rowToDelete, "");
			}
		}
		else {
			$activeSheet->removeRow($rowToDelete);
		}
	}
	
	$columnsToDelete = ["Q", "R", "S", "T", "U", "V", "W"];
	$columnsToDelete = array_reverse($columnsToDelete);
	foreach ($columnsToDelete as $columnToDelete) {
		$activeSheet->removeColumn($columnToDelete);
	}

	$activeSheet->setCellValue("Q2", "No F137 or HS/SHS Permanend Record");
	$activeSheet->getColumnDimension("Q")->setWidth(20);
	$activeSheet->setCellValue("R2", "No Official Transcript of Records");
	$activeSheet->getColumnDimension("R")->setWidth(20);
	$activeSheet->setCellValue("S2", "No Certified Copy of Birth Certificate");
	$activeSheet->getColumnDimension("S")->setWidth(20);
	$activeSheet->setCellValue("T2", "2pcs. 2 x 2 picture (white background)");
	$activeSheet->getColumnDimension("T")->setWidth(20);
	$activeSheet->setCellValue("U2", "No ROTC-MS/NSTP-CWTS Grades");
	$activeSheet->getColumnDimension("U")->setWidth(20);
	$activeSheet->setCellValue("V2", "Others");
	$activeSheet->getColumnDimension("V")->setWidth(20);
	$activeSheet->setCellValue("W2", "Curriculum/Track/Bridging Details");
	$activeSheet->getColumnDimension("W")->setWidth(20);
	$activeSheet->setCellValue("X2", "Action");
	$activeSheet->getColumnDimension("X")->setWidth(20);

	$writer = IOFactory::createWriter($spreadsheet, "Xlsx");
	$writer->save("../uploads/$to/$fileName");

	echo "success";
}
else if ($from == "final-evaluation-result-form") {
	$fileName = $_COOKIE["final-evaluation-result-form-file"];
	$spreadsheet = IOFactory::load("../uploads/$from/$fileName");
	$activeSheet = $spreadsheet->getActiveSheet();
	$highestRow = $activeSheet->getHighestDataRow();
	$rowsToDelete = [];

	$activeSheet->insertNewColumnBefore("M");
	$activeSheet->getColumnDimension("M")->setWidth(20);
	$activeSheet->unmergeCells("K2:L2");
	$activeSheet->mergeCells("K2:M2");

	for ($row=3; $row<=$highestRow; $row++) {
		$defaultGrade = [];
		$fileEnrolledSubs = explode(", ", $activeSheet->getCell("K" . $row)->getValue());
		for ($i=0; $i<count($fileEnrolledSubs); $i++) {
			array_push($defaultGrade, 0);
		}
		$activeSheet->setCellValue("M" . $row, implode(", ", $defaultGrade));
	}

	for ($row=3; $row<=$highestRow; $row++) {
		$lackSub = $activeSheet->getCell("P" . $row)->getValue();
		$status = $activeSheet->getCell("Y" . $row)->getValue();
		if ($lackSub != "" || $status != "accepted") {
			array_push($rowsToDelete, $row);
		}
	}
	$rowsToDelete = array_reverse($rowsToDelete);
	foreach ($rowsToDelete as $rowToDelete) {
		if ($rowToDelete == $highestRow) {
			$highestColumn = $activeSheet->getHighestDataColumn();
			for ($col="A"; $col<=$highestColumn; $col++) {
				$activeSheet->setCellValue($col . $rowToDelete, "");
			}
		}
		else {
			$activeSheet->removeRow($rowToDelete);
		}
	}

	$columnsToDelete = ["R", "S", "T", "U", "V", "W", "X", "Y"];
	$columnsToDelete = array_reverse($columnsToDelete);
	foreach ($columnsToDelete as $columnToDelete) {
		$activeSheet->removeColumn($columnToDelete);
	}

	$activeSheet->setCellValue("R2", "AR/OR NO.");
	$activeSheet->getColumnDimension("R")->setWidth(20);
	$activeSheet->setCellValue("S2", "Amount");
	$activeSheet->getColumnDimension("S")->setWidth(20);
	$activeSheet->setCellValue("T2", "Date Paid");
	$activeSheet->getColumnDimension("T")->setWidth(20);
	$activeSheet->setCellValue("U2", "Application for Evaluation Form");
	$activeSheet->getColumnDimension("U")->setWidth(20);
	$activeSheet->setCellValue("V2", "Evaluation Sheet signed by the College Dean");
	$activeSheet->getColumnDimension("V")->setWidth(20);
	$activeSheet->setCellValue("W2", "Photocopy of NSO/PSA-Authenticated Birth Certificate");
	$activeSheet->getColumnDimension("W")->setWidth(20);
	$activeSheet->setCellValue("X2", "Marriage Certificate (NSO/PSA)");
	$activeSheet->getColumnDimension("X")->setWidth(20);
	$activeSheet->setCellValue("Y2", "F-137 from your High School");
	$activeSheet->getColumnDimension("Y")->setWidth(20);
	$activeSheet->setCellValue("Z2", "Transcript of Records");
	$activeSheet->getColumnDimension("Z")->setWidth(20);
	$activeSheet->setCellValue("AA2", "2pcs 2x2 Colored Picture");
	$activeSheet->getColumnDimension("AA")->setWidth(20);
	$activeSheet->setCellValue("AB2", "Action");
	$activeSheet->getColumnDimension("AB")->setWidth(20);
	
	$writer = IOFactory::createWriter($spreadsheet, "Xlsx");
	$writer->save("../uploads/$to/$fileName");

	echo "success";
}
?>