<tr>
	<th>Subject Code</th>
	<th>Subject Title</th>
	<th>College</th>
	<th>Course</th>
	<th>Year Level</th>
	<th>Semester</th>
	<th>Action</th>
</tr>
<?php
$selects = [];
if (isset($_GET["college"])) {
	$college = $_GET["college"];
	array_push($selects, "college='$college'");
}
if (isset($_GET["course"])) {
	$course = $_GET["course"];
	array_push($selects, "course='$course'");
}
if (isset($_GET["yearlevel"])) {
	$yearlevel = $_GET["yearlevel"];
	array_push($selects, "yearlevel='$yearlevel'");
}
if (isset($_GET["semester"])) {
	$semester = $_GET["semester"];
	array_push($selects, "semester='$semester'");
}
$newSelects = implode(" AND ", $selects);
$select = "SELECT * FROM coursesubject";
if (!empty($newSelects)) {
    $select .= " WHERE " . $newSelects;
}
$select .= " ORDER BY college, course, yearlevel, semester, subject ASC";
$result = $connect -> query($select);
if ($result -> num_rows > 0) {
	while ($row = mysqli_fetch_array($result)) {
		$id = $row["id"];
		$college = $row["college"];
		$course = $row["course"];
		$subject = $row["subject"];
		$yearlevel = $row["yearlevel"];
		$semester = $row["semester"];

        $select1 = "SELECT * FROM college WHERE id=$college";
        $result1 = $connect -> query($select1);
        if ($result1 -> num_rows > 0) {
            while ($row1 = mysqli_fetch_array($result1)) {
                $collegeacronym = $row1["acronym"];
            }
        }
		else {
			$collegeacronym = "";
		}

        $select1 = "SELECT * FROM subject WHERE id=$subject";
        $result1 = $connect -> query($select1);
        if ($result1 -> num_rows > 0) {
            while ($row1 = mysqli_fetch_array($result1)) {
                $subjectcode = $row1["code"];
                $subjecttitle = $row1["title"];
            }
        }

        if ($course == 0) {
            $courseacronym = "";
        }
        else {
            $select1 = "SELECT * FROM course WHERE id=$course";
            $result1 = $connect -> query($select1);
            if ($result1 -> num_rows > 0) {
                while ($row1 = mysqli_fetch_array($result1)) {
                    $courseacronym = $row1["acronym"];
                }
            }
        }
        
		echo "<tr>";
			echo "<td style='text-align: left;'>$subjectcode</td>";
			echo "<td>$subjecttitle</td>";
			echo "<td>$collegeacronym</td>";
			echo "<td>$courseacronym</td>";
			echo "<td>";
				if ($yearlevel != 0) {
					echo $yearlevel;
				}
			echo "</td>";
			echo "<td>";
				if ($semester != 0) {
					echo $semester;
				}
			echo "</td>";
			echo "<td>";
				echo "<button value='$id' title='Edit $subjectcode' class='edit-btn'><i class='fas fa-edit'></i></button>";
			echo "</td>";
		echo "</tr>";
	}
}
else {
	echo "<tr>";
		echo "<td colspan='7'>No subjects.</td>";
	echo "</tr>";
}
?>
<script>
    var editBtn = document.getElementsByClassName("edit-btn");
    for (let i=0; i<editBtn.length; i++) {
        editBtn[i].addEventListener("click", function() {
            var modal = document.getElementById("modal");
			modal.style.opacity = "1";
			modal.style.pointerEvents = "auto";
			$.ajax({
				url: "php/modal-admin-subjects-set.php",
				type: "post",
				data: {
					id: editBtn[i].value,
				},
				success: function(response) {
					$("#modal-content").html(response);
				}
			});
        });
    }
</script>