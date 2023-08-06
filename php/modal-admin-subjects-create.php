<?php
include "connect.php";
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
    Create Subject
</div>
<div class="modal-content-body">
    <i class="icon fas fa-code"></i>
    <input id="subject-code" autocomplete="off" placeholder="Code" title="Code">
    <i class="icon fas fa-heading"></i>
    <input id="subject-title" autocomplete="off" placeholder="Title" title="Title">
    <i class="icon fas fa-info-circle"></i>
    <input type="number" id="subject-unitlec" autocomplete="off" placeholder="Unit Lec" title="Unit Lec">
    <i class="icon fas fa-info-circle"></i>
    <input type="number" id="subject-unitlab" autocomplete="off" placeholder="Unit Lab" title="Unit Lab">
</div>  
<div class="modal-content-footer">
    <button id="insert-btn"><i class='fas fa-plus-circle'></i> Create</button>
    <button id="close-modal-btn"><i class="fas fa-times-circle"></i> Close</button>
</div>
<script>
    document.getElementById("insert-btn").addEventListener("click", function() {
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
				url: "php/admin-subjects-create-insert.php",
				type: "post",
				data: {
					code: code,
					title: title,
					unitlec: unitlec,
					unitlab: unitlab,
				},
				success: function(response) {
					if (response == "success") {
                        if (!alert("Subject successfully created.")) {
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