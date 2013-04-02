<!DOCTYPE html>
<html id lang="en">
    <head>
        <title>Create Album &middot; <?php echo $name?></title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="">
        <meta name="author" content="">

        <!-- Le styles -->
        <link href="/assets/css/bootstrap.min.css" rel="stylesheet">
        <link href="/assets/css/bootstrap-responsive.min.css" rel="stylesheet">
        <link rel="stylesheet" href="/assets/fancybox/jquery.fancybox.css" type="text/css" media="screen" />
        <link rel="stylesheet" href="/assets/fancybox/helpers/jquery.fancybox-buttons.css" type="text/css" media="screen" />
        <link rel="stylesheet" href="/assets/fancybox/helpers/jquery.fancybox-thumbs.css" type="text/css" media="screen" />
        <link rel="stylesheet" href="http://code.jquery.com/ui/1.10.2/themes/smoothness/jquery-ui.css" />
  

    </head>
    <body>
        <h3 id="Name_album"><?php echo $albumName?></h3>
        <h6 id="Id_album"><?php echo $albumId?></h6>
        <p id="ImagesNo"> Showing <?php echo count($displayImages)." Images out of ". $totalImagesInAlbum." in the album.";?></p>
        <div class="row">
            <div class="span4">
                <div id="slider"></div>
            </div>
            <div class="span8">
            </div>
        </div>
        </br>  </br>
        <ul id="listOfImages" class="thumbnails">
            <?php
                foreach($displayImages as $image)
                {
                    echo "<li class=\"span2\">";
                    echo "<a class=\"fancybox\" rel=\"gallery\" href=".$imageURL.$image["imageId"].".JPG title=".$image["imageName"].">";
                    echo "<img src=".$thumbUrl.$image["imageId"].".JPG ";
                    echo "/> </a>";
                    echo "</li>";
                }
            ?>
        </ul>

        <script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
        <script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.10.2/jquery-ui.min.js"></script>
        <script type="text/javascript" src="/assets/fancybox/jquery.fancybox.pack.js"></script>
        <script type="text/javascript" src="/assets/fancybox/helpers/jquery.fancybox-buttons.js"></script>
        <script type="text/javascript">
            $(document).ready(function () {
                $("#Id_album").hide();
                $(".fancybox").fancybox({
                    prevEffect: 'none',
                    nextEffect: 'none',
                    helpers: {
                        title: {
                            type: 'inside'
                        },
                        buttons: {}
                    }
                });
            });
        </script>

        <script>
            $(function () {
                $("#slider").slider({ step: 5, value: "30", change: function (event, ui) {
                    var albumId = $("#Id_album").text();
                    $.post("/album/viewalbum/sliderupdate/" + albumId + "/" + ui.value, function (data) {
                        var result = JSON.parse(data);
                        $("#ImagesNo").html("Showing " + result.displayImages.length + " Images out of " + result.totalImagesInAlbum + " in the album");
                        var listofImages = "";
                        for (var i = 0; i < result.displayImages.length; i++) {
                            listofImages = listofImages + "<li class=\"span2\">";
                            listofImages = listofImages + "<a class=\"fancybox\" rel=\"gallery\" href=" + result.imageURL + result.displayImages[i].imageId + ".JPG title=" + result.displayImages[i].imageName + ">";
                            listofImages = listofImages + "<img src="+ result.thumbUrl + result.displayImages[i].imageId + ".JPG ";
                            listofImages = listofImages + "/> </a></li>";
                        }
                        //listofImages = listofImages + "</ul>";
                        $("#listOfImages").html(listofImages);
                    });
                }
                });

            });
        </script>
    </body>
</html>
