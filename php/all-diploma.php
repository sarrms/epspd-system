<?php
$surname = ucwords(strtolower($activeSheet->getCell("C" . $row)->getValue()));
$givenName = ucwords(strtolower($activeSheet->getCell("D" . $row)->getValue()));
$middleName = ucwords(strtolower($activeSheet->getCell("E" . $row)->getValue()));
if ($middleName == "") {
	$middleInitial = "";
}
else {
	$middleInitial = substr($middleName, 0, 1) . ".";
}
?>
<div class="diploma">
	<img src="img/earist-1945-logo.jpg" class="diploma-logo">
	<div class="row1"><?php echo $row1; ?></div>
	<div class="row2"><?php echo $row2; ?></div>
	<div class="row3"><?php echo $row3; ?></div>
	<div class="row4"><?php echo $row4; ?></div>
	<div class="row5"><?php echo $row5; ?></div>
	<div class="row6"><?php echo $row6; ?></div>
	<div class="row7"><?php echo $row7; ?></div>
	<div class="row8"><?php echo $row8; ?></div>
	<div class="row9"><?php echo $row9; ?></div>
	<div class="row10"><?php echo $row10; ?></div>
	<div class="row11"><?php echo $row11; ?></div>
	<div class="row12"><?php echo $row12; ?></div>
	<div class="row13"><?php echo $row13; ?></div>
	<div class="row14"><?php echo $row14; ?></div>
	<div class="row15"><?php echo "$givenName $middleInitial $surname"; ?></div>
	<div class="row16"><?php echo $row16; ?></div>
	<div class="row17"><?php echo $row17; ?></div>
	<div class="row18"><?php echo $courseEn; ?></div>
	<div class="row19"><?php echo $courseTl; ?></div>
	<?php
	if ($fileMajor != "") {
		?><div class="row20">Major in <?php echo $majorEn; ?></div>
		<div class="row21">Medyor sa <?php echo $majorTl; ?></div><?php
	}
	?>
	<div class="row22"><?php echo $row22; ?></div>
	<div class="row23"><?php echo $row23; ?></div>
	<div class="row24"><?php echo $row24; ?></div>
	<div class="row25"><?php echo $row25; ?></div>
	<div class="row26"><?php echo $row26; ?></div>
	<div class="row27"><?php echo $row27; ?></div>
	<div class="row28"><?php echo $row28; ?></div>
	<div class="row29"><?php echo $row29; ?></div>
	<div class="footer">
		<div class="col1">
			<div class="row30"><?php echo $president; ?></div>
			<div class="row31">President</div>
			<div class="row32">Pangulo</div>
		</div>
		<div class="col2">
			<div class="row33"><?php echo $registrar; ?></div>
			<div class="row34">Registrar</div>
			<div class="row35">Tagatala</div>
		</div>
		<div class="col3">
			<div class="row36"><?php echo $dean; ?></div>
			<div class="row37">Dean</div>
			<div class="row38">Dekano</div>
		</div>
	</div>
</div>