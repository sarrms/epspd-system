<?php
if ($row <= 9 && $row >= 1) {
	$documentnumber = "000" . $row - 2;
}
else if ($row <= 99 && $row >= 10) {
	$documentnumber = "00" . $row - 2;
}
else if ($row <= 999 && $row >= 100) {
	$documentnumber = "0" . $row - 2;
}
else {
	$documentnumber = $row - 2;
}


$email = $activeSheet->getCell("A" . $row)->getValue();
$studentNumber = $activeSheet->getCell("B" . $row)->getValue();
$surname = ucwords(strtolower($activeSheet->getCell("C" . $row)->getValue()));
$givenName = ucwords(strtolower($activeSheet->getCell("D" . $row)->getValue()));
$middleName = ucwords(strtolower($activeSheet->getCell("E" . $row)->getValue()));
$contactNumber = str_replace("-", "	", $activeSheet->getCell("F" . $row)->getValue());
$permanentAddress = ucwords(strtolower($activeSheet->getCell("G" . $row)->getValue()));
$dateString = $activeSheet->getCell("H" . $row)->getValue();
if ($dateString == "") {
	$birthday = "";
}
else {
	$date = DateTime::createFromFormat('Y-m-d', $dateString);
	$birthday = $date->format("F j, Y");
}
$birthPlace = $activeSheet->getCell("I" . $row)->getValue();
$guardian = ucwords(strtolower($activeSheet->getCell("J" . $row)->getValue()));

$enrolledSub = explode(", ", $activeSheet->getCell("K" . $row)->getValue());
$enrolledSubProf = explode(", ", $activeSheet->getCell("L" . $row)->getValue());

