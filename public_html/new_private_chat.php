<?php
include('header.php');

if(isset($_GET['chat_id'])) {
	$chat_id = $_GET['chat_id'];
}

if(!$logged_in) {
	echo '<meta http-equiv="refresh" content="0;url=index.php">';
}
?>

<div class="container">

<?php
	if(isset($_POST['new_chat_submit']) && $_POST['chat_name'] != '') {
		$chat_name = $_POST['chat_name'];
		$sql = "INSERT INTO chats (chat_name, is_private, admin_user_id, allowed_users) VALUES ('$chat_name', 1,'$cookie_user_id',',$cookie_user_id')";
		mysqli_query($conn, $sql);
		echo "
		<br />
		<h1>הצ'אט $chat_name נפתח בהצלחה!</h1>
		<p><a href='invite.php?chat_id=".mysqli_insert_id($conn)."'>לחץ כאן להזמין את חברייך להצטרף לצ'אט זה!</a>
		<br /><br />
		באפשרותך לפתוח חדש צ'אט נוסף:
		<br />
		";
	}
?>

<form method="POST" action="" id="new_private_chat">
	<label for="chat_name">שם הצ'אט:</label>
	<input type="text" name="chat_name" id="chat_name" value="" />
	<input name="new_chat_submit" type="submit" value="פתח צ'אט">
</form>

</div>

    </body>
</html>

