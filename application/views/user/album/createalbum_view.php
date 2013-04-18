<!DOCTYPE html>
<html lang="en">
	<head>
        <title>Create Album &middot; <?php echo $name?></title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="">
        <meta name="author" content="">

        <!-- Le styles -->
        <link href="../assets/css/bootstrap.min.css" rel="stylesheet">
        <link href="../assets/css/bootstrap-responsive.min.css" rel="stylesheet">
        <link rel="stylesheet" type="text/css" href="../assets/uploadify/uploadify.css" />

        <style>
            body { padding: 30px }

            .progress { position:relative; width:400px; border: 1px solid #ddd; padding: 1px; border-radius: 3px; }
            .bar { background-color: #B4F5B4; width:0%; height:20px; border-radius: 3px; }
            .percent { position:absolute; display:inline-block; top:3px; left:48%; }
        </style>

    </head>
        <body>
            <h1>Create a New Album</h1>
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
            <script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
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