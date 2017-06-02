<?php
include('header.php');

if(isset($_GET['chat_id'])) {
	$chat_id = $_GET['chat_id'];
}

$sql = "SELECT * FROM chats WHERE chat_id = $chat_id";
$result=mysqli_query($conn, $sql);
if(mysqli_num_rows($result) > 0){
	while ($row = $result->fetch_assoc()) {
		$admin_user_id = $row['admin_user_id'];
		$chat_name = $row['chat_name'];
		$is_private = $row['is_private'];
		$allowed_users = $row['allowed_users'];
		$allowed_users_2 = $row['allowed_users_2'];
		if($is_private) {
			$not_allowed = true;
			$allowed_user_array = explode(",",$allowed_users);
			if(in_array($cookie_user_id, $allowed_user_array)) {
				$not_allowed = false;
			}
		}
		else {
			$not_allowed = false;
			$not_allowed_2_check = false;
			if($allowed_users_2 !== NULL) {
				$not_allowed_2_check = true;
				$allowed_user_2_array = explode(",",$allowed_users_2);
				if(in_array($cookie_user_id, $allowed_user_2_array)) {
					$not_allowed_2_check = false;
				}
			}
		}
	}
}

if(!$logged_in || $not_allowed || $not_allowed_2_check) {
	echo '<meta http-equiv="refresh" content="0;url=index.php">';
}

$target_dir = "uploads/$chat_id/".date('Y')."/";
$last_year_target_dir = "uploads/$chat_id/".date('Y',strtotime('-1 year'))."/";
if (!file_exists($target_dir)) {
    mkdir($target_dir, 0777, true);
}
if(count($_FILES) > 0) {
	$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
	if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
		echo '
		<script>
			alert("הקבצים הועלו בהצלחה!");
		</script>
		';
	} else {
		echo '
		<script>
			alert("מצטערים, התרחשה שגיאה");
		</script>
		';
	}
}

$current_chat_calendar_path = "chats_calendars/$chat_id";
if (!file_exists($current_chat_calendar_path)) {
    copy_chat_calendar('chats_calendars/tocopy', $current_chat_calendar_path);
}
?>

<script type="text/javascript">
	$(document).ready(function()
	{
		setInterval(function()
		{ 
		$.ajax({
			type : 'POST',
			url  : 'get_chat_messages.php?chat_id=<?php echo $chat_id; ?>',
			data : $(this).serialize(),
			success : function(data)
			{
				$(".messages").html(data);
			},
		});
		}, 500);
		
		$('#send_message').on('submit', function (e) {
		  e.preventDefault();
		  $.ajax({
			type: 'POST',
			url: 'add_message.php?chat_id=<?php echo $chat_id; ?>',
			data: $('#send_message').serialize(),
			success: function () {
				$('.myMessageField').val("");
				$('.myMessageField').trigger('keyup').focus();
			}
		  });
		});
	});

</script>

<?php
	$sql1 = "SELECT * FROM chat_messages WHERE chat_id = $chat_id ORDER BY `message_id`";
	$result1=mysqli_query($conn, $sql1);
?>

<form id="google_search" action="https://www.google.co.il/search" method="get" target="_blank">
	<input type="text" name="q" placeholder="חפש מידע בגוגל..."/>
	<input type="submit" value="חפש!">
</form>
<div class="container" <?php if($is_private || $allowed_users_2 !== NULL) {echo ' style=" width:75%; margin:20px auto; float:left;"';}?>>
	<h1 class="chat_title"><?php echo $chat_name; ?></h1>
	<br />
	<div class="chats_buttons">
	<?php
	if($admin_user_id == $cookie_user_id) : ?>
		<a href="invite.php?chat_id=<?php echo $chat_id; ?>">הזמן לצ'אט זה</a>
	<?php endif; ?>
	&nbsp;&nbsp;
	<a href="#" onclick="open_upload_files_lightbox(); return false;">צרף קבצים</a>
	&nbsp;&nbsp;
	<a href="#" onclick="open_chat_files_lightbox(); return false;">צפה בקבצי החדר</a>
	&nbsp;&nbsp;
	<a target="_blank" href="chats_calendars/<?php echo $chat_id; ?>/">צפה ביומן החדר</a>
	&nbsp;&nbsp;
	<a target="_blank" href="repo/index.php?chat_id=<?php echo $chat_id; ?>">צפה בפרויקט המשותף של החדר</a>
	</div>
    <div id="chatResult">
        <div class="messages">
		    <?php
            if(mysqli_num_rows($result1) > 0){
                while ($row = $result1->fetch_assoc()) {
                    echo '
                        <span class="message_details">: '.$row["user_name"].' ('.$row["messgae_time"].')</span>
                        <p class="message_text">'.$row["message"].'</p>
                        <br /><br />
                    ';
                }
            }
            ?>
        </div>
    </div>
    <div id="chatForm">
        <form method="POST" action="" id="send_message">
            <input type="hidden" name="chat_id" value="<?php echo $chat_id;?>" />
            <textarea name="myMessage" class="myMessageField"></textarea>
            <br />
            <input name="submit_message" type="submit" value="שלח הודעה"/>
        </form>
    </div>
