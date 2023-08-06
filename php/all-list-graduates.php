<div id="paper" class="paper">
	<table>
		<tr>
			<th colspan="4"><?php echo $college; ?></th>
		</tr>
		<tr>
			<th colspan="4"><?php echo "$courseText $majorText"; ?></th>
		</tr>
		<tr>
			<th>No.</th>
			<th>Last Name</th>
			<th>First Name</th>
			<th>M.I.</th>
		</tr>
		<?php
		for ($row=3; $row<=$highestRow; $row++) {
			$action = $activeSheet->getCell("AB" . $row)->getValue();
			if ($action == "accepted") {
				$lastname = ucwords(strtolower($activeSheet->getCell("C" . $row)->getValue()));
				$firstname = ucwords(strtolower($activeSheet->getCell("D" . $row)->getValue()));
				$middleInitial = strtoupper(substr($activeSheet->getCell("E" . $row)->getValue(), 0, 1));
				echo "<tr>";
					echo "<td>$number</td>";
					echo "<td>$lastname</td>";
					echo "<td>$firstname</td>";
					if ($middleInitial != "") {
						echo "<td>$middleInitial.</td>";
					}
				echo "</tr>";
				$number = $number + 1;
			}
		}
		?>
	</table>
</div>
<?php
?>