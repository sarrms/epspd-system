<style>
    .modal-content-body input[type="checkbox"] {
        cursor: pointer;
        outline: none;
        margin-bottom: 10px;
    }
    .modal-content-body input[type="checkbox"]:disabled {
        cursor: default;
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
    .modal-content-body input[type="text"] {
        position: absolute;
        font-size: 14px;
        font-family: Times New Roman;
        text-indent: 10px;
        margin-top: -25px;
        margin-left: 75px;
        border: none;
        border-bottom: 1px solid #000000;
        outline: none;
        background-color: #ffffff;
    }
    .modal-content-body label {
        margin-left: 13px;
    }
    .modal-content-body label::after {
        content: "";
        display: block;
    }
    .modal-content-body table {
        width: 85%;
        margin: auto;
    }
    .modal-content-body .details {
        font-family: Arial;
    }
    .modal-content-body .details h1 {
	    color: #323232;
        font-size: 16px;
        font-family: "Bahnschrift", sans-serif;
        margin-top: 10px;
    }
    .modal-content-body .details input {
        position: inherit;
        width: 300px;
        margin: 0;
    }
</style>
<?php
$row = $_POST["row"];
include "../vendor/autoload.php";

use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;

$fileName = $_COOKIE["final-evaluation-result-form-file"];
$reader = IOFactory::createReader("Xlsx");
$file = $reader->load("../uploads/final-evaluation-result-form/$fileName");
$activeSheet = $file->getActiveSheet();
?>
<div class="modal-content-header">
    Select Submitted Credentials
</div>
<div class="modal-content-body">
    <?php
    $surname = ucwords(strtolower($activeSheet->getCell("C" . $row)->getValue()));
    $givenName = ucwords(strtolower($activeSheet->getCell("D" . $row)->getValue()));
    $middleName = ucwords(strtolower($activeSheet->getCell("E" . $row)->getValue()));
    echo "<span class='modal-content-body-header'>$surname, $givenName $middleName</span>";

    $checkbox1 = $activeSheet->getCell("Q" . $row)->getValue();
    if ($checkbox1 == "checked") {
        echo "<input type='checkbox' id='checkbox1$row' value='$row' class='checkbox' checked>";
    }
    else {
        echo "<input type='checkbox' id='checkbox1$row' value='$row' class='checkbox'>";
    }
    echo "<label for='checkbox1$row'>No F137 or HS/SHS Permanend Record</label>";

    $checkbox2 = $activeSheet->getCell("R" . $row)->getValue();
    if ($checkbox2 == "checked") {
        echo "<input type='checkbox' id='checkbox2$row' value='$row' class='checkbox' checked>";
    }
    else {
        echo "<input type='checkbox' id='checkbox2$row' value='$row' class='checkbox'>";
    }
    echo "<label for='checkbox2$row'>No Official Transcript of Records</label>";

    $checkbox3 = $activeSheet->getCell("S" . $row)->getValue();
    if ($checkbox3 == "checked") {
        echo "<input type='checkbox' id='checkbox3$row' value='$row' class='checkbox' checked>";
    }
    else {
        echo "<input type='checkbox' id='checkbox3$row' value='$row' class='checkbox'>";
    }
    echo "<label for='checkbox3$row'>No Certified Copy of Birth Certificate</label>";

    $checkbox4 = $activeSheet->getCell("T" . $row)->getValue();
    if ($checkbox4 == "checked") {
        echo "<input type='checkbox' id='checkbox4$row' value='$row' class='checkbox' checked>";
    }
    else {
        echo "<input type='checkbox' id='checkbox4$row' value='$row' class='checkbox'>";
    }
    echo "<label for='checkbox4$row'>2pcs. 2 x 2 picture (white background)</label>";

    $checkbox5 = $activeSheet->getCell("U" . $row)->getValue();
    if ($checkbox5 == "") {
        echo "<input type='checkbox' disabled>";
        $explode = [];
    }
    else {
        echo "<input type='checkbox' disabled checked>";
        $explode = explode(", ", $checkbox5);
    }
    echo "<label>No ROTC-MS/NSTP-CWTS Grades</label>";
    echo "<table>";
        echo "<tr>";
            if (in_array("CWTS 1", $explode)) {
                echo "<td><input type='checkbox' id='checkbox5$row-1' value='$row' class='checkbox5' checked><label for='checkbox5$row-1'>CWTS 1</label></td>";
            }
            else {
                echo "<td><input type='checkbox' id='checkbox5$row-1' value='$row' class='checkbox5'><label for='checkbox5$row-1'>CWTS 1</label></td>";
            }
            if (in_array("CWTS 2", $explode)) {
                echo "<td><input type='checkbox' id='checkbox5$row-2' value='$row' class='checkbox5' checked><label for='checkbox5$row-2'>CTWS 2</label></td>";
            }
            else {
                echo "<td><input type='checkbox' id='checkbox5$row-2' value='$row' class='checkbox5'><label for='checkbox5$row-2'>CTWS 2</label></td>";
            }
        echo "</tr>";
        echo "<tr>";
            if (in_array("MTS 1", $explode)) {
                echo "<td><input type='checkbox' id='checkbox5$row-3' value='$row' class='checkbox5' checked><label for='checkbox5$row-3'>MTS 1</label></td>";
            }
            else {
                echo "<td><input type='checkbox' id='checkbox5$row-3' value='$row' class='checkbox5'><label for='checkbox5$row-3'>MTS 1</label></td>";
            }
            if (in_array("MTS 2", $explode)) {
                echo "<td><input type='checkbox' id='checkbox5$row-4' value='$row' class='checkbox5' checked><label for='checkbox5$row-4'>MTS 2</label></td>";
            }
            else {
                echo "<td><input type='checkbox' id='checkbox5$row-4' value='$row' class='checkbox5'><label for='checkbox5$row-4'>MTS 2</label></td>";
            }
        echo "</tr>";
    echo "</table>";

    $checkbox6 = $activeSheet->getCell("V" . $row)->getValue();
    if ($checkbox6 == "") {
        echo "<input type='checkbox' id='checkbox6$row' value='$row' class='checkbox' disabled>";
    }
    else {
        echo "<input type='checkbox' id='checkbox6$row' value='$row' class='checkbox' disabled checked>";
    }
    echo "<label for='checkbox6$row'>Others</label>";
    echo "<input type='text' value='$checkbox6' data-value='$row' class='input'>";
    ?>
    <div class="details">
        <h1>Curriculum/Track/Bridging Details:</h1>
        <?php
        $fileDetails = $activeSheet->getCell("W" . $row)->getValue();
        if ($fileDetails == "") {
            for ($i=0; $i<3; $i++) {
                echo "<input type='text' data-value='$row' class='ctb-details'>";
            }
        }
        else {
            $details = explode(", ", $fileDetails);
            foreach ($details as $detail) {
                echo "<input type='text' value='$detail' data-value='$row' class='ctb-details'>";
            }
            if (count($details) < 3) {
                $left = 3 - count($details);
                for ($i=0; $i<$left; $i++) {
                    echo "<input type='text' data-value='$row' class='ctb-details'>";
                }
            }
        }
        ?>
    </div>
</div>
<div class="modal-content-footer">
    <button id="close-modal-btn">Close</button>
</div>
<script>
	var checkbox = document.getElementsByClassName("checkbox");
	for (let i=0; i<checkbox.length; i++) {
		checkbox[i].addEventListener("click", function() {
			if (this.checked) {
				var cb = "checked";
			}
			else {
				var cb = "";
			}
			
			var cbnum = (i + 1) % 6;
			if (cbnum == 0) {
				var checkboxnum = "checkbox" + 6;
			}
			else {
				var checkboxnum = "checkbox" + cbnum;
			}

			$.ajax({
				url: "php/credential-final-evaluation-result.php",
				type: "post",
				data: {
					row: checkbox[i].value,
					checkbox: cb,
					checkboxnum: checkboxnum,
				},
				success: function(response) {
					
				}
			});
		});
	}
</script>
<script>
	var checkbox5 = document.getElementsByClassName("checkbox5");
	for (let i=0; i<checkbox5.length; i++) {
		checkbox5[i].addEventListener("click", function() {
            $.ajax({
				url: "php/credential-final-evaluation-result.php",
				type: "post",
				data: {
					row: checkbox[i].value,
					checkbox: i + 1,
					checkboxnum: "checkbox5",
				},
				success: function(response) {
					
				}
			});
		});
	}
</script>
<script>
	var input = document.getElementsByClassName("input");
	for (let i=0; i<input.length; i++) {
		input[i].addEventListener("change", function() {
            $.ajax({
				url: "php/credential-final-evaluation-result.php",
				type: "post",
				data: {
					row: input[i].getAttribute("data-value"),
					checkbox: input[i].value,
					checkboxnum: "checkbox6",
				},
				success: function(response) {
					
				}
			});
		});
	}
</script>
<script>
    var detailsArr = [];
	var details = document.getElementsByClassName("ctb-details");
	for (let i=0; i<details.length; i++) {
		details[i].addEventListener("change", function() {
            for (let j=0; j<details.length; j++) {
                if (details[j].value != "") {
                    detailsArr.push(details[j].value);
                }
            }
            var detailsVal = detailsArr.join(", ");
            $.ajax({
				url: "php/details-final-evaluation-result.php",
				type: "post",
				data: {
					row: details[i].getAttribute("data-value"),
					detail: detailsVal,
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