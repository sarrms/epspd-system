<link rel="stylesheet" href="css/paper-application-evaluation.css">
<div class="main-body-header">
	<a id="import-application-evaluation" class="active">Import</a>
	<a id="apply-application-evaluation">Apply</a>
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
		<select id="fileSelect" title="<?php if (isset($_COOKIE['application-for-evaluation-file'])) { echo $_COOKIE['application-for-evaluation-file']; } else { echo 'Select from file'; } ?>">
			<option value="">none</option>
			<?php
			$directory = "uploads/application-for-evaluation/";
			$files = scandir($directory);
			$files = array_diff($files, array(".", ".."));

			foreach ($files as $file) {
				if (isset($_COOKIE["application-for-evaluation-file"])) {
					$file == $_COOKIE["application-for-evaluation-file"];
					echo "<option value='$file' selected>$file</option>";
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
if (isset($_COOKIE["application-for-evaluation-file"])) {
	?><div class="paper-main-header">
		<button id="save-btn" title="Save to Final Evaluation Result Form">
			<i class="fas fa-save"></i> Save file
		</button>
		<button id="export-btn" title="Export this file">
			<i class="fas fa-file-export"></i> Export file
		</button>
		<button id="view-result-btn" title="View final list of applications">
			<i class="fas fa-eye"></i> View report
		</button>
		<button id="view-all-btn" title="View forms of accepted applications">
			<i class="fas fa-eye"></i> View form
		</button>
		<button id="close-btn" title="Close file">
			<i class="fas fa-times-circle"></i> Close file
		</button>
	</div>
	<script>
		document.getElementById("save-btn").addEventListener("click", function() {
			if (confirm('Are you sure you want to save this file? This file will be automatically saved to "uploads/final-evaluation-result-form/" and will be usable to Final Evaluation Result Form.')) {
				document.getElementById("loader").style.display = "inherit";
				$.ajax({
					url: "php/save-file.php",
					type: "post",
					data: {
						from: "application-for-evaluation",
						to: "final-evaluation-result-form",
					},
					success: function(response) {
						if (response == "success") {
							alert('Successfully saved to "uploads/final-evaluation-result-form/".');
						}
						else {
							alert(response);
						}
						document.getElementById("loader").style.display = "none";
					}
				});
			}
		});
	</script>
	<script>
		document.getElementById("export-btn").addEventListener("click", function() {
			if (confirm("Are you sure you want to download this file?")) {
				location.href = "export?type=application-for-evaluation";
			}
		});
	</script>
	<script>
		document.getElementById("view-result-btn").addEventListener("click", function() {
			window.open("php/view-application-for-evaluation.php", "_blank", "toolbar, location=no");
		});
	</script>
	<script>
		document.getElementById("view-all-btn").addEventListener("click", function() {
			window.open("view.php?view=application-for-evaluation", "_blank", toolbar);
		});
	</script>
	<script>
		document.getElementById("close-btn").addEventListener("click", function() {
			document.getElementById("loader").style.display = "inherit";
			document.cookie = "application-for-evaluation-file=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/epspd-system";
			location.reload();
		});
	</script><?php
}
?>
<div id="main-paper">
	<?php
	if (isset($_COOKIE["application-for-evaluation-file"])) {
		include "php/paper-application-evaluation.php";
	}
	?>
</div>
<script>
	document.title = "Application for Evaluation - Evaluation Process to Diploma System";
</script>
<script>
	document.getElementById("application-evaluation").classList.add("active");
	document.getElementById("final-evaluation-result-form").classList.remove("active");
	document.getElementById("application-graduation").classList.remove("active");
	document.getElementById("list-graduates").classList.remove("active");
	document.getElementById("create-diploma").classList.remove("active");
</script>
<script>
	document.getElementById("import-application-evaluation").addEventListener("click", function() {
		document.getElementById("loader").style.display = "inherit";
		location.reload();
	});
</script>
<?php
if (!isset($_COOKIE["application-for-evaluation-file"])) {
	?><script>
		document.getElementById("apply-application-evaluation").addEventListener("click", function() {
			alert("Please import/select file first.");
		});
	</script><?php
}
?>
<script>
	$(document).ready(function() {
		$("#uploadButton").on("click", function() {
			document.getElementById("loader").style.display = "inherit";
			var formData = new FormData($('#uploadForm')[0]);
			$.ajax({
				url: "php/upload-application-for-evaluation-file.php",
				type: "POST",
				data: formData,
				dataType: "json",
				contentType: false,
				processData: false,
				success: function(response) {
					if (response.message == "success") {
						document.cookie = "application-for-evaluation-file = " + document.getElementById("fileInput").files[0].name + ";";
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
	var fileInput = document.getElementById("fileInput");
	fileInput.addEventListener("change", function() {
		document.getElementById("excel-file-text").innerHTML = fileInput.files[0].name;
	});
</script>
<script>
	document.getElementById("select-btn").addEventListener("click", function() {
		var fileSelect = document.getElementById("fileSelect").value;
		if (fileSelect == "") {
			alert("Please select file.");
		}
		else if (fileSelect != getCookie("application-for-evaluation-file")) {
			document.cookie = "application-for-evaluation-file = " + fileSelect + ";";
			document.getElementById("loader").style.display = "inherit";
			location.reload();
		}
		else {
			alert("File is already running.");
		}
	})
</script>