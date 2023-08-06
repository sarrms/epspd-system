<?php
include "connect.php";

$id = $_POST["id"];
$select = "SELECT * FROM college WHERE id=$id";
$result = $connect -> query($select);
if ($result -> num_rows > 0) {
    while ($row = mysqli_fetch_array($result)) {
        $college = $row["college"];
        $collegeacro = $row["acronym"];
    }
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
    .modal-content-footer button:first-child {
        background-color: #34a853;
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
</style>
<div class="modal-content-header">
    Edit <?php echo "$college ($collegeacro)"; ?>
</div>
<div class="modal-content-body">
    <i class="icon fas fa-university"></i>
    <input id="college" value="<?php echo $college; ?>" autocomplete="off" placeholder="College" title="College">
    <i class="icon fas fa-university"></i>
    <input id="acronym" value="<?php echo $collegeacro; ?>" autocomplete="off" placeholder="Acronym" title="Acronym">
</div>  
<div class="modal-content-footer">
    <button id="update-btn"><i class='fas fa-plus-circle'></i> Edit</button>
    <button id="close-modal-btn"><i class="fas fa-times-circle"></i> Close</button>
</div>
<script>
    document.getElementById("update-btn").addEventListener("click", function() {
        var college = $("#college").val();
        var acronym = $("#acronym").val();
        if (college == "") {
            alert("Please input College.");
        }
        else if (acronym == "") {
            alert("Please input Acronym.");
        }
        else {
            $.ajax({
				url: "php/admin-colleges-update.php",
				type: "post",
				data: {
                    id: <?php echo $id; ?>,
					college: college,
					acronym: acronym,
				},
				success: function(response) {
					if (response == "success") {
                        if (!alert("College successfully updated.")) {
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