<?php
$targetDir = "../uploads/application-for-graduation/";
$targetFile = $targetDir . basename($_FILES["file"]["name"]);
$uploadOk = true;
$response = array();

if ($_FILES["file"]["name"] != "") {
    if (file_exists($targetFile)) {
        $response["error"] = true;
        $response["message"] = $_FILES["file"]["name"] . " already exists.";
    }
    else {
        $allowed_extension = array("xls", "xlsx");
        $file_array = explode(".", $_FILES["file"]["name"]);
        $file_extension = end($file_array);
        if (in_array($file_extension, $allowed_extension)) {
            if (move_uploaded_file($_FILES["file"]["tmp_name"], $targetFile)) {
                $response["error"] = false;
                $response["message"] = "success";
            }
            else {
                $response["error"] = true;
                $response["message"] = "There was an error uploading your file.";
            }
        }
        else {
            $response["error"] = true;
            $response["message"] = "Only .xls or .xlsx file allowed.";
        }
    }
}
else {
    $response["error"] = true;
    $response["message"] = "Please upload file.";
}

header("Content-Type: application/json");
echo json_encode($response);
?>