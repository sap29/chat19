<?php
	include('header.php');
?>

<?php
if(!$logged_in) :
?>
<div id="hero-image">
    <div class="wrapper">
        <h2><!--<strong>Team<br/>
                Learn together</strong>--></h2>

        <a href="htmlLogin.html" class="button-1">התחברות</a>
    </div>
</div>
<?php else: ?>
<div id="features">
    <div class="wrapper">
        <ul>
            <li class="feature-1">
                <h4><a href="private_chats.php">חדרי צ'אט פרטיים</a></h4>
            </li>
            <li class="feature-2">
                <h4><a href="public_chats.php">חדרי לימוד</a></h4>
            </li>
            <div class="clear"></div>
        </ul>
    </div>
</div>
<?php endif; ?>

</body>
</html>