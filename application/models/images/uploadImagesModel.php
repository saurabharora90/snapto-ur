<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 require_once("/application/libraries/WindowsAzure/WindowsAzure.php");
 require_once("/application/models/images/parallelUploadFunctions.php");
 use WindowsAzure\Common\ServicesBuilder;
 use WindowsAzure\Common\ServiceException;
 use WindowsAzure\Blob\Models\BlockList;

Class uploadImagesModel extends CI_Model
{
    function _construct()
    {
        parent::__construct();
    }

    function uploadImages($data)
    {
         $username = $data['username'];
         $albumName = $data['albumName'];
         $album_id = md5(strtoupper($this->db->escape($data['albumName'])).$this->db->escape($data['username']));

         $imageId = md5($username.$album_id.$_FILES['Filedata']['name']);
         $picture = strtoupper($_FILES['Filedata']['name']);

         //Check if this image already exists in this album
         if(!$this->imageExists($data))
         {
            //show_error("Duplicate Image names.",501);
            $this->output->set_header("HTTP/1.1 501 Not Implemented");
            //echo "Duplicate Image names.";
            return;
         }

        //add image to database.
         if(!$this->addImagesDatabase($data,$picture,$imageId,$album_id))
         {
             //show_error("System Error. Please try again later.",500);
             $this->output->set_header("HTTP/1.1 500 Internal Server Error");
         }


        //Try uploading the image and if uploads fails then remove the image from database.
        $this->saveImageToBlob($imageId,$data);

        //Extract image metadata and store it
        $this->saveMetadata($imageId, $album_id);
    }

    private function addImagesDatabase($data,$picture,$imageId, $album_id)
    {
        $sql = "INSERT INTO images (owner_userId, albumId,privacy,imageName,imageId)
                VALUES (" .$this->db->escape($data['username']).", '" .$album_id."', ".$this->db->escape($data['privacy']).", '".$picture."', '".$imageId."')";

        $query = $this->db->query($sql);
        if($this->db->affected_rows() == 1) //album was created.
            return TRUE;
        else
            return FALSE; //album name already exists.
    }

    private function rollBackImage($imageId)
    {
        $sql = "DELETE FROM images WHERE imageId='".$imageId."'";

        $query = $this->db->query($sql);
    }

    private function saveImageToBlob($imageId,$data)
    {        
        try
        {
            if(ENVIRONMENT == 'development')
                $blobRestProxy = ServicesBuilder::getInstance()->createBlobService('UseDevelopmentStorage=true');
            if(ENVIRONMENT == 'production')
                $blobRestProxy = ServicesBuilder::getInstance()->createBlobService(blobConnectionString);
            //$type = explode(".",$_FILES['Filedata']['name']);
            $type = pathinfo($_FILES['Filedata']['name'], PATHINFO_EXTENSION);
            $blobName = $imageId.'.'.strtoupper($type);

            $blockMaxSize = 2*1024*1024; //2MB
            $fileSize = $_FILES['Filedata']['size'];
            $numOfBlocks = $fileSize/$blockMaxSize;
            $currentFileIndex = 0;
            $blockId=1;
            //$blockId=0;
            $blocklist = new BlockList();
            $content = array();
            while($numOfBlocks>0)
            {
                $content = file_get_contents($_FILES['Filedata']['tmp_name'],NULL,NULL,$currentFileIndex,$blockMaxSize);
                $currentFileIndex+=$blockMaxSize;
                $numOfBlocks-=1; //Read the current block.

                //upload the block
                $blobRestProxy->createBlobBlock(Actual_Image, $blobName, md5($blockId),$content);
                $blocklist->addLatestEntry(md5($blockId));
                $blockId++;
            }

            //upload in parallel doesnt work currently. Check my stackoverflow question
           /*$parallelJobs = 3;
            $index = 1; $jobsLeft = $blockId-1;
            do
            {
                if($jobsLeft == 1) //run only 1 task
                {
                    $jobsLeft = 0;
                    $fp1 = JobStartAsync('localhost','/images/uploadJob1.php?blobName='.$blobName.'&blockId='.$index.'content='$content[$index]);	
                    $blocklist->addLatestEntry(md5($index));
                    $index++;
	                while (true) 
                    {
		                $r1 = JobPollAsync($fp1);
		
		                if ($r1 === false) break;
		
		                echo "<b>r1 = </b>$r1<br>";
		                flush(); @ob_flush();
	                }
	
	                echo "<h3>Jobs Complete</h3></br>";
                }
                
                elseif($jobsLeft == 2) //run 2 parallel task
                {
                    $jobsLeft = 0;
                }
                
                elseif($jobsLeft >=3) //run 3 parallel task and then reduce $jobsleft by 3.
                {
                    $jobsLeft = $jobsLeft-3;
                }

            }//while($i< ceil(($blockId/$parallelJobs)));
            while($jobsLeft!=0);*/

            $blobRestProxy->commitBlobBlocks(Actual_Image, $blobName, $blocklist->getEntries());

            //Creat Image thumbnail and push that to blob storage as well
            $this->saveThumbnail($imageId);
        }
        catch (ServiceException $e)
        {
            $username = $data['username'];
            $albumName = $data['albumName'];
            $album_id = md5($this->db->escape($data['albumName']).$this->db->escape($data['username']));
            $imageId = md5($username.$album_id.$_FILES['Filedata']['name']);
            $this->rollBackImage($imageId);
            var_dump($e->getMessage());
            //show_error($e->getMessage(),502);
            $this->output->set_header("HTTP/1.1 502 Bad Gateway");
            $this->output->set_output(); //force the controller to terminate here coz if the upload failed then we don't need to store metadata for this image.
        }
        catch (Exception $e)
        {
            $username = $data['username'];
            $albumName = $data['albumName'];
            $album_id = md5($this->db->escape($data['albumName']).$this->db->escape($data['username']));
            $imageId = md5($username.$album_id.$_FILES['Filedata']['name']);
            $this->rollBackImage($imageId);
            var_dump($e->getMessage());
            $this->output->set_header("HTTP/1.1 503 Bad Gateway");
            //show_error($e->getMessage(),502);
            
            $this->output->set_output(); //force the controller to terminate here coz if the upload failed then we don't need to store metadata for this image.
        }
    }

    private function saveThumbnail($imageId)
    {
        if(ENVIRONMENT == 'development')
            $blobRestProxy = ServicesBuilder::getInstance()->createBlobService('UseDevelopmentStorage=true');
        if(ENVIRONMENT == 'production')
            $blobRestProxy = ServicesBuilder::getInstance()->createBlobService(blobConnectionString);
        
        //$type = explode(".",$_FILES['Filedata']['name']);
        $type = pathinfo($_FILES['Filedata']['name'], PATHINFO_EXTENSION);
        $blobName = $imageId.'.'.strtoupper($type);

        //create thumbnail on the fly
        $info = getimagesize($_FILES['Filedata']['tmp_name']);
        $width  = isset($info['width'])  ? $info['width']  : $info[0];
        $height = isset($info['height']) ? $info['height'] : $info[1];
        $maxSize = 250;
        $wRatio = $maxSize / $width;
        $hRatio = $maxSize / $height;
        $sourceImage = imagecreatefromstring(file_get_contents($_FILES['Filedata']['tmp_name']));

        // Calculate a proportional width and height no larger than the max size.
        if ( ($width <= $maxSize) && ($height <= $maxSize) )
        {
            // Input is smaller than thumbnail, do nothing
            return $sourceImage;
        }
        elseif ( ($wRatio * $height) < $maxSize )
        {
            // Image is horizontal
            $tHeight = ceil($wRatio * $height);
            $tWidth  = $maxSize;
        }
        else
        {
            // Image is vertical
            $tWidth  = ceil($hRatio * $width);
            $tHeight = $maxSize;
        }
        $thumb = imagecreatetruecolor($tWidth, $tHeight);
        imagecopyresampled($thumb, $sourceImage, 0, 0, 0, 0, $tWidth, $tHeight, $width, $height);
        imagedestroy($sourceImage);
        $thumbImage="thumb.jpg";
        imagejpeg($thumb,$thumbImage);
        $content = file_get_contents($thumbImage);
        $blobRestProxy->createBlockBlob(Thumbnail, $blobName, $content);
    }

    private function saveMetadata($imageId, $album_id)
    {
        $params = array($_FILES['Filedata']['tmp_name']);
        $this->load->library('My_metadata', $params);

        $gps = $this->my_metadata->GPSmetadata_inDecimals();
        $datetime = $this->my_metadata->getDateTimeOriginal();
        $imageSettings = $this->my_metadata->getImageSettings(); //some items might be unavaliable! Decide whether or not to store them.

        $data = array(
                        'imageId' => $imageId,
                        'albumId' => $album_id
                   );

        if($gps!=FALSE)
        {
            foreach($gps as $key=>$value)
                $data[$key] = $value;
        }

        if($datetime!=FALSE)
            $data['DateTimeTaken'] = $datetime;

        //The time will be stored in the metadata table as per GMT time equivalent.
        
        foreach($imageSettings as $key=>$value)
        {
                if($value!="Unavailable")
                    $data[$key] = $value;
        }

        $this->db->insert('metadata', $data); 
        
        if($this->db->affected_rows() == 0) //No Image exists
            return TRUE;
        else
        {
            //roll back image from database and delete uploaded image from blob and thumbnail. Inform user of failure.
            return FALSE; //Image exists.
        }
    }

    private function imageExists($data)
    {
        //This function verifies if the particular image already exists in the database.
        //An image exists in the database if the same user uploads an image with the same name to the same album!
        //In a collaborated album, if a user uploads an image to album which had the name similar to the image by another user, then it will not be counted as duplicate, i.e. image upload should work!
        $username = $data['username'];
        $albumName = $data['albumName'];
        $album_id = md5($this->db->escape($data['albumName']).$this->db->escape($data['username']));

        $imageId = md5($username.$album_id.$_FILES['Filedata']['name']);

        $sql = "SELECT imageName FROM images WHERE imageId='".$imageId."'";
        $query = $this->db->query($sql);

        if($query->num_rows() == 0) //No Image exists
        {
            return TRUE;
        }
        else
            return FALSE; //Image exists.
    }
}
?>