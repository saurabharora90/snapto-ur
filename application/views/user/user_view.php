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
                $createdAlbumsNo = count($created_album_info);  //The album id will go along with the album name as a hidden value.
                if($createdAlbumsNo>1)
                    echo "You have created ".$createdAlbumsNo." albums"; //more than 1 album, hence 'albums'
                else //1 or 0 'album'
                    echo "You have created ".$createdAlbumsNo." album";
            ?>
        </p>
        <a href="../user/logout">Logout</a> </br>
        <a href="../album/createAlbum">Create Album</a>
        <p></p>
    </body>
</html>