</div>
<?php
	if($is_private || $allowed_users_2 !== NULL) : ?>
<div class="chat_right_div">
	<h5>חברים בצ'אט זה</h5>
	<?php
	$sql = "SELECT * FROM `chats` WHERE `chat_id` = '$chat_id'";
	$result=mysqli_query($conn, $sql);
	if(mysqli_num_rows($result) > 0){
		$my_privat_chats_counter = 0;
		while ($row = $result->fetch_assoc()) {
			if($is_private) {
				$allowed_users = explode(",", $row['allowed_users']);
			}
			elseif($allowed_users_2 !== NULL) {
				$allowed_users = explode(",", $row['allowed_users_2']);
			}
			foreach($allowed_users as $user) {
			$user_sql = "SELECT `User_Name` FROM `users` WHERE `user_id` = '$user'";
			$user_result=mysqli_query($conn, $user_sql);
				while ($user_row = $user_result->fetch_assoc()) {
					echo $user_row['User_Name']."<br />";
				}
			}
		}
		echo "<br /><br />";
	}
	?>

	<h5>הצ'אטים שלך</h5>
	<?php
	$sql = "SELECT * FROM chats";
	$result=mysqli_query($conn, $sql);
	if(mysqli_num_rows($result) > 0){
		$my_privat_chats_counter = 0;
		echo '
		<div class="chats_list">
		';
		while ($row = $result->fetch_assoc()) {
			$chat_id = $row['chat_id'];
			$is_private = $row['is_private'];
			if($is_private) {
				$chat_name = $row['chat_name']." (פרטי)";
			}
			else {
				$chat_name = $row['chat_name'];
			}
			$allowed_users_2 = $row['allowed_users_2'];
			if($is_private) {
				$allowed_users = $row['allowed_users'];
			}
			elseif($allowed_users_2 !== NULL) {
				$allowed_users = $row['allowed_users_2'];
			}
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
	?>


</div>
<div class="clear"></div>
<?php
endif;
?>
    <div class="overlay"></div>
	
    <div class="upload_files_lightbox lightbox">
		<br /><br />
		<form action="" method="post" enctype="multipart/form-data">
			<input type="file" name="fileToUpload" id="fileToUpload">
			<input type="submit" value="העלה קובץ" name="submit">
		</form>
        <a class="close_lightbox" href="#" onclick="close_lightbox(); return false;">סגור</a>
    </div>    
	
	<div class="chat_files_lightbox lightbox">
		<br /><br />
		קבצים שהועלו בחדר זה:
		<br /><br />
		<div class="chat_files">
		<?php
		echo "בשנת ".date('Y')."<br /><br />";
		$files = scandir($target_dir);
		if(count($files) <= 2) {
			echo 'לא קיימים קבצים בקבוצה זו.';
		}
		else {
			foreach($files as $file) {
				if($file != "." && $file != "..") {
					echo '<a target="_blank" href="'.$target_dir.$file.'">'.$file.' - לחץ לפתיחה</a>';
				}
			}
		}
		echo "<br /><br /><br />";
		echo "בשנת ".date('Y',strtotime('-1 year'))."<br /><br />";
		$files = scandir($last_year_target_dir);
		if(count($files) <= 2) {
			echo 'לא קיימים קבצים';
		}
		else {
			foreach($files as $file) {
				if($file != "." && $file != "..") {
					echo '<a target="_blank" href="'.$last_year_target_dir.$file.'">'.$file.' - לחץ לפתיחה</a>';
				}
			}
		}
		?>
		</div>
        <a class="close_lightbox" href="#" onclick="close_lightbox(); return false;">סגור</a>
    </div>

    </body>
</html>

