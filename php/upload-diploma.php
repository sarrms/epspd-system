<?php
include "../vendor/autoload.php";

use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;

if ($_FILES["select_excel"]["name"] != "") {
	$allowed_extension = array("xls", "xlsx");
	$file_array = explode(".", $_FILES["select_excel"]["name"]);
	$file_extension = end($file_array);
	if (in_array($file_extension, $allowed_extension)) {
		$targetDirectory = "uploads/create-diploma/bachelor/";
		$targetFilePath = $targetDirectory . basename($_FILES["select_excel"]["name"]);

		if (move_uploaded_file($_FILES["select_excel"]["tmp_name"], $targetFilePath)) {
			echo "success";
		}
		else {
			echo 'upload failed.';
		
		}
	}
	else {
		echo "error-file";
	}
}
else {
	echo "empty-file";
}
?>