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
    <body style="background:none;">

	<?php
	$sql1 = "SELECT * FROM chat_messages WHERE chat_id = $chat_id ORDER BY `message_id`";
	$result1=mysqli_query($conn, $sql1);
	if(mysqli_num_rows($result1) > 0){
		while ($row = $result1->fetch_assoc()) {
			echo '
				<span class="message_details">: '.$row["user_name"].' ('.date('d/m/Y H:i:s', strtotime($row["messgae_time"])).')</span>
				<p class="message_text">'.$row["message"].'</p>
				<br />
			';
		}
	}
	?>

    </body>
</html>
