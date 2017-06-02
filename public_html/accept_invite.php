<?php
include('header.php');

if(isset($_GET['chat_id']) && isset($_GET['user_id'])) {
	$chat_id = $_GET['chat_id'];
	$user_id = $_GET['user_id'];
}

if(!$logged_in) {
	echo '<meta http-equiv="refresh" content="0;url=index.php">';
}

$sql1 = "SELECT * FROM chats WHERE chat_id = $chat_id";
$result1=mysqli_query($conn, $sql1);

if(mysqli_num_rows($result1) > 0){
	while ($row = $result1->fetch_assoc()) {
		$allowed_users = $row['allowed_users'];
		$allowed_users .= ",".$user_id;

		$sql = "UPDATE chats SET allowed_users = '$allowed_users' WHERE chat_id = '$chat_id'";
		if(mysqli_query($conn, $sql)) {
			echo "<h2>אתה בפנים! <a style='color:#000000;' href='chat.php?chat_id=$chat_id'>לחץ כאן</a> ותתחיל לצ'וטט!</h2><br />";
		}
	}
}

?>

</html>

