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
use PhpOffice\PhpSpreadsheet\Cell\Coordinate;

$reader = IOFactory::createReader("Xlsx");
$fileName = $_COOKIE["application-for-graduation-file"];
if (isset($_POST["rel"])) {
	$file = $reader->load("../uploads/application-for-graduation/$fileName");
}
else {
	$file = $reader->load("uploads/application-for-graduation/$fileName");
}
$activeSheet = $file->getActiveSheet();
$fileHighestRow = $activeSheet->getHighestDataRow();
$highestColumn = Coordinate::columnIndexFromString($activeSheet->getHighestDataColumn());
$vals = [];
$highestRow = 0;
for ($row=3; $row<=$fileHighestRow; $row++) {
	for ($col=1; $col<=$highestColumn; $col++) {
		$columnLetter = Coordinate::stringFromColumnIndex($col);
		$val = $activeSheet->getCell($columnLetter . $row)->getValue();
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
$data = [];
?>
<div class="paper-report">
	<span>Total: <?php echo $highestRow - 2; ?></span>
</div>
<div class="list-of-graduates-header">
    <div>
        <?php
        $fileCollege = $activeSheet->getCell("A1")->getValue();
        $select = "SELECT * FROM college WHERE id=$fileCollege";
        $result = $connect -> query($select);
        if ($result -> num_rows > 0) {
            while ($row = mysqli_fetch_array($result)) {
                $college = $row["college"];
            }
        }
        ?>
    </div>
    <div>
        <?php
        $fileCourse = $activeSheet->getCell("B1")->getValue();
        $select = "SELECT * FROM course WHERE id=$fileCourse";
        $result = $connect -> query($select);
        if ($result -> num_rows > 0) {
            while ($row = mysqli_fetch_array($result)) {
                $course = str_replace("Bachelor of Science", "BS", $row["course"]);
            }
        }
        ?>
    </div>
    <?php
    $fileMajor = $activeSheet->getCell("C1")->getValue();
    if ($fileMajor != "") {
        $select = "SELECT * FROM major WHERE id=$fileMajor";
        $result = $connect -> query($select);
        if ($result -> num_rows > 0) {
            while ($row = mysqli_fetch_array($result)) {
                $major = $row["major"];
            }
        }
		$majorText = "Major in $major";
    }
	else {
		$majorText = "";
	}
    ?>
</div>
<table class="list-of-graduates-table">
	<tr>
		<th colspan="8"><?php echo "$course $majorText"; ?></th>
	</tr>
	<tr>
		<th>No.</th>
		<th>Student Number</th>
		<th>Last Name</th>
		<th>First Name</th>
		<th>Middle Name</th>
		<th>Contact Number</th>
		<th>Permanent Address</th>
		<th>Doc. to be Sub.</th>
	</tr>
	<?php
	for ($row = 3; $row <= $highestRow; $row++) {
		$studentNumber = $activeSheet->getCell("B" . $row)->getValue();
		$surname = ucwords(strtolower($activeSheet->getCell("C" . $row)->getValue()));
		$givenname = ucwords(strtolower($activeSheet->getCell("D" . $row)->getValue()));
		$middlename = ucwords(strtolower($activeSheet->getCell("E" . $row)->getValue()));
		$contactNumber = $activeSheet->getCell("F" . $row)->getValue();
		$permanentAddress = $activeSheet->getCell("G" . $row)->getValue();

		echo "<tr>";
			echo "<td>" . $row - 2 . "</td>";
			echo "<td>$studentNumber</td>";
			echo "<td>$surname</td>";
			echo "<td>$givenname</td>";
			echo "<td>$middlename</td>";
			echo "<td>$contactNumber</td>";
			echo "<td>$permanentAddress</td>";
			echo "<td>";
				echo "<button value='$row' class='view-modal-btn'>View</button>";
			echo "</td>";
		echo "</tr>";
	}
	?>
</table>
<script>
	var viewModalBtn = document.getElementsByClassName("view-modal-btn");
	for (let i=0; i<viewModalBtn.length; i++) {
		viewModalBtn[i].addEventListener("click", function() {
			var modal = document.getElementById("modal");
			modal.style.opacity = "1";
			modal.style.pointerEvents = "auto";
			$.ajax({
				url: "php/modal-list-graduates.php",
				type: "post",
				data: {
					row: viewModalBtn[i].value,
				},
				success: function(response) {
					$("#modal-content").html(response);
				}
			});
		});
	}
</script>