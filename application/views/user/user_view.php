<!DOCTYPE html>
<html lang="en">
    
    <head>
        <meta charset="utf-8">
        <title><?php echo $name;?></title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="">
        <meta name="author" content="">
        <!-- Le styles -->
        <!-- TODO: make sure bootstrap.min.css points to BootTheme generated file
        -->
        <link href="../assets/css/bootstrap.min.css" rel="stylesheet">
        <link href="../assets/css/bootstrap-responsive.min.css" rel="stylesheet">
        <style type="text/css">
            body {
                padding-top: 60px;
                padding-bottom: 40px;
              }
              .sidebar-nav {
                padding: 9px 0;
              }
            
            .carousel .item {
      height: 800px;
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
                    <a class="brand" href="home">Snapto-ur</a>
                    <div class="nav-collapse in collapse" style="height: auto;">
                        <p class="navbar-text pull-right">Logged in as
                            <a href="user" class="navbar-link"><?php echo $name; ?></a>
                        </p>
                        <ul class="nav">
                            <li class="active">
                                <a href="#">Home</a>
                            </li>
                            <li>
                                <a href="../album/createAlbum">Create Album</a>
                            </li>
                            <li>
                                <a href="../user/logout">Logout</a>
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
                                    <div id="collapseOne" class="accordion-body collapse">
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
                                                    $albumName[$i] = $created_album_info[$i]["albumName"];
                                                    $albumId[$i] = $created_album_info[$i]["albumId"];
                                                    echo "<li> <a href="."../album/viewAlbum/myAlbum/".$albumId[$i].">".$albumName[$i]."</li>";
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
                        <div id="myCarousel" class="carousel slide">
                            <ol class="carousel-indicators">
                                <li data-target="#myCarousel" data-slide-to="0" class=""></li>
                                <li data-target="#myCarousel" data-slide-to="1" class=""></li>
                                <li data-target="#myCarousel" data-slide-to="2" class=""></li>
                                <li data-target="#myCarousel" data-slide-to="3" class=""></li>
                                <li data-target="#myCarousel" data-slide-to="4" class="active"></li>
                            </ol>
                            <!-- Carousel items -->
                            <div class="carousel-inner">
                                <div class="item">
                                    <img src=<?php echo $imageURL.$random_images[0]['imageId'].".JPG";?> >
                                    <div class="carousel-caption">
                                         <h4></h4>
                                    </div>
                                </div>
                                <div class="item">
                                    <img src=<?php echo $imageURL.$random_images[1]['imageId'].".JPG";?> >
                                    <div class="carousel-caption">
                                         <h4></h4>
                                    </div>
                                </div>
                                <div class="item">
                                    <img src=<?php echo $imageURL.$random_images[2]['imageId'].".JPG";?> >
                                    <div class="carousel-caption">
                                         <h4></h4>
                                    </div>
                                </div>
                                <div class="item">
                                    <img src=<?php echo $imageURL.$random_images[3]['imageId'].".JPG";?> >
                                    <div class="carousel-caption">
                                         <h4></h4>
                                    </div>
                                </div>
                                <div class="item active">
                                    <img src=<?php echo $imageURL.$random_images[4]['imageId'].".JPG";?> >
                                    <div class="carousel-caption">
                                         <h4></h4>
                                        <p></p>
                                    </div>
                                </div>
                                <!-- Carousel nav -->
                                <a class="left carousel-control" href="#myCarousel" data-slide="prev">‹</a>
                                <a class="right carousel-control" href="#myCarousel" data-slide="next">›</a>
                            </div>
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
        <!--/.fluid-container-->
        <!-- Le javascript==================================================-
        ->
    <!-- Placed at the end of the document so the pages load faster -->
        <script src="//ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>
        <script src="../assets/js/bootstrap.min.js"></script>
        <script>
          !function ($) {
            $(function(){
              // carousel demo
              $('#myCarousel').carousel()
            })
          }(window.jQuery)
        </script>
</body>

</html>