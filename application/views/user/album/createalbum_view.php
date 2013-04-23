<!DOCTYPE html>
<html lang="en">
    
    <head>
        <meta charset="utf-8">
        <title>Create Album &middot; <?php echo $name?></title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="">
        <meta name="author" content="">
        <!-- Le styles -->
        <!-- TODO: make sure bootstrap.min.css points to BootTheme generated file
        -->
        <link href="../assets/css/bootstrap.min.css" rel="stylesheet">
        <link href="../assets/css/bootstrap-responsive.min.css" rel="stylesheet">
        <link rel="stylesheet" type="text/css" href="../assets/uploadify/uploadify.css" />
        <style type="text/css">
            body {
                padding-top: 60px;
                padding-bottom: 40px;
              }
              .sidebar-nav {
                padding: 9px 0;
              }
            
            .progress { position:relative; width:400px; border: 1px solid #ddd; padding: 1px; border-radius: 3px; }
            .bar { background-color: #B4F5B4; width:0%; height:20px; border-radius: 3px; }
            .percent { position:absolute; display:inline-block; top:3px; left:48%; }
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
                            <li>
                                <a href=<?php echo base_url()."user"; ?>>Home</a>
                            </li>
                            <li class="active">
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
                    <div class="hero-unit">
                        <label for="albumName">Name of Album:</label>
                        <input type="text" name="albumName" id="albumName" placeholder="Album Name"/>
                        <div id="album_error"></div>
                        <label for="privacy">Album Privacy:</label>
                        <select name="privacy" id="privacy">
                            <option>Private</option>
                            <option>Public</option>
                        </select></br>
                        <input type="file" name="file_up" id="file_up" accept="image/jpg, image/jpeg">
                        <input type="submit" id="upload" value="Create Album" class="btn btn-success">
                        <div>
                            <h4 id="errorHeading">Upload Errors:</h4>
                            <ul id="uploadError"></ul>
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
        <script type="text/javascript" src="../assets/uploadify/jquery.uploadify.min.js"></script>
            <script type="text/javascript">
                $(function () {
                    var base_url = '<?php echo base_url(); ?>';
                    $('#errorHeading').hide();
                    $('#file_up').uploadify({
                        'swf': base_url + 'assets/uploadify/uploadify.swf',
                        'uploader': base_url + 'images/uploadImages/upload',
                        // Put your options here
                        'progressData': 'percentage',
                        'auto': false,
                        'successTimeout': 6000,
                        'debug': 'true',
                        'multi': true,
                        'fileTypeExts': '*.jpg; *.jpeg',
                        'fileTypeDesc': 'Supported Images',
                        'onUploadStart': function () { $('#file_up').uploadify('settings', 'formData', { 'albumName': $('#albumName').val(), 'privacy': $('#privacy').val() }); },
                        'onUploadError': function (file, errorCode, errorMsg, errorString) {
                            $('#errorHeading').show();
                            var error = $('#uploadError').html();
                            error = error + '<li>' + file.name;
                            if (errorMsg == '500')
                                error = error + ': System Error. Please try again later.';
                            if (errorMsg == '501')
                                error = error + ': Duplicate Image names.';
                            if (errorMsg == '502')
                                error = error + ': Image upload failure. Try uploading again';
                            error = error + '</li>';
                            $('#uploadError').html(error);
                        }
                    });
                });
            </script>
            <script type="text/javascript">
                $('#upload').click(function () {
                    var albumError = $("#album_error");
                    if (!$('#albumName').val()) {
                        albumError.html("Enter an album name.");
                        return false;
                    }
                    else {
                        //Post the album name to database
                        albumError.html("");
                        $.post('createAlbum/storeAlbum', { albumName: $('#albumName').val(), privacy: $('#privacy').val() }, function (data) {
                            if (data == "") {
                                $('#file_up').uploadify('upload', '*');
                            }
                            else
                                albumError.html(data);
                        });
                    }
                });
            </script>
</body>

</html>