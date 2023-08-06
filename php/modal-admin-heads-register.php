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
    .modal-content-body select {
        cursor: pointer;
        padding: 10px;
        width: 100%;
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
    Register <?php echo ucfirst($_POST["type"]); ?>
</div>
<div class="modal-content-body">
<i class="icon fas fa-user-tie"></i>
    <input id="full-name" autocomplete="off" placeholder="Full Name" title="Full Name">
    <?php
    if ($_POST["type"] == "dean") {
        echo "<select id='college'>";
            echo "<option value='' selected hidden>College</option>";
            $select = "SELECT * FROM college";
            $result = $connect -> query($select);
            if ($result -> num_rows > 0) {
                while ($row = mysqli_fetch_array($result)) {
                    $collegeid = $row["id"];
                    $collegeacro = $row["acronym"];
                    $college = $row["college"];

                    echo "<option value='$collegeid'>$college ($collegeacro)</option>";
                }
            }
        echo "</select>";
    }
    ?>
</div>
<div class="modal-content-footer">
    <button id="insert-btn"><i class='fas fa-plus-circle'></i> Register</button>
    <button id="close-modal-btn"><i class="fas fa-times-circle"></i> Close</button>
</div>
<script>
    document.getElementById("insert-btn").addEventListener("click", function() {
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
                    url: "php/admin-heads-insert.php",
                    type: "post",
                    data: {
                        name: fullname,
                        type: "dean",
                        college: college,
                    },
                    success: function(response) {
                        if (response == "success") {
                            if (!alert("Head successfully registered.")) {
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
                url: "php/admin-heads-insert.php",
                type: "post",
                data: {
                    name: fullname,
                    type: "<?php echo $_POST['type']; ?>",
                },
                success: function(response) {
                    if (response == "success") {
                        if (!alert("Head successfully registered.")) {
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