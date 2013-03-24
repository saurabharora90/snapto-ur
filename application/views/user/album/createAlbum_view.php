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
form { display: block; margin: 20px auto; background: #eee; border-radius: 10px; padding: 15px }

.progress { position:relative; width:400px; border: 1px solid #ddd; padding: 1px; border-radius: 3px; }
.bar { background-color: #B4F5B4; width:0%; height:20px; border-radius: 3px; }
.percent { position:absolute; display:inline-block; top:3px; left:48%; }
</style>

    </head>
        <body>
            <?php
                echo form_open_multipart('../album/createAlbum/uploadImages');
            ?>
            <input type="text" name="albumName" placeholder="Album Name"/></br>
            <input type="file" name="userfiles[]" multiple id="fileChoser"/>
            </br>
            <input type="submit" value="Upload images"/>
            </form>

            <div class="progress">
                <div class="bar"></div >
                <div class="percent">0%</div >
            </div>
    
    <div id="status"></div>
    
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7/jquery.js"></script>
<script src="http://malsup.github.com/jquery.form.js"></script>
<script>
    (function () {

        var bar = $('.bar');
        var percent = $('.percent');
        var status = $('#status');

        $('form').ajaxForm(
            {
                beforeSend: function () {
                    status.empty();
                    var percentVal = '0%';
                    bar.width(percentVal)
                    percent.html(percentVal);
                },
                uploadProgress: function (event, position, total, percentComplete) {
                    var percentVal = percentComplete + '%';
                    bar.width(percentVal)
                    percent.html(percentVal);
                    status.html($('#fileChoser').val());
                },
                complete: function (xhr) {
                    status.html(xhr.responseText);
                }
            });

    })();
</script>

        </body>		 
</html>