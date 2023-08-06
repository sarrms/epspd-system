<tr>
	<th rowspan="2">ID</th>
	<th rowspan="2">Code</th>
	<th rowspan="2">Title</th>
	<th colspan="3">Unit</th>
	<th rowspan="2">Action</th>
</tr>
<tr>
	<th>Lec</th>
	<th>Lab</th>
	<th>Credit</th>
</tr>
<?php
$select = "SELECT * FROM subject";
$result = $connect -> query($select);
if ($result -> num_rows > 0) {
	while ($row = mysqli_fetch_array($result)) {
		$subjectid = $row["id"];
		$subjectcode = $row["code"];
		$subject = $row["title"];
		$subjectunitlec = $row["unitlec"];
		$subjectunitlab = $row["unitlab"];
		$subjectunitcredit = number_format($subjectunitlec + $subjectunitlab, 1);

		echo "<tr>";
			echo "<td>$subjectid</td>";
			echo "<td>$subjectcode</td>";
			echo "<td>$subject</td>";
			echo "<td>$subjectunitlec</td>";
			echo "<td>$subjectunitlab</td>";
			echo "<td>$subjectunitcredit</td>";
			echo "<td>";
				echo "<button value='$subjectid' title='Edit $subjectcode' class='edit-btn'><i class='fas fa-edit'></i></button>";
				echo "<button value='$subjectid' title='Delete $subjectcode' class='delete-btn'><i class='fas fa-trash'></i></button>";
			echo "</td>";
		echo "</tr>";
	}
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
				url: "php/modal-admin-subjects-edit.php",
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
<script>
	var deleteBtn = document.getElementsByClassName("delete-btn");
	for (let i=0; i<deleteBtn.length; i++) {
		deleteBtn[i].addEventListener("click", function() {
			if (confirm("Are you sure you want to delete this subject? Once this subject was already used, it may cause errors in some part of the system and needs to be fixed.")) {
				$.ajax({
					url: "php/admin-subjects-create-delete.php",
					type: "post",
					data: {
						id: deleteBtn[i].value,
					},
					success: function(response) {
						if (response == "success") {
							if (!alert("Subject successfully deleted.")) {
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