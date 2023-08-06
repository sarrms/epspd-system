<style>
    .modal-content-body div {
        padding: 5px;
    }
    .modal-content-body .modal-content-body-header {
        width: inherit;
    }
    .modal-content-body div span {
        display: inline-block;
        width: 100px;
    }
    .modal-content-body div input {
        border: none;
        border-bottom: 1px solid #000000;
        outline: none;
    }
    .modal-content-body div input[type="text"] {
        text-indent: 10px;
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
    ?>
    <div>
        <span>AR/OR No.</span>
        <?php
        $num = $activeSheet->getCell("R" . $row)->getValue();
        if ($num == "") {
            echo "<input type='text' class='gradfee-input'>";
        }
        else {
            echo "<input type='text' value='$num' class='gradfee-input'>";
        }
        ?>
    </div>
    <div>
        <span>Amount</span>
        <?php
        $amount = $activeSheet->getCell("S" . $row)->getValue();
        if ($amount == "") {
            echo "<input type='text' class='gradfee-input'>";
        }
        else {
            echo "<input type='text' value='$amount' class='gradfee-input'>";
        }
        ?>
    </div>
    <div>
        <span>Date Paid</span>
        <?php
        $datepaid = $activeSheet->getCell("T" . $row)->getValue();
        if ($datepaid == "") {
            echo "<input type='date' class='gradfee-input'>";
        }
        else {
            echo "<input type='date' value='$datepaid' class='gradfee-input'>";
        }
        ?>
    </div>
</div>
<div class="modal-content-footer">
    <button id="close-modal-btn">Close</button>
</div>
<script>
    var gradFee = document.getElementsByClassName("gradfee-input");
    for (let i=0; i<gradFee.length; i++) {
        gradFee[i].addEventListener("change", function() {
            var row = <?php echo $_POST['row']; ?>;
            if (i == 0) {
                var col = "R";
            }
            else if (i == 1) {
                var col = "S";
            }
            else if (i == 2) {
                var col = "T";
            }

            $.ajax({
				url: "php/gradfee-application-graduation.php",
				type: "post",
				data: {
					row: row,
					column: col,
                    value: gradFee[i].value,
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