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
    Create Major
</div>
<div class="modal-content-body">
    <i class="icon fas fa-graduation-cap"></i>
    <input id="major" autocomplete="off" placeholder="Major" title="Major">
    <select id="course" title="Course">
        <option value="" selected hidden>Course</option>
        <?php
        $select = "SELECT * FROM course ORDER BY college, course ASC";
        $result = $connect -> query($select);
        if ($result -> num_rows > 0) {
            while ($row = mysqli_fetch_array($result)) {
                $courseid = $row["id"];
                $course = $row["course"];
                $courseacro = $row["acronym"];

                echo "<option value='$courseid'>$course ($courseacro)</option>";
            }
        }
        ?>
    </select>
</div>  
<div class="modal-content-footer">
    <button id="insert-btn"><i class='fas fa-plus-circle'></i> Create</button>
    <button id="close-modal-btn"><i class="fas fa-times-circle"></i> Close</button>
</div>
<script>
    document.getElementById("insert-btn").addEventListener("click", function() {
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
				url: "php/admin-colleges-major-insert.php",
				type: "post",
				data: {
					major: major,
					course: course,
				},
				success: function(response) {
					if (response == "success") {
                        if (!alert("Major successfully created.")) {
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