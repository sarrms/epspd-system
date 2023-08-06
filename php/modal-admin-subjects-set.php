<?php
include "connect.php";
$id = $_POST["id"];
?>
<style>
    .modal-content-body select {
        cursor: pointer;
        padding: 10px;
        width: 100%;
        margin-bottom: 10px;
        border: 1px solid #dddddd;
        outline: none;
    }
    .modal-content-footer button:first-child {
        background-color: #1a73e8;
    }
</style>
<?php
$select = "SELECT * FROM coursesubject WHERE id=$id";
$result = $connect -> query($select);
if ($result -> num_rows > 0) {
	while ($row = mysqli_fetch_array($result)) {
		$college = $row["college"];
		$course = $row["course"];
		$subject = $row["subject"];
		$yearlevel = $row["yearlevel"];
		$semester = $row["semester"];
	}
}
?>
<div class="modal-content-header">
    <?php
    $select = "SELECT * FROM subject WHERE id=$subject";
    $result = $connect -> query($select);
    if ($result -> num_rows > 0) {
        while ($row = mysqli_fetch_array($result)) {
            $subjectcode = $row["code"];

            echo "$subjectcode Settings";
        }
    }
    ?>
</div>
<div class="modal-content-body">
    <select id="college" title="College">
        <option value="" selected hidden>College</option>
        <?php
        $select = "SELECT * FROM college";
        $result = $connect -> query($select);
        if ($result -> num_rows > 0) {
            while ($row = mysqli_fetch_array($result)) {
                $collegeid = $row["id"];
                $collegeacro = $row["acronym"];
                $collegename = $row["college"];

                if ($collegeid == $college) {
                    echo "<option value='$collegeid' selected>$collegename ($collegeacro)</option>";
                }
                else {
                    echo "<option value='$collegeid'>$collegename ($collegeacro)</option>";
                }
            }
        }
        ?>
    </select>
    <select id="course" title="Course">
        <option value="" selected>All</option>
        <?php
        $select = "SELECT * FROM course WHERE college=$college";
        $result = $connect -> query($select);
        if ($result -> num_rows > 0) {
            while ($row = mysqli_fetch_array($result)) {
                $courseid = $row["id"];
                $courseacro = $row["acronym"];
                $coursename = $row["course"];

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
    <select id="year-level" title="Year Level">
        <option value="" selected hidden>Year Level</option>
        <?php
        for ($i=1; $i<=4; $i++) {
            if ($i == $yearlevel) {
                echo "<option value='$yearlevel' selected>$yearlevel</option>";
            }
            else {
                echo "<option value='$i'>$i</option>";
            }
        }
        ?>
    </select>
    <select id="semester" title="Semester">
        <option value="" selected hidden>Semester</option>
        <?php
        for ($i=1; $i<=2; $i++) {
            if ($i == $semester) {
                echo "<option value='$semester' selected>$semester</option>";
            }
            else {
                echo "<option value='$i'>$i</option>";
            }
        }
        ?>
    </select>
</div>
<div class="modal-content-footer">
    <button id="save-btn"><i class="fas fa-save"></i> Save</button>
    <button id="close-modal-btn"><i class="fas fa-times-circle"></i> Close</button>
</div>
<script>
    document.getElementById("save-btn").addEventListener("click", function() {
        var college = $("#college").val();
        var yearLevel = $("#year-level").val();
        var semester = $("#semester").val();
        if (college == "") {
            alert("Please select college.");
        }
        else if (yearLevel == "") {
            alert("Please select year level.");
        }
        else if (semester == "") {
            alert("Please select semester.");
        }
        else {
            var course = $("#course").val();
            $.ajax({
				url: "php/admin-subjects-set-update.php",
				type: "post",
				data: {
					subject: "<?php echo $subject; ?>",
					college: college,
					course: course,
					yearlevel: yearLevel,
					semester: semester,
				},
				success: function(response) {
					if (response == "success") {
                        if (!alert("Subject successfully updated.")) {
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