<?php
include('header.php');

if(isset($_GET['chat_id']) && isset($_GET['chat_name']) && isset($_GET['user_id'])) {
	$chat_id = $_GET['chat_id'];
	$chat_name = $_GET['chat_name'];
	$user_id = $_GET['user_id'];
}

if(!$logged_in) {
	echo '<meta http-equiv="refresh" content="0;url=index.php">';
}

$sql1 = "SELECT * FROM users WHERE user_id = $user_id";
$result1=mysqli_query($conn, $sql1);

if(mysqli_num_rows($result1) > 0){
	while ($row = $result1->fetch_assoc()) {
		$user_name = $row['User_Name'];
		$email = $row['e-Mail'];
		
		$msg = "
		<div style='text-align:right; direction:rtl;'>
			שלום $user_name!,<br />
			נשלחה אלייך הזמנה להצטרך לצ'אט $chat_name,<br />
			על מנת לקבל את ההזמנה, לחץ על הקישור הבא:<br />
			<a href='http://cpanel16.tempdomain.co.il/~sapir291192/accept_invite.php?user_id=$user_id&chat_id=$chat_id'>לחץ כאן</a>
		</div>
		";
		
		$headers = "From: project \r\n";
		$headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
		
		if(mail($email,"נשלחה אלייך הזמנה להצטרף לצ'אט $chat_name",$msg,$headers)) {
			echo '<h2>ההזמנה נשלחה בהצלחה!</h2><br />';
		}
	}
}

?>

</html>

