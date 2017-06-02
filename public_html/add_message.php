<html>
    <head>
        <?php
		/**
		 * Created by PhpStorm.
		 * User: Ofer
		 * Date: 30/03/2017
		 * Time: 18:51
		 */

		if(isset($_GET['chat_id'])) {
			$chat_id = $_GET['chat_id'];
		}

		require_once ('db_and_functions.php');

		if(!$logged_in) {
			echo '<meta http-equiv="refresh" content="0;url=index.php">';
		}
		
        include('head_includes.php');
        ?>
    </head>
    <body>

<?php

if(isset($_POST['myMessage']) && $_POST['myMessage'] != '') {
    $message = $_POST['myMessage'];
    $sql = "INSERT INTO chat_messages (chat_id, user_id, user_name, message) VALUES ('$chat_id', '$cookie_user_id','$cookie_user_name','$message')";
    mysqli_query($conn, $sql);
}
?>
	<body>
</html>