$checkbox1 = $activeSheet->getCell("Q" . $row)->getValue();
$checkbox2 = $activeSheet->getCell("R" . $row)->getValue();
$checkbox3 = $activeSheet->getCell("S" . $row)->getValue();
$checkbox4 = $activeSheet->getCell("T" . $row)->getValue();
$checkbox5 = $activeSheet->getCell("U" . $row)->getValue();
$checkbox6 = $activeSheet->getCell("V" . $row)->getValue();
?>
<div id="paper" class="paper">
	<table class="paper-header">
		<tr>
			<td rowspan="5">
				<img src="img/earist-1945-logo.jpg">
			</td>
			<td rowspan="3">
				<i>Republic of the Philippines</i>
				<b>EULOGIO "AMANG" RODRIGUEZ</b>
				<b>INSTITUTE OF SCIENCE AND TECHNOLOGY</b>
				<span>Nagtahan, Sampaloc, Manila 1008</span>
				<b>STUDENT ADMISSION REGISTRATION AND RECORDS</b>
				<b>MANAGEMENT SERVICES</b>
			</td>
			<td>Document No.:</td>
			<td>SARRMS FORM - <?php echo $documentnumber; ?></td>
		</tr>
		<tr>
			<td>Revision No.:</td>
			<td></td>
		</tr>
		<tr>
			<td>Process Type:</td>
			<td></td>
		</tr>
		<tr>
			<td rowspan="2">Application for Evaluation</td>
			<td>Effective Date:</td>
			<td></td>
		</tr>
		<tr>
			<td colspan="2">Page 1 of 1</td>
		</tr>
	</table>
	<div class="paper-body">
		<div class="row1">
			<div class="col1">
				<span>Name of Student:</span>
				<input value="<?php echo $surname . ', ' . $givenName . ' ' . $middleName; ?>" disabled>
				<span>(Pls. PRINT)</span>
				<span>Surname</span>
				<span>Given Name</span>
				<span>Middle Name</span>
			</div>
			<div class="col2">
				<span>Student No.:</span>
				<input value="<?php echo $studentNumber; ?>" disabled>
			</div>
		</div>
		<div class="row2">
			<div class="col1">
				<span>College/Course:</span>
				<input value="<?php echo $courseText ;?>" disabled>
			</div>
			<div class="col2">
				<span>Major:</span>
				<input value="<?php echo $majorText; ?>" disabled>
			</div>
		</div>
		<div class="row3">
			<div class="col1">
				<span>Date Enrolled in EARIST:</span>
				<input value="" disabled>
			</div>
			<div class="col2">
				<span>Date of Birth:</span>
				<input value="<?php echo $birthday; ?>" disabled>
			</div>
		</div>
		<div class="row4">
			<div class="col1">
				<span>Name of Parent/Guardian:</span>
				<input value="<?php echo $guardian; ?>" disabled>
			</div>
			<div class="col2">
				<span>Place of Birth:</span>
				<input value="<?php echo $birthPlace; ?>" disabled>
			</div>
		</div>
		<div class="row5">
			<table>
				<tr class="row5-1">
					<td rowspan="2">
						<span>Permanent Address:</span>
						<textarea disabled><?php echo $permanentAddress; ?></textarea>
					</td>
					<td>
						<span>Tel./Cell No.:</span>
						<input value="<?php echo $contactNumber; ?>" disabled>
					</td>
				</tr>
				<tr class="row5-2">
					<td>
						<span>Email:</span>
						<input value="<?php echo $email; ?>" disabled>
					</td>
				</tr>
			</table>
		</div>
		<div class="row6">
			<span>Credential submitted upon enrollment:</span>
		</div>
		<div class="row7">
			<div class="col1">
				<?php
				if ($checkbox1 == "checked") {
					echo '<input type="checkbox" checked disabled>';
				}
				else {
					echo '<input type="checkbox" disabled>';
				}
				?>
				<label>F138 / SF10 & Good Moral Cert.</label>
				<?php
				if ($checkbox2 == "checked") {
					echo '<input type="checkbox" checked disabled>';
				}
				else {
					echo '<input type="checkbox" disabled>';
				}
				?>
				<label>F-137 / Permanent Record</label>
				<?php
				if ($checkbox3 == "checked") {
					echo '<input type="checkbox" checked disabled>';
				}
				else {
					echo '<input type="checkbox" disabled>';
				}
				?>
				<label>NCEE / NSAT</label>
			</div>
			<div class="col2">
				<?php
				if ($checkbox4 == "checked") {
					echo '<input type="checkbox" checked disabled>';
				}
				else {
					echo '<input type="checkbox" disabled>';
				}
				?>
				<label>Honorable Dismissal & Good Moral Cert.</label>
				<?php
				if ($checkbox5 == "checked") {
					echo '<input type="checkbox" checked disabled>';
				}
				else {
					echo '<input type="checkbox" disabled>';
				}
				?>
				<label>Transcript of Records</label>
				<?php
				if ($checkbox6 == "checked") {
					echo '<input type="checkbox" checked disabled>';
				}
				else {
					echo '<input type="checkbox" disabled>';
				}
				?>
				<label>Others</label>
			</div>
		</div>
		<div class="row8">
			<div class="col1">
				<span>Subject/s presently enrolled – Instructor</span>
				<?php
				$enrolledSubSize = count($enrolledSub);
				for ($i=0; $i<5; $i++) {
					if ($enrolledSubSize > $i) {
						for ($j=0; $j<count($subject); $j++) {
							$splitSub = explode("-", $subject[$j]);

							if ($enrolledSub[$i] == $splitSub[0]) {
								echo "<input value='$splitSub[1]' disabled>";
							}
						}
						for ($j=0; $j<count($professor); $j++) {
							$splitProf = explode("-", $professor[$j]);

							if ($enrolledSubProf[$i] == $splitProf[0]) {
								echo "<input value='$splitProf[1]' disabled>";
							}
						}
					}
					else {
						echo "<input disabled>";
						echo "<input disabled>";
					}
				}
				?>
			</div>
			<div class="col2">
				<span>Subject/s presently enrolled – Instructor</span>
				<?php
				for ($i=5; $i<10; $i++) {
					if ($enrolledSubSize > $i) {
						for ($j=0; $j<count($subject); $j++) {
							$splitSub = explode("-", $subject[$j]);

							if ($enrolledSub[$i] == $splitSub[0]) {
								echo "<input value='$splitSub[1]' disabled>";
							}
						}
						for ($j=0; $j<count($professor); $j++) {
							$splitProf = explode("-", $professor[$j]);

							if ($enrolledSubProf[$i] == $splitProf[0]) {
								echo "<input value='$splitProf[1]' disabled>";
							}
						}
					}
					else {
						echo "<input disabled>";
						echo "<input disabled>";
					}
				}
				?>
			</div>
		</div>
		<div class="row9">
			<div class="col1">
				<span><?php echo date("m/d/Y h:iA"); ?></span>
				<input value="<?php echo $givenName . ' '. $middleName . ' ' . $surname; ?>" disabled>
				<span>Student's Signature</span>
				<span>(Online Application, Signature not Required)</span>
			</div>
			<div class="col2">
				<input value="<?php echo $evaluator; ?>" disabled>
				<span>Evaluator</span>
				<span><?php echo date("l F d, Y"); ?></span>
			</div>
		</div>
	</div>
</div>