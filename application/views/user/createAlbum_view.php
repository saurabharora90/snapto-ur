<?php

?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <title>create Album</title>
    </head>
    <body>
        <h1>Welcome, <?php echo $name?></h1>
        <?php echo $error;?>
        <?php echo form_open_multipart('upload/uploadImages');?>

        <input type="file" name="userfile" size="20" />
        <br /><br />
        <input type="submit" value="upload" />
        </form>

    </body>
</html>
