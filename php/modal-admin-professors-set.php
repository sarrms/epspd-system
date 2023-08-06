<?php
include "connect.php";
$id = $_POST["id"];
?>
<style>
    .modal-content-body select {
        cursor: pointer;
        padding: 10px;
        width: 100%;
        margin-bottom: 10px;
        border: 1px solid #dddddd;
        outline: none;
    }
    .modal-content-footer button:first-child {
        background-color: #34a853;
    }
</style>
<div class="modal-content-header">
    <?php
    $select = "SELECT * FROM subject WHERE id=$id";
    $result = $connect -> query($select);
    if ($result -> num_rows > 0) {
        while ($row = mysqli_fetch_array($result)) {
            $subjectcode = $row["code"];

            echo "Add Professor to $subjectcode";
        }
    }
    ?>
</div>
<div class="modal-content-body">
    <select id="select-professor" title="Professor">
        <option value="" selected hidden>Professor</option>
        <?php
        $select = "SELECT * FROM professor ORDER BY lastname, firstname, middlename ASC";
        $result = $connect -> query($select);
        if ($result -> num_rows > 0) {
            while ($row = mysqli_fetch_array($result)) {
                $profid = $row["id"];
                $proflastname = $row["lastname"];
                $proffirstname = $row["firstname"];
                $profmiddlename = $row["middlename"];
                if ($profmiddlename == "") {
                    $profmiddleinitial = "";
                }
                else {
                    $profmiddleinitial = substr($profmiddlename, 0, 1) . ". ";
                }

                echo "<option value='$profid'>$proflastname, $proffirstname $profmiddleinitial</option>";
            }
        }
        ?>
    </select>
</div>
<div class="modal-content-footer">
    <button id="add-professor-btn" value="<?php echo $id; ?>"><i class="fas fa-plus-circle"></i> Add</button>
    <button id="close-modal-btn"><i class="fas fa-times-circle"></i> Close</button>
</div>
<script>
    document.getElementById("add-professor-btn").addEventListener("click", function() {
        var subject = document.getElementById("add-professor-btn").value;
        var professor = document.getElementById("select-professor").value;
        if (professor == "") {
            alert("Please select professor.");
        }
        else {
            $.ajax({
				url: "php/admin-professors-set-insert.php",
				type: "post",
				data: {
					subjectid: subject,
					profid: professor,
				},
				success: function(response) {
					if (response == "success") {
                        if (!alert("Professor successfully added.")) {
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
</script>
<script>
    document.getElementById("close-modal-btn").addEventListener("click", function() {
        var modal = document.getElementById("modal");
        modal.style.opacity = "0";
        modal.style.pointerEvents = "none";
        $("#modal-content").html("");
    });
</script>