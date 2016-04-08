<?php
$newPath = null;


// if (isset($_POST['upload_form_submitted'])) echo "Hallelujah!";

if (isset($_POST['upload_form_submitted'])) {


    // code to validate uploaded form here

    // error scenario 1
    // no file uploaded
    if (!isset($_FILES['img_upload']) || empty($_FILES['img_upload']['name'])){
        $error = "Error: You didn't upload a file!";
    } else if (!isset($_POST['img_name']) || empty($_FILES['img_upload'])) {
        $error = "Error: YOu didn't specify a file name";
    } else {

        // here we go
        $allowedMIMES = array('image/jpg', 'image/jpeg', 'image/gif', 'image/png');
        foreach($allowedMIMES as $mime) {
            if ($mime == $_FILES['img_upload']['type']) {
                $mimeSplitter = explode('/', $mime);
                $fileExt = $mimeSplitter[1];
                $newPath = 'img/' . $_POST['img_name'] . '.' .$fileExt;
                break;
            }
        }
    }

    if (file_exists($newPath)) {
        $error = "Error: A file with that name already exists.";
    } else if (!isset($newPath)) {
        $error = "Error: Invalid file format. Please upload a picture file.";
    } else if (!copy($_FILES['img_upload']['tmp_name'], $newPath)) {
        $error = "Error: Could not save file to server.";
    } else {
        $_SESSION['newPath'] = $newPath;
        $_SESSION['fileExt'] = $fileExt;
    }
}


if (isset($_GET['crop_attempt'])) {
    // cropping code here
    switch($_SESSION['fileExt']){
        case "jpg" :
        case "jpeg" :
            $src_img = imagecreatefromjpeg($_SESSION['newPath']);
            $dest_img = imagecreatetruecolor($_GET['crop_w'], $_GET['crop_h']);
            break;
        case "gif":
            $src_img = imagecreatefromgif($_SESSION['newPath']);
            $dest_img = imagecreate($_GET['crop_w'], $_GET['crop_h']);
            break;
        case "png":
            $src_img = imagecreatefrompng($_SESSION["newPath"]);
            $dest_img = imagecreate($_GET['crop_w'], $_GET['crop_h']);
            break;
    }

    imagecopy( $dest_img, $src_img, 0, 0, $_GET['crop_l'], $_GET['crop_t'], $_GET['crop_w'], $_GET['crop_h']);

    switch($_SESSION['fileExt']){
        case "jpg":
        case "jpeg":
            imagejpeg($dest_img, $_SESSION['newPath']);
            break;
        case "gif":
            imagegif($dest_img, $_SESSION['newPath']);
            break;
        case "png";
            imagepng($dest_img, $_SESSION['newPath']);
            break;
    };

    imagedestroy($dest_img);
    imagedestroy($src_img);

    header("Location: index.php");

}
 ?>
