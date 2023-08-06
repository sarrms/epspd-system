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
    Register Professor
</div>
<div class="modal-content-body">
<i class="icon fas fa-user-tie"></i>
    <input id="prefix" autocomplete="off" placeholder="Prefix (ex. Mr./Ms.)" title="Prefix (ex. Mr./Ms.)">
    <i class="icon fas fa-user-tie"></i>
    <input id="lastname" autocomplete="off" placeholder="Last Name" title="Last Name">
    <i class="icon fas fa-user-tie"></i>
    <input id="firstname" autocomplete="off" placeholder="First Name" title="First Name">
    <i class="icon fas fa-user-tie"></i>
    <input id="middlename" autocomplete="off" placeholder="Middle Name" title="Middle Name">
</div>  
<div class="modal-content-footer">
    <button id="insert-btn"><i class='fas fa-plus-circle'></i> Register</button>
    <button id="close-modal-btn"><i class="fas fa-times-circle"></i> Close</button>
</div>
<script>
    document.getElementById("insert-btn").addEventListener("click", function() {
        var prefix = $("#prefix").val();
        var lastname = $("#lastname").val();
        var firstname = $("#firstname").val();
        var middlename = $("#middlename").val();
        if (prefix == "") {
            alert("Please input Prefix.");
        }
        else if (lastname == "") {
            alert("Please input Last Name.");
        }
        else if (firstname == "") {
            alert("Please input First Name.");
        }
        else {
            $.ajax({
				url: "php/admin-professors-register-insert.php",
				type: "post",
				data: {
					prefix: prefix,
					lastname: lastname,
					firstname: firstname,
					middlename: middlename,
				},
				success: function(response) {
					if (response == "success") {
                        if (!alert("Professor successfully registered.")) {
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