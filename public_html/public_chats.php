<?php
include('header.php');
					
if(!$logged_in) {
	echo '<meta http-equiv="refresh" content="0;url=index.php">';
}
?>
		
<div class="container">
	
	<?php
	$sql = "SELECT * FROM chats WHERE is_private = 0";
	$result=mysqli_query($conn, $sql);
	if(mysqli_num_rows($result) > 0){
		echo '
		<div class="chats_list">
		<br />
		';
		while ($row = $result->fetch_assoc()) {
			$chat_id = $row['chat_id'];
			$chat_name = $row['chat_name'];
			$allowed_users_2 = $row['allowed_users_2'];
			if($allowed_users_2 !== NULL) {
				$allowed_users = $row['allowed_users_2'];
			}
			$allowed_user_array = explode(",",$allowed_users);
			if(in_array($cookie_user_id, $allowed_user_array)) {
				echo '<a href="chat.php?chat_id=' . $chat_id . '">' . $chat_name . '</a><br /><br />';
			}
		}
		echo '</div>';
	}
	?>
    
</div>
    </body>
</html>
