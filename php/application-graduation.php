<?php
date_default_timezone_set("Asia/Manila");
?>
<link rel="stylesheet" href="css/paper-application-graduation.css">
<div class="main-body-header">
	<a id="import-application-graduation" class="active">Import</a>
	<a id="apply-application-graduation">Apply</a>
</div>
<div class="load-menu">
	<div>
		<form id="uploadForm" method="POST" enctype="multipart/form-data">
			<input type="file" name="file" id="fileInput">
			<span id="excel-file-text" class="excel-file-text">No file chosen</span>
			<input type="button" id="uploadButton" value="Import" title="Upload File" class="upload-btn">
		</form>
	</div>
	<div>
		<select id="fileSelect" title="<?php if (isset($_COOKIE['application-for-graduation-file'])) { echo $_COOKIE['application-for-graduation-file']; } else { echo 'Select from file'; } ?>">
			<option value="">none</option>
			<?php
			if (isset($_POST["rel"])) {
				$directory = "../uploads/application-for-graduation/";
			}
			else {
				$directory = "uploads/application-for-graduation/";
			}
			$files = scandir($directory);
			$files = array_diff($files, array(".", ".."));

			foreach ($files as $file) {
				if (isset($_COOKIE["application-for-graduation-file"])) {
					$selfile = $_COOKIE["application-for-graduation-file"];
					if ($selfile == $file) {
						echo "<option value='$file' selected>$file</option>";
					}
					else {
						echo "<option value='$file'>$file</option>";
					}
				}
				else {
					echo "<option value='$file'>$file</option>";
				}
			}
			?>
		</select>
		<button id="select-btn" class="select-btn">Select</button>
	</div>
</div>
<?php
if (isset($_COOKIE["application-for-graduation-file"])) {
	?><div class="paper-main-header">
		<button id="export-btn" title="Export this file">
			<i class="fas fa-file-export"></i> Export file
		</button>
		<button id="view-result-btn" title="View report of all qualified application">
			<i class="fas fa-eye"></i> View report
		</button>
		<button id="view-form-btn" title="View form of all qualified application">
			<i class="fas fa-eye"></i> View form
		</button>
		<button id="view-list-btn" title="View list of all qualified application">
			<i class="fas fa-eye"></i> View list
		</button>
		<button id="accept-multiple-btn" title="Accept multiple application">
			<i class="fas fa-user-check"></i> Accept multiple
		</button>
		<button id="reject-multiple-btn" title="Reject multiple application">
			<i class="fas fa-user-times"></i> Reject multiple
		</button>
		<button id="close-btn" title="Close file">
			<i class="fas fa-times-circle"></i> Close file
		</button>
	</div>
	<script>
		document.getElementById("export-btn").addEventListener("click", function() {
			if (confirm("Are you sure you want to download this file?")) {
				location.href = "export?type=application-for-graduation";
			}
		});
	</script>
	<script>
		document.getElementById("view-result-btn").addEventListener("click", function() {
			window.open("php/view-application-for-graduation.php", "_blank", "toolbar, location=no");
		});
	</script>
	<script>
		document.getElementById("view-form-btn").addEventListener("click", function() {
			window.open("view.php?view=application-for-graduation", "_blank", "toolbar, location=no");
		});
	</script>
	<script>
		document.getElementById("view-list-btn").addEventListener("click", function() {
			location.href = "./?page=list-of-graduates";
		});
	</script>
	<script>
		document.getElementById("accept-multiple-btn").addEventListener("click", function() {
			var modal = document.getElementById("modal");
			modal.style.opacity = "1";
			modal.style.pointerEvents = "auto";
			$.ajax({
				url: "php/modal-action-application-graduation.php",
				type: "post",
				data: {
					action: "accept",
				},
				success: function(response) {
					$("#modal-content").html(response);
				}
			});
		});
	</script>
	<script>
		document.getElementById("reject-multiple-btn").addEventListener("click", function() {
			var modal = document.getElementById("modal");
			modal.style.opacity = "1";
			modal.style.pointerEvents = "auto";
			$.ajax({
				url: "php/modal-action-application-graduation.php",
				type: "post",
				data: {
					action: "reject",
				},
				success: function(response) {
					$("#modal-content").html(response);
				}
			});
		});
	</script>
	<script>
		document.getElementById("close-btn").addEventListener("click", function() {
			document.getElementById("loader").style.display = "inherit";
			document.cookie = "application-for-graduation-file=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/epspd-system";
			location.reload();
		});
	</script><?php
}
?>
<div id="main-paper">
	<?php
	if (isset($_COOKIE["application-for-graduation-file"])) {
		if (isset($_POST["rel"])) {
			include "paper-application-graduation.php";
		}
		else {
			include "php/paper-application-graduation.php";
		}
	}
	?>
</div>
<script>
	document.title = "Application for Graduation - Evaluation Process to Diploma System";
</script>
<script>
	document.getElementById("application-evaluation").classList.remove("active");
	document.getElementById("final-evaluation-result-form").classList.remove("active");
	document.getElementById("application-graduation").classList.add("active");
	document.getElementById("list-graduates").classList.remove("active");
	document.getElementById("create-diploma").classList.remove("active");
</script>
<script>
	$(document).ready(function() {
		$("#uploadButton").on("click", function() {
			document.getElementById("loader").style.display = "inherit";
			var formData = new FormData($('#uploadForm')[0]);
			$.ajax({
				url: "php/upload-application-for-graduation-file.php",
				type: "POST",
				data: formData,
				dataType: "json",
				contentType: false,
				processData: false,
				success: function(response) {
					if (response.message == "success") {
						document.cookie = "application-for-graduation-file = " + document.getElementById("fileInput").files[0].name + ";";
						location.reload();
					}
					else {
						alert(response.message);
					}
					document.getElementById("loader").style.display = "none";
				},
				error: function(xhr, status, error) {
					alert("An error occurred while uploading the file.");
				}
			});
		});
	});
</script>
<script>
	document.getElementById("select-btn").addEventListener("click", function() {
		var fileSelect = document.getElementById("fileSelect").value;
		if (fileSelect == "") {
			alert("Please select file.");
		}
		else if (fileSelect != getCookie("application-for-graduation-file")) {
			document.cookie = "application-for-graduation-file = " + fileSelect + ";";
			document.getElementById("loader").style.display = "inherit";
			location.reload();
		}
		else {
			alert("File is already running.");
		}
	})
</script>