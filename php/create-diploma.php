<link rel="stylesheet" href="css/diploma.css">
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
		<button id="view-form-btn" title="View diploma of all qualified application">
			<i class="fas fa-eye"></i> View diploma
		</button>
		<button id="close-btn" title="Close file">
			<i class="fas fa-times-circle"></i> Close file
		</button>
	</div>
	<script>
		document.getElementById("view-form-btn").addEventListener("click", function() {
			window.open("view.php?view=create-diploma", "_blank", "toolbar, location=no");
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
<div id="main-paper" class="main-paper">
	<?php
	if (isset($_COOKIE["application-for-graduation-file"])) {
		if (isset($_POST["rel"])) {
			include "paper-diploma.php";
		}
		else {
			include "php/paper-diploma.php";
		}
	}
	?>
</div>
<script>
	document.title = "Create Diploma - Evaluation Process to Diploma System";
</script>
<script>
	document.getElementById("application-evaluation").classList.remove("active");
	document.getElementById("final-evaluation-result-form").classList.remove("active");
	document.getElementById("application-graduation").classList.remove("active");
	document.getElementById("list-graduates").classList.remove("active");
	document.getElementById("create-diploma").classList.add("active");
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