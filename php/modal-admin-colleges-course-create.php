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
    Create Course
</div>
<div class="modal-content-body">
    <i class="icon fas fa-graduation-cap"></i>
    <input id="course" autocomplete="off" placeholder="Course" title="Course">
    <i class="icon fas fa-graduation-cap"></i>
    <input id="acronym" autocomplete="off" placeholder="Course Acronym" title="Course Acronym">
    <select id="college" title="College">
        <option value="" selected hidden>College</option>
        <?php
        $select = "SELECT * FROM college ORDER BY college ASC";
        $result = $connect -> query($select);
        if ($result -> num_rows > 0) {
            while ($row = mysqli_fetch_array($result)) {
                $collegeid = $row["id"];
                $college = $row["college"];
                $collegeacro = $row["acronym"];

                echo "<option value='$collegeid'>$college ($collegeacro)</option>";
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
        var course = $("#course").val();
        var acronym = $("#acronym").val();
        var college = $("#college").val();
        if (course == "") {
            alert("Please input Course.");
        }
        else if (acronym == "") {
            alert("Please input Course Acronym.");
        }
        else if (college == "") {
            alert("Please select College.");
        }
        else {
            $.ajax({
				url: "php/admin-colleges-course-insert.php",
				type: "post",
				data: {
					course: course,
					acronym: acronym,
					college: college,
				},
				success: function(response) {
					if (response == "success") {
                        if (!alert("Course successfully created.")) {
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