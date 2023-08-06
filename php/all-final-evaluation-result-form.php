<?php
if ($row <= 9 && $row >= 1) {
	$documentnumber = "00" . $row - 2;
}
else if ($row <= 99 && $row >= 10) {
	$documentnumber = "0" . $row - 2;
}
else {
	$documentnumber = $row - 2;
}

$studentNumber = $activeSheet->getCell("B" . $row)->getValue();
$surname = ucwords(strtolower($activeSheet->getCell("C" . $row)->getValue()));
$givenName = ucwords(strtolower($activeSheet->getCell("D" . $row)->getValue()));
$middleName = ucwords(strtolower($activeSheet->getCell("E" . $row)->getValue()));

$enrolledSub = explode(", ", $activeSheet->getCell("K" . $row)->getValue());
$enrolledSubProf = explode(", ", $activeSheet->getCell("L" . $row)->getValue());
$deficiencySub = explode(", ", $activeSheet->getCell("M" . $row)->getValue());
$deficiencySubProf = explode(", ", $activeSheet->getCell("N" . $row)->getValue());
$lackSub = explode(", ", $activeSheet->getCell("O" . $row)->getValue());
$lackSubProf = explode(", ", $activeSheet->getCell("P" . $row)->getValue());
?>
<div class="paper">
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
			<td rowspan="2">Final Evaluation Result Form</td>
			<td>Effective Date:</td>
			<td></td>
		</tr>
		<tr>
			<td colspan="2">Page 1 of 1</td>
		</tr>
	</table>
	<div class="paper-body">
		<div class="row1">
			<div>
				<span>Student No:</span>
				<input value="<?php echo $studentNumber; ?>" disabled>
			</div>
			<div>
				<input value="<?php echo date("F d, Y"); ?>" disabled>
				<span>Date</span>
			</div>
		</div>
		<div class="row2">
			<div>
				<span>Mr./Ms.</span>
				<input value="<?php echo $surname . ', '. $givenName . ' ' . $middleName; ?>" disabled>
				<span>Student's Name</span>
			</div>
			<div>
				<input value="<?php echo "$courseacro $majorText"; ?>" disabled>
				<span>College/Course</span>
			</div>
		</div>
		<p>In compliance with your request for a final evaluation of your record filed in this Office, we would like to inform you that after a thorough checking and evaluating your records, it has been found that you are deficient in the following:</p>
		<table class="paper-info-body1">
			<tr class="row1">
				<th colspan="2">1. As to credentials submitted in this office:</th>
			</tr>
			<tr class="row2">
				<td colspan="2"></td>
			</tr>
			<tr class="row3">
				<th>
					<?php
					$cb1 = $activeSheet->getCell("Q" . $row)->getValue();
					if ($cb1 == "checked") {
						echo "<input value='OK' disabled>";
					}
					else {
						echo "<input value='✘' disabled>";
					}
					?>
					No F137 or HS/SHS Permanent Record
				</th>
				<th>
					<?php
					$cb5 = $activeSheet->getCell("U" . $row)->getValue();
					if ($cb5 == "") {
						$cb5Arr = [];
						echo "<input disabled>";
					}
					else {
						$cb5Arr = explode(", ", $cb5);
						echo "<input value='OK' disabled>";
					}
					?>
					No ROTC-MS / NSTP-CWTS Grades
				</th>
			</tr>
			<tr class="row4">
				<th>
					<?php
					$cb2 = $activeSheet->getCell("R" . $row)->getValue();
					if ($cb2 == "checked") {
						echo "<input value='OK' disabled>";
					}
					else {
						echo "<input value='✓' disabled>";
					}
					?>
					No Official Transcript of Records
				</th>
				<td>
					<table>
						<tr>
							<td>
								<?php
								if ($cb5 == "") {
									echo "<input disabled>";
								}
								else {
									if (in_array("CWTS 1", $cb5Arr)) {
										echo "<input value='OK' disabled>";
									}
									else {
										echo "<input disabled>";
									}
								}
								?>
								CWTS 1
							</td>
							<td>
								<?php
								if ($cb5 == "") {
									echo "<input disabled>";
								}
								else {
									if (in_array("CWTS 2", $cb5Arr)) {
										echo "<input value='OK' disabled>";
									}
									else {
										echo "<input disabled>";
									}
								}
								?>
								CWTS 2
							</td>
						</tr>
					</table>
				</td>
			</tr>
			<tr class="row5">
				<th>
					<?php
					$cb3 = $activeSheet->getCell("S" . $row)->getValue();
					if ($cb3 == "checked") {
						echo "<input value='OK' disabled>";
					}
					else {
						echo "<input value='✘' disabled>";
					}
					?>
					No Certified Copy of Birth Certificate
				</th>
				<td>
					<table>
						<tr>
							<td>
								<?php
								if ($cb5 == "") {
									echo "<input disabled>";
								}
								else {
									if (in_array("MTS 2", $cb5Arr)) {
										echo "<input value='OK' disabled>";
									}
									else {
										echo "<input disabled>";
									}
								}
								?>
								MTS 1
							</td>
							<td>
								<?php
								if ($cb5 == "") {
									echo "<input disabled>";
								}
								else {
									if (in_array("MTS 2", $cb5Arr)) {
										echo "<input value='OK' disabled>";
									}
									else {
										echo "<input disabled>";
									}
								}
								?>
								MTS 2
							</td>
						</tr>
					</table>
				</td>
			</tr>
			<tr class="row6">
				<th>
					<?php
					$cb4 = $activeSheet->getCell("T" . $row)->getValue();
					if ($cb4 == "checked") {
						echo "<input value='OK' disabled>";
					}
					else {
						echo "<input value='✘' disabled>";
					}
					?>
					2 pcs.  2 x 2 picture (white background)
				</th>
				<th>
					<?php
					$cb6 = $activeSheet->getCell("V" . $row)->getValue();
					if ($cb6 == "") {
						echo "<input disabled>";
					}
					else {
						echo "<input value='OK' disabled>";
					}
					?>
					Others:
					<?php
					if ($cb6 == "") {
						echo "<input disabled>";
					}
					else {
						echo "<input value='$cb6' disabled>";
					}
					?>
				</th>
			</tr>
		</table>
		<table class="paper-info-body2">
			<tr class="row1">
				<th colspan="2">2. No final grade/s in the following subject/s: (PLS. VERIFY)</th>
			</tr>
			<?php
			$deficiencySubSize = count($deficiencySub);
			for ($i=0; $i<5; $i++) {
				echo "<tr class='row" . $i + 2 . "'>";
				if ($activeSheet->getCell("M" . $row)->getValue() == "") {
					echo "<td>";
						echo "<input disabled>";
						echo "<input disabled>";
					echo "</td>";
					echo "<td>";
						echo "<input disabled>";
						echo "<input disabled>";
					echo "</td>";
				}
				else if ($deficiencySubSize > 5) {
					echo "<td>";
						for ($j=0; $j<count($subject); $j++) {
							$splitSub = explode("-", $subject[$j]);

							if ($deficiencySub[$i] == $splitSub[0]) {
								echo "<input value='$splitSub[1]' disabled>";
							}
						}
						for ($j=0; $j<count($professor); $j++) {
							$splitProf = explode("-", $professor[$j]);

							if ($deficiencySubProf[$i] == $splitProf[0]) {
								echo "<input value='$splitProf[1]' disabled>";
							}
						}
					echo "</td>";
					echo "<td>";
						if ($i + 5 < $deficiencySubSize) {
							$k = $i + 5;
							for ($j=0; $j<count($subject); $j++) {
								$splitSub = explode("-", $subject[$j]);

								if ($deficiencySub[$k] == $splitSub[0]) {
									echo "<input value='$splitSub[1]' disabled>";
								}
							}
							for ($j=0; $j<count($professor); $j++) {
								$splitProf = explode("-", $professor[$j]);

								if ($deficiencySub[$k] == $splitProf[0]) {
									echo "<input value='$splitProf[1]' disabled>";
								}
							}
						}
						else {
							echo "<input disabled>";
							echo "<input disabled>";
						}
					echo "</td>";
				}
				else {
					if ($i < $deficiencySubSize) {
						echo "<td>";
							for ($j=0; $j<count($subject); $j++) {
								$splitSub = explode("-", $subject[$j]);

								if ($deficiencySub[$i] == $splitSub[0]) {
									echo "<input value='$splitSub[1]' disabled>";
								}
							}
							for ($j=0; $j<count($professor); $j++) {
								$splitProf = explode("-", $professor[$j]);

								if ($deficiencySubProf[$i] == $splitProf[0]) {
									echo "<input value='$splitProf[1]' disabled>";
								}
							}
						echo "</td>";
						echo "<td>";
							echo "<input disabled>";
							echo "<input disabled>";
						echo "</td>";
					}
					else {
						echo "<td>";
							echo "<input disabled>";
							echo "<input disabled>";
						echo "</td>";
						echo "<td>";
							echo "<input disabled>";
							echo "<input disabled>";
						echo "</td>";
					}
				}
				echo "</tr>";
			}
			?>
		</table>
		<table class="paper-info-body3">
			<tr class="row1">
				<th colspan="2">3. Subject/s presently enrolled:</th>
			</tr>
			<?php
			$enrolledSubSize = count($enrolledSub);
			for ($i=0; $i<5; $i++) {
				echo "<tr class='row" . $i + 2 . "'>";
				if ($activeSheet->getCell("K" . $row)->getValue() == "") {
					echo "<td>";
						echo "<input disabled>";
						echo "<input disabled>";
					echo "</td>";
					echo "<td>";
						echo "<input disabled>";
						echo "<input disabled>";
					echo "</td>";
				}
				else if ($enrolledSubSize > 5) {
					echo "<td>";
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
					echo "</td>";
					echo "<td>";
						if ($i + 5 < $enrolledSubSize) {
							$k = $i + 5;
							for ($j=0; $j<count($subject); $j++) {
								$splitSub = explode("-", $subject[$j]);

								if ($enrolledSub[$k] == $splitSub[0]) {
									echo "<input value='$splitSub[1]' disabled>";
								}
							}
							for ($j=0; $j<count($professor); $j++) {
								$splitProf = explode("-", $professor[$j]);

								if ($enrolledSubProf[$k] == $splitProf[0]) {
									echo "<input value='$splitProf[1]' disabled>";
								}
							}
						}
						else {
							echo "<input disabled>";
							echo "<input disabled>";
						}
					echo "</td>";
				}
				else {
					if ($i < $enrolledSubSize) {
						echo "<td>";
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
						echo "</td>";
						echo "<td>";
							echo "<input disabled>";
							echo "<input disabled>";
						echo "</td>";
					}
					else {
						echo "<td>";
							echo "<input disabled>";
							echo "<input disabled>";
						echo "</td>";
						echo "<td>";
							echo "<input disabled>";
							echo "<input disabled>";
						echo "</td>";
					}
				}
				echo "</tr>";
			}
			?>
		</table>
		<table class="paper-info-body4">
			<tr class="row1">
				<th>4. Lack Subject/s:</th>
				<th>5. Curriculum/Track/Bridging Details:</th>
			</tr>
			<?php
			$lackSubSize = count($lackSub);
			for ($i=0; $i<5; $i++) {
				$fileDetails = $activeSheet->getCell("W" . $row)->getValue();
				if ($fileDetails != "") {
					$details = explode(", ", $fileDetails);
				}
				else {
					$details = [];
				}
				echo "<tr class='row" . $i + 2 . "'>";
					if ($activeSheet->getCell("O" . $row)->getValue() == "") {
						echo "<td>";
							echo "<input disabled>";
							echo "<input disabled>";
						echo "</td>";
						if ($i < 3) {
							echo "<td>";
								if ($i < count($details)) {
									echo "<input value='$details[$i]' disabled>";
								}
								else {
									echo "<input value='' disabled>";
								}
							echo "</td>";
						}
					}
					else {
						echo "<td>";
							if ($i < $lackSubSize) {
								for ($j=0; $j<count($subject); $j++) {
									$splitSub = explode("-", $subject[$j]);
									if ($lackSub[$i] == $splitSub[0]) {
										echo "<input value='$splitSub[1]' disabled>";
									}
								}
								for ($j=0; $j<count($professor); $j++) {
									$splitProf = explode("-", $professor[$j]);
									if ($lackSubProf[$i] == $splitProf[0]) {
										echo "<input value='$splitProf[1]' disabled>";
									}
								}
							}
							else {
								echo "<input disabled>";
								echo "<input disabled>";
							}
						echo "</td>";
						if ($i < 3) {
							echo "<td>";
								echo "<input disabled>";
							echo "</td>";
						}
					}
				echo "</tr>";
			}
			?>
		</table>
		<div class="evaluator">
			<input value="<?php echo $evaluator; ?>" disabled>
			<span>Evaluator</span>
		</div>
		<div class="dean">
			<input value="<?php echo $dean; ?>" disabled>
			<span>Dean</span>
		</div>
		<div class="registrar">
			<input value="<?php echo $registrar; ?>" disabled>
			<span>Registrar</span>
		</div>
	</div>
	<div class="paper-footer">
		<h1>Note:</h1>
		<p>This form must be returned to the Registrar’s Office after verifying grades, with verifies initial and Dean’s Signature.</p>
		<p>It is requested that the required documents be submitted not later than  <span class="paper-footer-date"><?php echo date("F d, Y"); ?></span> in order that action may be expedited on this application. Please be guided accordingly.</p>
		<div class="legend">
			<h2>Legend:</h2>
			<table>
				<tr>
					<td>✓ - Need to Submit</td>
					<td>✘ - Not Required</td>
					<td>OK - Cleared</td>
					<td>Date Printed:</td>
					<td><?php echo date("l, d F Y"); ?></td>
				</tr>
			</table>
		</div>
	</div>
</div>