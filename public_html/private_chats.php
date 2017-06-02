<?php
include('header.php');
					
if(!$logged_in) {
	echo '<meta http-equiv="refresh" content="0;url=index.php">';
}
?>
		
<div class="container">
	
	<?php
	$sql = "SELECT * FROM chats WHERE is_private = 1";
	$result=mysqli_query($conn, $sql);
	if(mysqli_num_rows($result) > 0){
		$my_privat_chats_counter = 0;
		echo '
		<div class="chats_list">
		<br />
		';
		while ($row = $result->fetch_assoc()) {
			$chat_id = $row['chat_id'];
			$chat_name = $row['chat_name'];
			$allowed_users = $row['allowed_users'];
			$allowed_user_array = explode(",",$allowed_users);
			if(in_array($cookie_user_id, $allowed_user_array)) {
				$my_privat_chats_counter++;
				if(count($allowed_user_array) > 4) {
					if (($key = array_search($cookie_user_id, $allowed_user_array)) !== false) {
						unset($allowed_user_array[$key]);
						$allowed_user_array = array_values($allowed_user_array);
					}
					$sql2 = "SELECT * FROM users WHERE user_id = $allowed_user_array[1] OR user_id = $allowed_user_array[2]";
					$result2=mysqli_query($conn, $sql2);
					if(mysqli_num_rows($result2) > 0){
						$allowed_user_string = '';
						while ($row2 = $result2->fetch_assoc()) {
							$allowed_user_string .= $row2['User_Name'].", ";
						}
					}
					echo '<a href="chat.php?chat_id='.$chat_id.'">'.$chat_name.'</a> (אתה, '.$allowed_user_string.' ועוד '.(count($allowed_user_array)-(1+mysqli_num_rows($result2))).' חברים)<br /><br />';
				}
				else {
					echo '<a href="chat.php?chat_id='.$chat_id.'">'.$chat_name.'</a> ('.(count($allowed_user_array)-(2)).' חברים ואתה)<br /><br />';
				}
			}
		}
		echo '</div>';
	}
	if($my_privat_chats_counter == 0) {
		echo "לא קיימים חדרי צ'אט שאתה חבר בהם.";
	}
	?>
    
</div>
    </body>
</html>
