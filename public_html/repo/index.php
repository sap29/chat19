<?php
		require_once ('../db_and_functions.php');

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
				if($is_private) {
					$not_allowed = true;
					$allowed_user_array = explode(",",$allowed_users);
					if(in_array($cookie_user_id, $allowed_user_array)) {
						$not_allowed = false;
					}
				}
				else {
					$not_allowed = false;
				}
			}
		}
							
		if(!$logged_in || $not_allowed) {
			echo '<meta http-equiv="refresh" content="0;url=index.php">';
		}
		?>

<!doctype html>
<html>
<head>
    <meta charset="utf-8">
	
  
  	<script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>

    <script src="jquery.min.js"></script>
    <script src="repo.min.js"></script>

</head>
<body>
	
	<h1 style="font-family: Arial; text-align:center;">הפרויקט המשותף של חדר הצ'אט <?php echo $chat_name; ?></h1>
	<script type="text/javascript"> 
    $('body').repo({ user: 'sap29', name: 'chat<?php echo $chat_id; ?>' });
    </script>
	
	<div style="text-align:right; direction:rtl;">
	על מנת להוריד את הפרויקט הרץ את הפקודה:
	git clone https://github.com/sap29/chat<?php echo $chat_id; ?>.git
	או הורד אותו על ידי לחיצה <a target="_blank" href="https://github.com/sap29/chat<?php echo $chat_id; ?>/archive/master.zip">כאן</a>
    </div>
	
</body>
</html>