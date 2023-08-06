<?php
include "connect.php";

$id = $_POST["id"];
$select = "SELECT * FROM professor WHERE id=$id";
$result = $connect -> query($select);
if ($result -> num_rows > 0) {
    while ($row = mysqli_fetch_array($result)) {
        $prefix = $row["prefix"];
		$lastname = $row["lastname"];
		$firstname = $row["firstname"];
		$middlename = $row["middlename"];
        if ($middlename == "") {
			$middleinitial = "";
		}
		else {
			$middleinitial = substr($middlename, 0, 1) . ". ";
		}
    }
}
else {
    header("location:./?professors&create");
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
    Edit <?php echo "$prefix $firstname $middleinitial$lastname"; ?>
</div>
<div class="modal-content-body">
    <i class="icon fas fa-user-tie"></i>
    <input id="prefix" value="<?php echo $prefix; ?>" autocomplete="off" placeholder="Prefix (ex. Mr./Ms.)" title="Prefix (ex. Mr./Ms.)">
    <i class="icon fas fa-user-tie"></i>
    <input id="lastname" value="<?php echo $lastname; ?>" autocomplete="off" placeholder="Last Name" title="Last Name">
    <i class="icon fas fa-user-tie"></i>
    <input id="firstname" value="<?php echo $firstname; ?>" autocomplete="off" placeholder="First Name" title="First Name">
    <i class="icon fas fa-user-tie"></i>
    <input id="middlename" value="<?php echo $middlename; ?>" autocomplete="off" placeholder="Middle Name" title="Middle Name">
</div>  
<div class="modal-content-footer">
    <button id="update-btn"><i class="fas fa-edit"></i> Edit</button>
    <button id="close-modal-btn"><i class="fas fa-times-circle"></i> Close</button>
</div>
<script>
    document.getElementById("update-btn").addEventListener("click", function() {
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
				url: "php/admin-professors-register-update.php",
				type: "post",
				data: {
					id: <?php echo $id; ?>,
					prefix: prefix,
					lastname: lastname,
					firstname: firstname,
					middlename: middlename,
				},
				success: function(response) {
					if (response == "success") {
                        if (!alert("Professor successfully updated.")) {
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