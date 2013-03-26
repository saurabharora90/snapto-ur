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

        <style>
            body { padding: 30px }

            .progress { position:relative; width:400px; border: 1px solid #ddd; padding: 1px; border-radius: 3px; }
            .bar { background-color: #B4F5B4; width:0%; height:20px; border-radius: 3px; }
            .percent { position:absolute; display:inline-block; top:3px; left:48%; }
        </style>

    </head>
        <body>
            <h1>Create a New Album</h1>
            <form action="../album/createAlbum/uploadImages" method="post" enctype="multipart/form-data">
                <input type="text" name="albumName" id="albumName" placeholder="Album Name"/>
                <label for="privacy">Album Privacy:</label>
                <select name="privacy">
                    <option>Private</option>
                    <option>Public</option>
                </select></br>
                <input type="file" name="file_up[]" id="file_up" multiple accept="image/png, image/jpg, image/jpeg">
                <input type="submit" value="Upload images" class="btn">
            </form>

            <div class="progress progress-striped">
                <div class="bar"></div >
                <div class="percent">0%</div >
            </div>
    
    <div id="status"></div>
    
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
<script src="http://malsup.github.com/jquery.form.js"></script>
<script>
    (/*function () {

        var bar = $('.bar');
        var percent = $('.percent');
        var status = $('#status');

        $('form').ajaxForm(
            { datatype: "json",
                beforeSubmit: function (arr, $form, options) {
                    status.empty();
                    var percentVal = '0%';
                    bar.width(percentVal)
                    percent.html(percentVal);

                    if (!$('#file_up').val()) { status.html("No file selected"); return false; }

                    if (!$('#albumName').val()) { status.html("Enter an album name."); return false; }
                },
                uploadProgress: function (event, position, total, percentComplete) {
                    var percentVal = percentComplete + '%';
                    bar.width(percentVal)
                    percent.html(percentVal);
                    //status.html(position);
                },
                success: function (data, textStatus) {
                    var result = jQuery.parseJSON(data);
                    //status.html(result.name);
                }
            });

    })();
</script>

        </body>		 
</html>