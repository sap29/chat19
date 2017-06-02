<?php
/**
 * Created by PhpStorm.
 * User: Ofer
 * Date: 09/04/2017
 * Time: 18:25
 */

//print_r($_FILES);
$target_dir = "uploads/";
$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
	echo "Ok!";
} else {
	echo "Error!";
}
?>

