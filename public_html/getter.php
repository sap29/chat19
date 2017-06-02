<?php

require_once ('db_and_functions.php');

// Get values from form
$id= $_GET ['reg_id'];
$user_name=$_GET['reg_username'];
$full_name=$_GET['reg_fullname'];
//$gender=$_GET['reg_gender'];
$password=$_GET['reg_password'];
$email=$_GET['reg_email'];


// Insert data into mysql
$sql = "INSERT INTO users (`user_id`,`User_Name`,`Full_Name`,`Password`,`e-Mail`) VALUES ('$id','$user_name','$full_name','$password','$email')";
$result=mysqli_query($conn, $sql) or die ('Unable to execute query. '. mysqli_error($conn));

// if successfully insert data into database, displays message "Successful". 
if($result){
    //echo "Successful";
    //echo "<BR>";
    //echo "<a href='getter.php'>Back to main page</a>";
	echo '<meta http-equiv="refresh" content="0;url=index.php">';
}

else {
    echo "ERROR";
}
?>

<?php
// close connection 
mysqli_close($conn);
?>



