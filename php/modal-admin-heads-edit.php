<?php
include "connect.php";

$id = $_POST["id"];
$type = $_POST["type"];

if ($type == "dean") {
    $select = "SELECT * FROM dean WHERE id=$id";
}
else {
    $select = "SELECT * FROM head WHERE id=$id";
}
$result = $connect -> query($select);
if ($result -> num_rows > 0) {
    while ($row = mysqli_fetch_array($result)) {
        if ($type == "dean") {
            $headname = $row["dean"];
            $headcollege = $row["college"];
        }
        else {
            $headname = $row["name"];
        }
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
    .modal-content-body select {
        cursor: pointer;
        padding: 10px;
        width: 100%;
        margin-bottom: 10px;
        border: 1px solid #dddddd;
        outline: none;
    }
    .modal-content-footer button:first-child {
        background-color: #f5b051;
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
    Edit <?php echo "$headname (" . ucfirst($type) . ")"; ?>
</div>
<div class="modal-content-body">
<i class="icon fas fa-user-tie"></i>
    <input id="full-name" value="<?php echo $headname; ?>" autocomplete="off" placeholder="Full Name" title="Full Name">
    <?php
    if ($_POST["type"] == "dean") {
        echo "<select id='college'>";
            $select = "SELECT * FROM college";
            $result = $connect -> query($select);
            if ($result -> num_rows > 0) {
                while ($row = mysqli_fetch_array($result)) {
                    $collegeid = $row["id"];
                    $collegeacro = $row["acronym"];
                    $college = $row["college"];

                    if ($collegeid == $headcollege) {
                        echo "<option value='$collegeid' selected>$college ($collegeacro)</option>";
                    }
                    else {
                        echo "<option value='$collegeid'>$college ($collegeacro)</option>";
                    }
                }
            }
        echo "</select>";
    }
    ?>
</div>
<div class="modal-content-footer">
<button id="update-btn"><i class="fas fa-edit"></i> Edit</button>
    <button id="close-modal-btn"><i class="fas fa-times-circle"></i> Close</button>
</div>
<script>
    document.getElementById("update-btn").addEventListener("click", function() {
        var fullname = $("#full-name").val();
        const params = new URLSearchParams(window.location.search);
        const dean = params.get("dean");
        if (fullname == "") {
            alert("Please input Head's Full Name.");
        }
        else if (dean !== null) {
            var college = $("#college").val();
            if (college == "") {
                alert("Please select college.");
            }
            else {
                $.ajax({
                    url: "php/admin-heads-update.php",
                    type: "post",
                    data: {
                        id: <?php echo $id; ?>,
                        name: fullname,
                        type: "dean",
                        college: college,
                    },
                    success: function(response) {
                        if (response == "success") {
                            if (!alert("Head successfully updated.")) {
                                location.reload();
                            }
                        }
                        else {
                            alert(response);
                        }
                    }
                });
            }
        }
        else {
            $.ajax({
                url: "php/admin-heads-update.php",
                type: "post",
                data: {
                    id: <?php echo $id; ?>,
                    name: fullname,
                    type: "<?php echo $_POST['type']; ?>",
                },
                success: function(response) {
                    if (response == "success") {
                        if (!alert("Head successfully updated.")) {
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