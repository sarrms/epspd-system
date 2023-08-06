<style>
    .modal-content-body input[type="checkbox"] {
        cursor: pointer;
        outline: none;
        margin-bottom: 10px;
    }
    .modal-content-body input[type="checkbox"]::after {
        content: "";
        position: absolute;
        height: 13px;
        width: 20px;
        border-bottom: 1px solid #000000;
        background-color: #ffffff;
    }
    .modal-content-body input[type="checkbox"]:checked::after {
        content: "✓";
        font-size: 10px;
        text-align: center;
        font-weight: bold;
        position: absolute;
        height: 12px;
        width: 19px;
        padding: 0.5px;
        background-color: #ffffff;
    }
    .modal-content-body label {
        margin-left: 13px;
    }
    .modal-content-body label::after {
        content: "";
        display: block;
    }
</style>
<?php
include "../vendor/autoload.php";

use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Cell\Coordinate;

$fileName = $_COOKIE["application-for-graduation-file"];
$reader = IOFactory::createReader("Xlsx");
$file = $reader->load("../uploads/application-for-graduation/$fileName");
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
$row = $_POST["row"];
?>
<div class="modal-content-header">
    Graduation Fee
</div>
<div class="modal-content-body">
    <?php
    $surname = ucwords(strtolower($activeSheet->getCell("C" . $row)->getValue()));
    $givenName = ucwords(strtolower($activeSheet->getCell("D" . $row)->getValue()));
    $middleName = ucwords(strtolower($activeSheet->getCell("E" . $row)->getValue()));
    echo "<span class='modal-content-body-header'>$surname, $givenName $middleName</span>";

    $u = $activeSheet->getCell("U" . $row)->getValue();
    if ($u == "checked") {
        echo "<input type='checkbox' value='$row' class='checkbox' checked>";
    }
    else {
        echo "<input type='checkbox' value='$row' class='checkbox'>";
    }
    echo "<label>Application for Evaluation Form</label>";

    $v = $activeSheet->getCell("V" . $row)->getValue();
    if ($v == "checked") {
        echo "<input type='checkbox' value='$row' class='checkbox' checked>";
    }
    else {
        echo "<input type='checkbox' value='$row' class='checkbox'>";
    }
    echo "<label>Evaluation Sheet signed by the College Dean</label>";

    $w = $activeSheet->getCell("W" . $row)->getValue();
    if ($w == "checked") {
        echo "<input type='checkbox' value='$row' class='checkbox' checked>";
    }
    else {
        echo "<input type='checkbox' value='$row' class='checkbox'>";
    }
    echo "<label>Photocopy of NSO/PSA-Authenticated Birth Certificate</label>";
    $x = $activeSheet->getCell("X" . $row)->getValue();
    if ($x == "checked") {
        echo "<input type='checkbox' value='$row' class='checkbox' checked>";
    }
    else {
        echo "<input type='checkbox' value='$row' class='checkbox'>";
    }
    echo "<label>Marriage Certificate (NSO/PSA)</label>";
    $y = $activeSheet->getCell("Y" . $row)->getValue();
    if ($y == "checked") {
        echo "<input type='checkbox' value='$row' class='checkbox' checked>";
    }
    else {
        echo "<input type='checkbox' value='$row' class='checkbox'>";
    }
    echo "<label>F-137 from your High School</label>";
    $z = $activeSheet->getCell("Z" . $row)->getValue();
    if ($z == "checked") {
        echo "<input type='checkbox' value='$row' class='checkbox' checked>";
    }
    else {
        echo "<input type='checkbox' value='$row' class='checkbox'>";
    }
    echo "<label>Transcript of Records</label>";
    $aa = $activeSheet->getCell("AA" . $row)->getValue();
    if ($aa == "checked") {
        echo "<input type='checkbox' value='$row' class='checkbox' checked>";
    }
    else {
        echo "<input type='checkbox' value='$row' class='checkbox'>";
    }
    echo "<label>2pcs 2x2 Colored Picture</label>";
    ?>
</div>
<div class="modal-content-footer">
    <button id="close-modal-btn">Close</button>
</div>
<script>
    var checkbox = document.getElementsByClassName("checkbox");
    for (let i=0; i<checkbox.length; i++) {
        checkbox[i].addEventListener("change", function() {
            if (i == 0) {
                var col = "U";
            }
            else if (i == 1) {
                var col = "V";
            }
            else if (i == 2) {
                var col = "W";
            }
            else if (i == 3) {
                var col = "X";
            }
            else if (i == 4) {
                var col = "Y";
            }
            else if (i == 5) {
                var col = "Z";
            }
            else if (i == 6) {
                var col = "AA";
            }

            if (checkbox[i].checked) {
                var val = "checked";
            }
            else {
                var val = "";
            }

            $.ajax({
				url: "php/docsub-list-graduates.php",
				type: "post",
				data: {
					row: checkbox[i].value,
					column: col,
                    value: val,
				},
				success: function(response) {
					
				}
			});
        });
    }
</script>
<script>
    document.getElementById("close-modal-btn").addEventListener("click", function() {
        var modal = document.getElementById("modal");
        modal.style.opacity = "0";
        modal.style.pointerEvents = "none";
        $("#modal-content").html("");
    });
</script>