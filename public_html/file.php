 <html lang="en">
   <head>
       <meta charset="utf-8"/>
       <title>upload a file</title>
   </head>
   <body>

<form action="upload.php" method="post" enctype="multipart/form-data">
    Select image to upload:
    <input type="file" name="fileToUpload" id="fileToUpload">
    <input type="submit" value="Upload Image" name="submit">
</form>


   </body>
</html>
<?php
/**
 * Created by PhpStorm.
 * User: Ofer
 * Date: 07/04/2017
 * Time: 12:03
 */
