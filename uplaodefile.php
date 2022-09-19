
<?php
$errors = [];
function uploadfile($target_dir,$type){

    global $errors;
    //    $target_dir = "uploads/";
    $target_file = $target_dir.uniqid().time().basename($_FILES[$type]["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    // Check if image file is a actual image or fake image
    if (isset($_POST["submit"])) {
        $check = getimagesize($_FILES[$type]["tmp_name"]);
        if ($check !== false) {
            array_push($errors,"File is an image - " . $check["mime"] . ".");
            $uploadOk = 1;
        } else {
            array_push($errors, "File is not an image.");
            $uploadOk = 0;
        }
    }

    // Check if file already exists
    if (file_exists($target_file)) {
        
        $uploadOk = 0;
    }

    // Check file size
    if ($_FILES[$type]["size"] > 5000000000) {
        array_push($errors, "Sorry, your file is too large.");
        $uploadOk = 0;
    }

    // Allow certain file formats
    if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
        && $imageFileType != "gif") {
            array_push($errors, "Sorry, only JPG, JPEG, PNG & GIF files are allowed.") ;
        $uploadOk = 0;
        return false;
    }

    // Check if $uploadOk is set to 0 by an error
    if ($uploadOk == 0) {
        array_push($errors, "Sorry, your file was not uploaded.");
    // if everything is ok, try to upload file
    } else {
        if (move_uploaded_file($_FILES[$type]["tmp_name"], $target_file)) {
            array_push($errors, "The file " . htmlspecialchars(basename($_FILES[$type]["name"])) . " has been uploaded.");
        } else {
            array_push($errors,"Sorry, there was an error uploading your file.");
        }
    }
    return $target_file;
}

?>
