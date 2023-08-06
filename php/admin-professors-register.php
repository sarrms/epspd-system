<tr>
	<th>ID</th>
	<th>Prefix</th>
	<th>Last Name</th>
	<th>First Name</th>
	<th>Middle Name</th>
	<th>Action</th>
</tr>
<?php
$select = "SELECT * FROM professor";
$result = $connect -> query($select);
if ($result -> num_rows > 0) {
	while ($row = mysqli_fetch_array($result)) {
		$profid = $row["id"];
		$profprefix = $row["prefix"];
		$proflastname = $row["lastname"];
		$proffirstname = $row["firstname"];
		$profmiddlename = $row["middlename"];
		if ($profmiddlename == "") {
			$profmiddleinitial = "";
		}
		else {
			$profmiddleinitial = substr($profmiddlename, 0, 1) . ". ";
		}

		echo "<tr>";
			echo "<td>$profid</td>";
			echo "<td>$profprefix</td>";
			echo "<td>$proflastname</td>";
			echo "<td>$proffirstname</td>";
			echo "<td>$profmiddlename</td>";
			echo "<td>";
				echo "<button value='$profid' title='Edit $profprefix $proffirstname $profmiddleinitial$proflastname' class='edit-btn'><i class='fas fa-edit'></i></button>";
				echo "<button value='$profid' title='Delete $profprefix $proffirstname $profmiddleinitial$proflastname' class='delete-btn'><i class='fas fa-trash'></i></button>";
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
				url: "php/modal-admin-professors-edit.php",
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
			if (confirm("Are you sure you want to delete this professor? Once this professor was already used, it may cause errors in some part of the system and needs to be fixed.")) {
				$.ajax({
					url: "php/admin-professors-register-delete.php",
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