<?php
if (isset($_POST["rel"])) {
	include "connect.php";
	include "../vendor/autoload.php";
}
else {
	include "php/connect.php";
	include "vendor/autoload.php";
}
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;

$fileName = $_COOKIE["application-for-graduation-file"];

$reader = IOFactory::createReader("Xlsx");
if (isset($_POST["rel"])) {
	$file = $reader->load("../uploads/application-for-graduation/$fileName");
}
else {
	$file = $reader->load("uploads/application-for-graduation/$fileName");
}
$activeSheet = $file->getActiveSheet();
$fileHighestRow = $activeSheet->getHighestDataRow();
$highestColumn = $activeSheet->getHighestDataColumn();
$vals = [];
$highestRow = 0;
for ($row=3; $row<=$fileHighestRow; $row++) {
	for ($col="A"; $col<=$highestColumn; $col++) {
		$val = $activeSheet->getCell($col . $row)->getValue();
		if ($val != "") {
			array_push($vals, $val);
		}
	}
	if (count($vals) != 0) {
		$highestRow = $highestRow + 1;
	}
	array_splice($vals, 0);
}
$highestRow = $highestRow + 2;
?>
<div class="paper-report">
	<?php
	$accepted = 0;
	$rejected = 0;
	$remaining = 0;
	for ($row=3; $row<=$highestRow; $row++) {
		$action = $activeSheet->getCell("W" . $row)->getValue();
		if ($action == "accepted") {
			$accepted = $accepted + 1;
		}
		else if ($action == "rejected") {
			$rejected = $rejected + 1;
		}
		else {
			$remaining = $remaining + 1;
		}
	}
	?>
	<span>All: <?php echo $highestRow - 2; ?></span>
	<span>Accepted: <?php echo $accepted; ?></span>
	<span>Rejected: <?php echo $rejected; ?></span>
	<span>Remaining: <?php echo $remaining; ?></span>
</div>
<table class="create-diploma-table">
	<tr>
		<th colspan="2">Course</th>
	</tr>
	<tr>
		<th>Student Number</th>
		<th>Name</th>
	</tr>
	<?php
	for ($i=3; $i<=$highestRow; $i++) {
		
	}
	?>
</table>