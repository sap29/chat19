<?php
    require_once ('db_and_functions.php');
?>
<!DOCTYPE HTML>
<html>
<head>
    <?php
        include('head_includes.php');
    ?>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title>Team</title>

</head>

<body>
<header>
	<div class="wrapper">
		<h1>Team<span class="color">.</span></h1>
		<nav>
			<ul>
				<?php
				if($logged_in) :
				?>
				<li>שלום, <?php echo $cookie_user_name; ?>, <a href="logout.php">התנתק</a></li>
				<?php
				else :
				?>
				<li><a href="htmlLogin.html">התחבר</a></li>
				<?php endif; ?>
				<li><a href="index.php">דף הבית</a></li>
				<li><a href="new_private_chat.php">פתח צ'אט פרטי</a></li>
			</ul>
		</nav>
	</div>
</header>