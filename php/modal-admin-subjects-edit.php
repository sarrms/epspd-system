<?php
include "connect.php";

$id = $_POST["id"];
$select = "SELECT * FROM subject WHERE id=$id";
$result = $connect -> query($select);
if ($result -> num_rows > 0) {
    while ($row = mysqli_fetch_array($result)) {
        $code = $row["code"];
        $title = $row["title"];
        $unitlec = intval($row["unitlec"]);
        $unitlab = intval($row["unitlab"]);
    }
}
else {
    header("location:./?subjects&create");
}
?>
<style>
    .modal-content-body .icon {
        color: #505050;
        position: absolute;
        padding: 10px;
    }
    .modal-content-body input {
        text-indent: 28px;
        padding: 10px;
        width: calc(100% - 20px);
        margin-bottom: 10px;
        border: 1px solid #dddddd;
        outline: none;
    }
    .modal-content-body input[type="number"] {
        appearance: none;
        -moz-appearance: none;
        -webkit-appearance: none;
    }
    .modal-content-body input[type="number"]::-webkit-inner-spin-button,
    .modal-content-body input[type="number"]::-webkit-outer-spin-button {
        -webkit-appearance: none;
        margin: 0;
    }
    .modal-content-footer button:first-child {
        background-color: #f5b051;
    }
</style>
<div class="modal-content-header">
    Edit <?php echo $code; ?>
</div>
<div class="modal-content-body">
    <i class="icon fas fa-code"></i>
    <input id="subject-code" value="<?php echo $code; ?>" autocomplete="off" placeholder="Code" title="Code">
    <i class="icon fas fa-heading"></i>
    <input id="subject-title" value="<?php echo $title; ?>" autocomplete="off" placeholder="Title" title="Title">
    <i class="icon fas fa-info-circle"></i>
    <input type="number" id="subject-unitlec" value="<?php echo $unitlec; ?>" autocomplete="off" placeholder="Unit Lec" title="Unit Lec">
    <i class="icon fas fa-info-circle"></i>
    <input type="number" id="subject-unitlab" value="<?php echo $unitlab; ?>" autocomplete="off" placeholder="Unit Lab" title="Unit Lab">
</div>  
<div class="modal-content-footer">
    <button id="update-btn"><i class="fas fa-edit"></i> Edit</button>
    <button id="close-modal-btn"><i class="fas fa-times-circle"></i> Close</button>
</div>
<script>
    document.getElementById("update-btn").addEventListener("click", function() {
        var code = $("#subject-code").val();
        var title = $("#subject-title").val();
        var unitlec = $("#subject-unitlec").val();
        var unitlab = $("#subject-unitlab").val();
        if (code == "") {
            alert("Please input Subject Code.");
        }
        else if (title == "") {
            alert("Please input Subject Title.");
        }
        else if (unitlec == "") {
            alert("Please input Subject Unit Lec.");
        }
        else if (unitlab == "") {
            alert("Please input Subject Unit Lab.");
        }
        else {
            $.ajax({
				url: "php/admin-subjects-create-update.php",
				type: "post",
				data: {
					id: <?php echo $id; ?>,
					code: code,
					title: title,
					unitlec: unitlec,
					unitlab: unitlab,
				},
				success: function(response) {
					if (response == "success") {
                        if (!alert("Subject successfully updated.")) {
                            location.reload();
                        }
                    }
                    else {
                        alert(response);
                    }
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