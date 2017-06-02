<?php
require_once ('db_and_functions.php');
$email= $_GET['fp_email'];
$new_password=rand(111111,999999);

$sql1 = "UPDATE `users` SET `Password` = '$new_password' WHERE `e-Mail` = '$email'";
$result1=mysqli_query($conn, $sql1);
$msg = "
<div style='text-align:right; direction:rtl;'>
	שלום,<br />
	הסיסמא החדשה שלך היא: $new_password
</div>
";

$headers = "From: project \r\n";
$headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";

if(mail($email,"הסיסמא החדשה שלך",$msg,$headers)) {
echo '
<script>
alert("הסיסמא שלך אופסה והיא מופיעה במייל שנשלח אלייך.");
</script>';
echo '<meta http-equiv="refresh"
content="0; url=index.php">';
}
?>

<?php
// close connection
mysqli_close($conn);
?>