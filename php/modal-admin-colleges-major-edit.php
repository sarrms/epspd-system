<?php
include "connect.php";

$id = $_POST["id"];
$select = "SELECT * FROM major WHERE id=$id";
$result = $connect -> query($select);
if ($result -> num_rows > 0) {
    while ($row = mysqli_fetch_array($result)) {
        $course = $row["course"];
        $major = $row["major"];
    }
}
else {
    header("location:./?colleges&major");
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
    Edit <?php echo $major; ?>
</div>
<div class="modal-content-body">
    <i class="icon fas fa-graduation-cap"></i>
    <input id="major" value="<?php echo $major; ?>" autocomplete="off" placeholder="Major" title="Major">
    <select id="course" title="Course">
        <option value="" selected hidden>Course</option>
        <?php
        $select = "SELECT * FROM course ORDER BY college, course ASC";
        $result = $connect -> query($select);
        if ($result -> num_rows > 0) {
            while ($row = mysqli_fetch_array($result)) {
                $courseid = $row["id"];
                $coursename = $row["course"];
                $courseacro = $row["acronym"];

                if ($courseid == $course) {
                    echo "<option value='$courseid' selected>$coursename ($courseacro)</option>";
                }
                else {
                    echo "<option value='$courseid'>$coursename ($courseacro)</option>";
                }
            }
        }
        ?>
    </select>
</div>  
<div class="modal-content-footer">
    <button id="update-btn"><i class='fas fa-plus-circle'></i> Edit</button>
    <button id="close-modal-btn"><i class="fas fa-times-circle"></i> Close</button>
</div>
<script>
    document.getElementById("update-btn").addEventListener("click", function() {
        var major = $("#major").val();
        var course = $("#course").val();
        if (major == "") {
            alert("Please input major.");
        }
        else if (course == "") {
            alert("Please select College.");
        }
        else {
            $.ajax({
				url: "php/admin-colleges-major-update.php",
				type: "post",
				data: {
					id: <?php echo $id; ?>,
					major: major,
					course: course,
				},
				success: function(response) {
					if (response == "success") {
                        if (!alert("Major successfully updated.")) {
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