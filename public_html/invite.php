<?php
include('header.php');

if(isset($_GET['chat_id'])) {
	$chat_id = $_GET['chat_id'];
}

if(!$logged_in) {
	echo '<meta http-equiv="refresh" content="0;url=index.php">';
}
?>


<?php

if(isset($_GET['chat_id'])) {
	$chat_id = $_GET['chat_id'];
	$sql1 = "SELECT * FROM chats WHERE chat_id = $chat_id";
}
else {
	$sql1 = "SELECT * FROM chats WHERE is_private = 1";
}
$result1=mysqli_query($conn, $sql1);

if(mysqli_num_rows($result1) > 0){
	while ($row = $result1->fetch_assoc()) {
		$chat_id = $row['chat_id'];
		$allowed_users = explode(",",$row['allowed_users']);
		echo '<h2>'.$row['chat_name'].'</h2><br />';
	
		echo '
		<table style="background:#FFFFFF;">
			<thead>
				<tr>
					<td>
						שם המשתמש
					</td>
					<td>
						שם מלא
					</td>
					<td>
						הזמן משתמש
					</td>
				</tr>
			</thead>
			<tbody>
		';
		$sql2 = "SELECT * FROM users";
		$result2=mysqli_query($conn, $sql2);
		if(mysqli_num_rows($result2) > 0){
			while ($row2 = $result2->fetch_assoc()) {
				if($row2['user_id'] == $cookie_user_id) continue;
			echo '
				<tr>
					<td>
						'.$row2['User_Name'].'
					</td>
					<td>
						'.$row2['Full_Name'].'
					</td>
					<td>
						';
						if(in_array($row2['user_id'],$allowed_users)) echo '<div class="gray_btn">מוזמן</div>';
						else echo '<a target="_blank" href="send_invite.php?chat_id='.$chat_id.'&chat_name='.$row['chat_name'].'&user_id='.$row2['user_id'].'" class="green_btn">שלח הזמנה</a>';
					echo '
					</td>
				</td>
			';
			}
		}
		echo '
			</tbody>
			</table>';
	}	
}
?>
    </body>
</html>

