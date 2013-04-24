<!DOCTYPE html>
<html lang="en">
    
    <head>
        <meta charset="utf-8">
        <title>Welcome to Snapto-ur</title>
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
            
            /* CUSTOMIZE THE CAROUSEL
    -------------------------------------------------- */

    /* Carousel base class */
    .carousel {
      margin-bottom: 60px;
    }

    .carousel .container {
      position: relative;
      z-index: 9;
    }

    .carousel-control {
      height: 80px;
      margin-top: 0;
      font-size: 120px;
      text-shadow: 0 1px 1px rgba(0,0,0,.4);
      background-color: transparent;
      border: 0;
      z-index: 10;
    }

    .carousel .item {
      height: 500px;
    }
    .carousel img {
      position: absolute;
      top: 0;
      left: 0;
      min-width: 100%;
      height: 500px;
    }

    .carousel-caption {
      background-color: transparent;
      position: static;
      max-width: 550px;
      padding: 0 100px;
      margin-top: 250px;
    }
    .carousel-caption h1,
    .carousel-caption .lead {
      margin: 0;
      line-height: 1.25;
      color: #fff;
      text-shadow: 0 1px 1px rgba(0,0,0,.4);
    }
    .carousel-caption .btn {
      margin-top: 10px;
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
    <link href="main.css" rel="stylesheet">
</head>
    
    <body>
        <div class="navbar navbar-inverse navbar-fixed-top">
            <div class="navbar-inner">
                <div class="container">
                    <a class="btn btn-navbar collapsed" data-toggle="collapse" data-target=".nav-collapse"> <span class="icon-bar"></span>
 <span class="icon-bar"></span>
 <span class="icon-bar"></span>

                    </a>
                    <a class="brand" href="#">Snapto-ur</a>
                    <div style="height: 0px;" class="nav-collapse collapse">
                        <ul class="nav">
                            <li class="active">
                                <a href="#">Home</a>
                            </li>
                            <li>
                                <a href="#about">About</a>
                            </li>
                            <li>
                                <a href="#contact">Contact</a>
                            </li>
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown">Dropdown <b class="caret"></b>

                                </a>
                                <ul class="dropdown-menu">
                                    <li>
                                        <a href="#">Action</a>
                                    </li>
                                    <li>
                                        <a href="#">Another action</a>
                                    </li>
                                    <li>
                                        <a href="#">Something else here</a>
                                    </li>
                                    <li class="divider"></li>
                                    <li class="nav-header">Nav header</li>
                                    <li>
                                        <a href="#">Separated link</a>
                                    </li>
                                    <li>
                                        <a href="#">One more separated link</a>
                                    </li>
                                </ul>
                            </li>
                        </ul>
                        <form class="navbar-form pull-right" method="post" accept-charset="utf-8" action="../login/verify">
                            <input class="span2" placeholder="Email" type="text" id="username" name="username">
                            <input class="span2" placeholder="Password" type="password" id="passsword" name="password">
                            <button type="submit" class="btn btn-info">Sign in</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="container">
            <!--/.nav-collapse -->
             <div id="myCarousel" class="carousel slide">
      <div class="carousel-inner">
        <div class="item active">
          <img src="../assets/img/pic2.jpg" alt="slide1">
          <div class="container">
            <div class="carousel-caption">
              <h1>View photos</h1>
              <p class="lead">Set your own viewing preference</p>
              <a class="btn btn-large btn-primary" href="#">Sign up today</a>
            </div>
          </div>
        </div>
        <div class="item">
          <img src="../assets/img/pic1.jpg" alt="slide2">
          <div class="container">
            <div class="carousel-caption">
              <h1>Share</h1>
              <p class="lead">Let the system select the best photos which you can share to other social netowrking sites</p>
              <a class="btn btn-large btn-primary" href="#">Learn more</a>
            </div>
          </div>
        </div>
        <div class="item">
          <img src="../assets/img/pic3.jpg" alt="slide3">
          <div class="container">
            <div class="carousel-caption">
              <h1>Full control</h1>
              <p class="lead">Have full control over privacy of each individual photos and not just albums</p>
              <a class="btn btn-large btn-primary" href="#">View demo</a>
            </div>
          </div>
        </div>
      </div>
      <a class="left carousel-control" href="#myCarousel" data-slide="prev">&lsaquo;</a>
      <a class="right carousel-control" href="#myCarousel" data-slide="next">&rsaquo;</a>
    </div><!-- /.carousel -->


            <!-- Example row of columns -->
            <div class="row">
                <div class="span4">
                     <h2>Dynamic Summary</h2>

                    <p>Our intelligent algorithm generates a dyanmic summary of your album for easy viewing. The algorithms learns over time to genearate subsets which include your popular and best images.</p>
                    <p>
                        <a class="btn" href="#">View details »</a>
                    </p>
                </div>
                <div class="span4">
                     <h2>Customizable subset</h2>

                    <p>You have the liberty to define the number of photos you want to view and we will generate the perfect subset for you.</p>
                    <p>
                        <a class="btn" href="#">View details »</a>
                    </p>
                </div>
                <div class="span4">
                     <h2>Dive into details</h2>

                    <p>View photos that interest you. Photos are organised by time which allows you to kepp track of events.</p>
                    <p>
                        <a class="btn" href="#">View details »</a>
                    </p>
                </div>
            </div>
            <hr>
            <footer>
                <p class="pull-right"><a href="#">Back to top</a></p>
                <p>&copy; 2013 Snapto-ur, Inc. &middot; <a href="#">Privacy</a> &middot; <a href="#">Contact</a> &middot; <a href="#">Terms</a></p>
            </footer>
        </div>
        <!-- /container -->
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