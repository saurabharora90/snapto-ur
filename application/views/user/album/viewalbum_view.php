<!DOCTYPE html>
<html lang="en">

    <head>
        <title>View Album &middot; <?php echo $albumName?></title>
        <meta charset="utf-8">
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
        
        <style type="text/css">
            body {
                padding-top: 60px;
                padding-bottom: 40px;
              }
              .sidebar-nav {
                padding: 9px 0;
              }
        </style>
        <!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
        <!--[if lt IE 9]>
            <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
        <![endif]-->
        <!-- Fav and touch icons -->
        <link rel="shortcut icon" href="../assets/ico/favicon.ico">
        <link rel="apple-touch-icon-precomposed" sizes="144x144" href="../assets/ico/apple-touch-icon-144-precomposed.png">
        <link rel="apple-touch-icon-precomposed" sizes="114x114" href="../assets/ico/apple-touch-icon-114-precomposed.png">
        <link rel="apple-touch-icon-precomposed" sizes="72x72" href="../assets/ico/apple-touch-icon-72-precomposed.png">
        <link rel="apple-touch-icon-precomposed" href="../assets/ico/apple-touch-icon-57-precomposed.png">

    </head>

    <body>
        <div class="navbar navbar-fixed-top">
            <div class="navbar-inner">
                <div class="container-fluid">
                    <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse"> <span class="icon-bar"></span>
 <span class="icon-bar"></span>
 <span class="icon-bar"></span>

                    </a>
                    <a class="brand" href="/home">Snapto-ur</a>
                    <div class="nav-collapse in collapse" style="height: auto;">
                        <p class="navbar-text pull-right">Logged in as
                            <a href="user" class="navbar-link"><?php echo $name; ?></a>
                        </p>
                        <ul class="nav">
                            <li>
                                <a href=<?php echo base_url()."user"; ?>>Home</a>
                            </li>
                            <li>
                                <a href=<?php echo base_url()."album/createAlbum";?>>Create Album</a>
                            </li>
                            <li>
                                <a href=<?php echo base_url()."user/logout";?>>Logout</a>
                            </li>
                        </ul>
                    </div>
                    <!--/.nav-collapse -->
                </div>
            </div>
        </div>

        <div class="container-fluid">
            <div class="row-fluid">
                <div class="span3">
                    <div class="well sidebar-nav">
                        <ul class="nav nav-list">
                            <div class="accordion" id="accordion2">
                                <div class="accordion-group">
                                    <div class="accordion-heading">
                                        <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2"
                                        href="#collapseOne">My Albums <?php $createdAlbumsNo = count($created_album_info); echo "(".$createdAlbumsNo.")";?></a>
                                    </div>
                                    <div id="collapseOne" class="accordion-body collapse in">
                                        <div class="accordion-inner" id="my">
                                            <?php
                                                $createdAlbumsNo = count($created_album_info);
                                                $more = FALSE;
                                                if($createdAlbumsNo>4)
                                                {
                                                    $more = TRUE;
                                                    $createdAlbumsNo = 4;
                                                }
                                                echo "<ul>";
                                                for($i = 0; $i<$createdAlbumsNo; $i++)
                                                {
                                                    $Name = $created_album_info[$i]["albumName"];
                                                    $Id = $created_album_info[$i]["albumId"];
                                                    echo "<li> <a href=".base_url()."album/viewAlbum/myAlbum/".$Id.">".$Name."</li>";
                                                }
                                                if($more==TRUE)
                                                    echo "<li> <a href="."".">More</li>";
                                                echo "</ul>";
                                            ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="accordion-group">
                                    <div class="accordion-heading">
                                        <a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion2"
                                        href="#collapseTwo">Shared Albums</a>
                                    </div>
                                    <div id="collapseTwo" class="accordion-body collapse" style="height: 0px;">
                                        <div class="accordion-inner" id="shared">

                                        </div>
                                    </div>
                                </div>
                                <div class="accordion-group">
                                    <div class="accordion-heading">
                                        <a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion2"
                                        href="#collapseThree">Collaborated Albums</a>
                                    </div>
                                    <div id="collapseThree" class="accordion-body collapse" style="height: 0px;">
                                        <div class="accordion-inner" id="collaboarted">

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </ul>
                    </div>
                    <!--/.well -->
                </div>
                <!--/span-->
                <div class="span9">
                    <div class="hero-unit">
                        <h3 id="Name_album"><?php echo $albumName?></h3>
                        <h6 id="Id_album"><?php echo $albumId?></h6>
                        <p id="ImagesNo"> Showing <?php echo count($displayImages)." Images out of ". $totalImagesInAlbum." in the album.";?></p>
                        <div id="slider"></div>
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
                    </div>
                    <div class="row-fluid">
                        <!--/span-->
                        <!--/span-->
                        <!--/span-->
                    </div>
                    <!--/row-->
                    <div class="row-fluid">
                        <!--/span-->
                        <!--/span-->
                        <!--/span-->
                    </div>
                    <!--/row-->
                </div>
                <!--/span-->
            </div>
            <!--/row-->
            <hr>
            <footer>
                <p class="pull-right"><a href="#">Back to top</a></p>
                <p>&copy; 2013 Snapto-ur, Inc. &middot; <a href="#">Privacy</a> &middot; <a href="#">Contact</a> &middot; <a href="#">Terms</a></p>
            </footer>
        </div>

        <script src="//ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>
        <script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.10.2/jquery-ui.min.js"></script>
        <script src="/assets/js/bootstrap.min.js"></script>
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
                $("#slider").slider({ step: 5, value: "30", slide:function(event,ui){$('#slider').attr('title', ui.value);}, change: function (event, ui) {
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
        <script>
            $( document ).tooltip();
        </script>
    </body>
</html>
