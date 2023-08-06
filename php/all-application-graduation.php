<?php
$emailaddress = $activeSheet->getCell("A" . $row)->getValue();
$lastname = ucwords(strtolower($activeSheet->getCell("C" . $row)->getValue()));
$firstname = ucwords(strtolower($activeSheet->getCell("D" . $row)->getValue()));
$middlename = ucwords(strtolower($activeSheet->getCell("E" . $row)->getValue()));
$studentnumber = $activeSheet->getCell("B" . $row)->getValue();
$contactnumber = $activeSheet->getCell("F" . $row)->getValue();
$permanentaddress = $activeSheet->getCell("G" . $row)->getValue();
$enrolledsub = explode(", ", $activeSheet->getCell("K" . $row)->getValue());
$enrolledsubprof = explode(", ", $activeSheet->getCell("L" . $row)->getValue());
$enrolledsubfgrade = explode(", ", $activeSheet->getCell("M" . $row)->getValue());
//sprintf("%.2f", $activeSheet->getCell("I" . $row)->getValue());
$deficiencysub = $activeSheet->getCell("N" . $row)->getValue();
$deficiencysubprof = $activeSheet->getCell("O" . $row)->getValue();
$lacksub = $activeSheet->getCell("P" . $row)->getValue();
$lacksubprof = $activeSheet->getCell("Q" . $row)->getValue();

//GRADE VALUES ARRAY
$gradeValue = ["1.00", "1.25", "1.50", "1.75", "2.00", "2.25", "2.50", "2.75", "3.00", "5.00", "INC", "DRP"];

if ($number < 10) {
	$docnumber = "00$number";
}
else if ($number > 9 && $number < 100) {
	$docnumber = "0$number";
}
else if ($number > 99) {
	$docnumber = $number;
}

?><div id="paper" class="paper">
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
			<td>SARRMS FORM - <?php echo $docnumber; ?></td>
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
			<td rowspan="2">APPLICATION FOR GRADUATION</td>
			<td>Effective Date:</td>
			<td></td>
		</tr>
		<tr>
			<td colspan="2">Page 1 of 1</td>
	</table>
	<div class="paper-body">
		<div class="row1">
			<span><?php echo $college; ?></span>
		</div>
		<div class="row2">
			<span>College</span>
		</div>
		<div class="row3">
			<span><?php echo date("F d, Y"); ?></span>
		</div>
		<div class="row4">
			<span>Date</span>
		</div>
		<div class="row5">
			<span>The President</span>
		</div>
		<div class="row6">
			<span>EARIST, Manila</span>
		</div>
		<div class="row7">
			<span>Sir:</span>
		</div>
		<div class="row8">
			<span>I have the honor to apply for graduation for</span>
			<span><?php echo "$courseText $majorText"; ?></span>
		</div>
		<div class="row9">
			<span>during the school year 20</span>
			<input value="<?php echo date("y", strtotime("-1 year")); ?>" disabled>
			<span>- 20</span>
			<input value="<?php echo date("y"); ?>" disabled>
			<span>.</span>
		</div>
		<table>
			<tr>
				<th>Subjects Precently Enrolled</th>
				<th>Final Grade</th>
				<th>Instructor's Signature</th>
				<th>Remarks</th>
			</tr>
			<?php
			for ($i=0; $i<count($enrolledsub); $i++) {
				echo "<tr>";
					for ($j=0; $j<count($subject); $j++) {
						$split = explode("-", $subject[$j]);
						if ($enrolledsub[$i] == $split[0]) {
							echo "<td>$split[1]</td>";
						}
					}
					if ($enrolledsubfgrade[$i] == 0) {
						$subGrade = "";
					}
					else {
						$subGrade = $gradeValue[$enrolledsubfgrade[$i] - 1];
					}
					echo "<td>$subGrade</td>";
					echo "<td></td>";
					if ($subGrade <= "3.00" AND $subGrade >= "1.00") {
						echo "<td>PASSED</td>";
					}
					else if ($subGrade == "5.00" || $subGrade == "INC" || $subGrade == "DRP") {
						echo "<td>FAILED</td>";
					}
					else {
						echo "<td></td>";
					}
				echo "</tr>";
			}
			for ($j=0; $j<10-count($enrolledsub); $j++) {
				echo "<tr>";
					echo "<td></td>";
					echo "<td></td>";
					echo "<td></td>";
					echo "<td></td>";
				echo "</tr>";
			}
			?>
		</table>
	</div>
	<div class="paper-footer">
		<div class="row1">
			<span>Very truly yours,</span>
		</div>
		<div class="row2">
			<span>Recommending Approval</span>
		</div>
		<div class="row3">
			<input disabled>
		</div>
		<div class="row4">
			<span>Student's Signature</span>
		</div>
		<div class="row5">
			<input value="<?php echo $dean; ?>" disabled>
		</div>
		<div class="row6">
			<div class="col1">
				<span>Dean</span>
			</div>
			<div class="col2">
				<input value="<?php echo $lastname . ', ' . $firstname . ' ' . $middlename; ?>" disabled>
			</div>
		</div>
		<div class="row7">
			<span>Student Name</span>
		</div>
		<div class="row8">
			<div class="col1">
				<input value="<?php echo $registrar; ?>" disabled>
			</div>
			<div class="col2">
				<span>Student No.</span>
				<input value="<?php echo $studentnumber; ?>" disabled>
			</div>
		</div>
		<div class="row9">
			<div class="col1">
				<span>Registrar</span>
			</div>
			<div class="col2">
				<span>Address:</span>
			</div>
		</div>
		<div class="row10">
			<div class="col1">
				<span>Graduation Fee:</span>
			</div>
			<div class="col2">
				<textarea disabled><?php echo $permanentaddress; ?></textarea>
			</div>
		</div>
		<div class="row11">
			<div class="col1">
				<span>AR/OR NO.</span>
				<?php
				$num = $activeSheet->getCell("R" . $row)->getValue();
				if ($num == "") {
					echo "<input value='' disabled>";
				}
				else {
					echo "<input value='$num' disabled>";
				}
				?>
			</div>
			<div class="col2">
				<span>Tel/Cel. No.:</span>
				<input value="<?php echo $contactnumber; ?>" disabled>
			</div>
		</div>
		<div class="row12">
			<div class="col1">
				<span>Amount</span>
				<?php
				$amount = $activeSheet->getCell("S" . $row)->getValue();
				if ($amount == "") {
					echo "<input value='' disabled>";
				}
				else {
					echo "<input value='$amount' disabled>";
				}
				?>
			</div>
			<div class="col2">
				<span>Email Add:</span>
				<input value="<?php echo $emailaddress; ?>" disabled>
			</div>
		</div>
		<div class="row13">
			<span>Date Paid</span>
			<?php
			$datepaid = $activeSheet->getCell("T" . $row)->getValue();
			if ($datepaid == "") {
				echo "<input value='' disabled>";
			}
			else {
				echo "<input value='$datepaid' disabled>";
			}
			?>
		</div>
		<div class="row14">
			<span>*Note: </span>
			<span>(Please attached Photocopy of your "AR/OR" Receipt)</span>
		</div>
		<div class="row15">
			<span>Document/s to be Submitted:</span>
		</div>
		<div class="row16">
			<span>Printed:</span>
			<span></span>
		</div>
	</div>
</div><?php
$number = $number + 1;
?>