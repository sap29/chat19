<?php
/**
 * Created by PhpStorm.
 * User: Ofer
 * Date: 30/03/2017
 * Time: 19:23
 */

$servername = "localhost";
$username = "sapir291_user";
$password = 'k{rI0=oB5.xO';
$dbname = "sapir291_db";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

mysqli_set_charset($conn,"utf8");

$logged_in = FALSE;
if(isset($_COOKIE["user_name"]) && isset($_COOKIE["user_id"])) {
    $cookie_user_name = $_COOKIE["user_name"];
    $cookie_user_id = $_COOKIE["user_id"];

    $logged_in = TRUE;
}


function copy_chat_calendar($source, $dest)
{
    if (is_link($source)) {
        return symlink(readlink($source), $dest);
    }
   
    if (is_file($source)) {
        return copy($source, $dest);
    }

    if (!is_dir($dest)) {
        mkdir($dest);
    }

    $dir = dir($source);
    while (false !== $entry = $dir->read()) {
        if ($entry == '.' || $entry == '..') {
            continue;
        }
        copy_chat_calendar("$source/$entry", "$dest/$entry");
    }

    $dir->close();
    return true;
}
?>