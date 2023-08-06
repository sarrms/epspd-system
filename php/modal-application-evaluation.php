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
$row = $_POST["row"];
include "../vendor/autoload.php";

use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;

$fileName = $_COOKIE["application-for-evaluation-file"];
$reader = IOFactory::createReader("Xlsx");
$file = $reader->load("../uploads/application-for-evaluation/$fileName");
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
    echo "<label for='checkbox1$row'>F138/SF10 & Good Moral Cert.</label>";

    $checkbox2 = $activeSheet->getCell("R" . $row)->getValue();
    if ($checkbox2 == "checked") {
        echo "<input type='checkbox' id='checkbox2$row' value='$row' class='checkbox' checked>";
    }
    else {
        echo "<input type='checkbox' id='checkbox2$row' value='$row' class='checkbox'>";
    }
    echo "<label for='checkbox2$row'>F-137/Permanent Record</label>";

    $checkbox3 = $activeSheet->getCell("S" . $row)->getValue();
    if ($checkbox3 == "checked") {
        echo "<input type='checkbox' id='checkbox3$row' value='$row' class='checkbox' checked>";
    }
    else {
        echo "<input type='checkbox' id='checkbox3$row' value='$row' class='checkbox'>";
    }
    echo "<label for='checkbox3$row'>NCEE/NSAT</label>";

    $checkbox4 = $activeSheet->getCell("T" . $row)->getValue();
    if ($checkbox4 == "checked") {
        echo "<input type='checkbox' id='checkbox4$row' value='$row' class='checkbox' checked>";
    }
    else {
        echo "<input type='checkbox' id='checkbox4$row' value='$row' class='checkbox'>";
    }
    echo "<label for='checkbox4$row'>Honorable Dismissal & Good Moral Cert.</label>";

    $checkbox5 = $activeSheet->getCell("U" . $row)->getValue();
    if ($checkbox5 == "checked") {
        echo "<input type='checkbox' id='checkbox5$row' value='$row' class='checkbox' checked>";
    }
    else {
        echo "<input type='checkbox' id='checkbox5$row' value='$row' class='checkbox'>";
    }
    echo "<label for='checkbox5$row'>Transcript of Records</label>";

    $checkbox6 = $activeSheet->getCell("V" . $row)->getValue();
    if ($checkbox6 == "checked") {
        echo "<input type='checkbox' id='checkbox6$row' value='$row' class='checkbox' checked>";
    }
    else {
        echo "<input type='checkbox' id='checkbox6$row' value='$row' class='checkbox'>";
    }
    echo "<label for='checkbox6$row'>Others</label>";
    ?>
</div>
<div class="modal-content-footer">
    <button id="close-modal-btn">Close</button>
</div>
<script>
    document.getElementById("close-modal-btn").addEventListener("click", function() {
        var modal = document.getElementById("modal");
        modal.style.opacity = "0";
        modal.style.pointerEvents = "none";
        $("#modal-content").html("");
    });
</script>
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
				url: "php/credential-application-for-evaluation.php",
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