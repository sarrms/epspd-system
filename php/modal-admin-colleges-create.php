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
    Create College
</div>
<div class="modal-content-body">
    <i class="icon fas fa-university"></i>
    <input id="college" autocomplete="off" placeholder="College" title="College">
    <i class="icon fas fa-university"></i>
    <input id="acronym" autocomplete="off" placeholder="Acronym" title="Acronym">
</div>  
<div class="modal-content-footer">
    <button id="insert-btn"><i class='fas fa-plus-circle'></i> Register</button>
    <button id="close-modal-btn"><i class="fas fa-times-circle"></i> Close</button>
</div>
<script>
    document.getElementById("insert-btn").addEventListener("click", function() {
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
				url: "php/admin-colleges-insert.php",
				type: "post",
				data: {
					college: college,
					acronym: acronym,
				},
				success: function(response) {
					if (response == "success") {
                        if (!alert("College successfully created.")) {
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