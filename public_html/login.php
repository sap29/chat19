<?php
require_once ('db_and_functions.php');
// Get values from form
/*print_r($_GET);*/
$id= $_GET ['lg_id'];
$password=$_GET['lg_password'];

// Search for data from mysql
 $sql1 = "SELECT * FROM users WHERE `user_id` = $id AND `Password` = '$password'";
$result1=mysqli_query($conn, $sql1);

if(mysqli_num_rows($result1) > 0){
    $row = $result1->fetch_assoc();
    $user_name = $row['User_Name'];
    /*echo "Successful";
    echo "<BR>";
    echo "<a href='login.php'>Back to main page</a>";*/
    setcookie("user_name", $user_name, time() + (86400 * 30), "/");
    setcookie("user_id", $id, time() + (86400 * 30), "/");
    setcookie("user_key", md5($password), time() + (86400 * 30), "/");
    echo '<meta http-equiv="refresh"
   content="0; url=index.php">';

}
else {
    echo '<meta http-equiv="refresh"
   content="0; url=htmlLogin.html">';


}
?>

<?php
// close connection
mysqli_close($conn);
?>