<?php
if (isset($_GET["subject"])) {
	$subjectid = $_GET["subject"];
	$select = "SELECT * FROM subject WHERE id=$subjectid";
	$result = $connect -> query($select);
	if ($result -> num_rows > 0) {
		while ($row = mysqli_fetch_array($result)) {
			$subjectcode = $row["code"];
			$subjecttitle = $row["title"];
		}
	}
	echo "<tr>";
		echo "<th>$subjecttitle ($subjectcode)</th>";
		echo "<th style='width: 109px;'>";
			echo "<button id='add-btn' value='$subjectid' title='Add professor to this subject'><i class='fas fa-plus-circle'></i></button>";
		echo "</th>";
	echo "</tr>";

	$select = "SELECT * FROM subjectprofessor WHERE subject=$subjectid ORDER BY professor ASC";
	$result = $connect -> query($select);
	if ($result -> num_rows > 0) {
		while ($row = mysqli_fetch_array($result)) {
			$professor = $row["professor"];

			$select1 = "SELECT * FROM professor WHERE id=$professor";
			$result1 = $connect -> query($select1);
			if ($result1 -> num_rows > 0) {
				while ($row1 = mysqli_fetch_array($result1)) {
					$profid = $row1["id"];
					$proflastname = $row1["lastname"];
					$proffirstname = $row1["firstname"];
					$profmiddlename = $row1["middlename"];
					if ($profmiddlename == "") {
						$profmiddleinitial = "";
					}
					else {
						$profmiddleinitial = substr($profmiddlename, 0, 1) . ". ";
					}

					echo "<tr>";
						echo "<td>$proffirstname $profmiddleinitial $proflastname</td>";
						echo "<td style='width: 109px;'>";
							echo "<button value='$profid' data-value='$subjectid' title='Remove $proffirstname $profmiddleinitial$proflastname from this subject' class='delete-btn'><i class='fas fa-trash'></i></button>";
						echo "</td>";
					echo "</tr>";
				}
			}
		}
	}
	else {
		echo "<tr>";
			echo "<td colspan='2'>Select subject.</td>";
		echo "</tr>";
	}
}
else {
	echo "<tr>";
		echo "<td colspan='2'>Select subject.</td>";
	echo "</tr>";
}
?>
<script>
	document.getElementById("add-btn").addEventListener("click", function() {
		var modal = document.getElementById("modal");
		modal.style.opacity = "1";
		modal.style.pointerEvents = "auto";
		$.ajax({
			url: "php/modal-admin-professors-set.php",
			type: "post",
			data: {
				id: this.value,
			},
			success: function(response) {
				$("#modal-content").html(response);
			}
		});
	});
</script>
<script>
    var deleteBtn = document.getElementsByClassName("delete-btn");
    for (let i=0; i<deleteBtn.length; i++) {
        deleteBtn[i].addEventListener("click", function() {
            if (confirm("Are you sure you want to remove this professor from this subject?")) {
				$.ajax({
					url: "php/admin-professors-set-delete.php",
					type: "post",
					data: {
						subjectid: deleteBtn[i].getAttribute("data-value"),
						profid: deleteBtn[i].value,
					},
					success: function(response) {
						if (response == "success") {
							if (!alert("Professor successfully removed from the subject.")) {
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
    }
</script>