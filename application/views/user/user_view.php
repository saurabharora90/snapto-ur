<?php

?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <title><?php echo $name;?></title>
    </head>
    <body>
        <h1>Home</h1>
        <h2>Welcome <?php echo $name; ?>!</h2>
        <p>
            <?php
                if($album_infos == NULL)
                    echo "You have 0 albums";
                else
                {
                    echo "You have ".$album_infos->size()." albums";
                }
            ?>
        </p>
        <a href="../user/logout">Logout</a> </br>
        <a href="../album/createAlbum">Create Album</a>
        <p></p>
    </body>
</html>

