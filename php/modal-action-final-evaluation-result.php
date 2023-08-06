<style>
    .modal-content-body {
        height: 400px;
        overflow-y: scroll;
    }
    .modal-content-body table {
        width: 100%;
        margin: auto;
        border-spacing: 0;
        border-collapse: collapse;
    }
    .modal-content-body table td {
        padding: 7px;
        border-bottom: 1px solid #dddddd;
    }
    <?php   
    if ($_POST["action"] == "accept") {
        echo ".modal-content-footer button:first-child {
            background-color: #1a73e8;
        }";
    }
    ?>
</style>
<?php
include "../vendor/autoload.php";

use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;

$fileName = $_COOKIE["final-evaluation-result-form-file"];
$reader = IOFactory::createReader("Xlsx");
$file = $reader->load("../uploads/final-evaluation-result-form/$fileName");
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
<div class="modal-content-header">
    <?php
    if ($_POST["action"] == "accept") {
        echo "Select Student to Accept";
    }
    else {
        echo "Select Student to Reject";
    }
    ?>
</div>
<div class="modal-content-body">
    <table>
        <tr>
            <td><input type="checkbox" id="check-all"></td>
            <td colspan="2"><label for="check-all">Select all</label></td>
        </tr>
        <?php
        for ($row=3; $row<=$highestRow; $row++) {
            $studentNumber = $activeSheet->getCell("B" . $row)->getValue();
            $surname = ucwords(strtolower($activeSheet->getCell("C" . $row)->getValue()));
            $givenName = ucwords(strtolower($activeSheet->getCell("D" . $row)->getValue()));
            $middleName = ucwords(strtolower($activeSheet->getCell("E" . $row)->getValue()));
            $lackSub = $activeSheet->getCell("O" . $row)->getValue();
            $action = $activeSheet->getCell("X" . $row)->getValue();

            if ($lackSub == "") {
                echo "<tr>";
                    if ($_POST["action"] == "accept") {
                        if ($action == "accepted") {
                            echo "<td><input type='checkbox' value='$row' class='checkbox' checked></td>";
                        }
                        else {
                            echo "<td><input type='checkbox' value='$row' class='checkbox'></td>";
                        }
                    }
                    else {
                        if ($action == "rejected") {
                            echo "<td><input type='checkbox' value='$row' class='checkbox' checked></td>";
                        }
                        else {
                            echo "<td><input type='checkbox' value='$row' class='checkbox'></td>";
                        }
                    }
                    echo "<td>$studentNumber</td>";
                    echo "<td>$surname, $givenName $middleName</td>";
                echo "</tr>";
            }
        }
        ?>
    </table>
</div>
<div class="modal-content-footer">
    <?php
    if ($_POST["action"] == "accept") {
        echo "<button id='action-btn'>Accept</button>";
    }
    else {
        echo "<button id='action-btn'>Reject</button>";
    }
    ?>
    <button id="close-modal-btn">Close</button>
</div>
<script>
    var checkAll = document.getElementById("check-all");
    checkAll.addEventListener("click", function() {
        var checkbox = document.getElementsByClassName("checkbox");
        if (checkAll.checked) {
            for (let i=0; i<checkbox.length; i++) {
                checkbox[i].checked = true;
            }
        }
        else {
            for (let i=0; i<checkbox.length; i++) {
                checkbox[i].checked = false;
            }
        }
    });
</script>
<script>
    document.getElementById("action-btn").addEventListener("click", function() {
        var rows = [];
        var checkbox = document.getElementsByClassName("checkbox");
        var action = "<?php echo $_POST['action']; ?>";
        for (let i=0; i<checkbox.length; i++) {
            if (checkbox[i].checked) {
                rows.push(checkbox[i].value);
            }
        }
        if (rows.length == 0) {
            if (action == "accept") {
                alert("Please select student to accept.");
            }
            else {
                alert("Please select student to reject.");
            }
        }
        else {
            $.ajax({
                url: "php/action-final-evaluation-result.php",
                type: "post",
                data: {
                    action: action,
                    rows: rows,
                },
                success: function(response) {
                    
                }
            });
        }
    });
</script>
<script>
    document.getElementById("close-modal-btn").addEventListener("click", function() {
        var modal = document.getElementById("modal");
        modal.style.opacity = "0";
        modal.style.pointerEvents = "none";
        $("#modal-content").html("");
    });
</script>