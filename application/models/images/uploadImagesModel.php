<?php 
 require_once("/application/libraries/WindowsAzure/WindowsAzure.php");
 use WindowsAzure\Common\ServicesBuilder;
 use WindowsAzure\Common\ServiceException;
 use WindowsAzure\Blob\Models\BlockList;
 use WindowsAzure\Table\Models\Entity;
 use WindowsAzure\Table\Models\EdmType;

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
         $album_id = md5($this->db->escape($data['albumName']).$this->db->escape($data['username']));

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
        //$this->saveImageToBlob($imageId,$data);

        //Creat Image thumbnail and push that to blob storage as well
        //$this->saveThumbnail($imageId);

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
            $blobRestProxy = ServicesBuilder::getInstance()->createBlobService(blobConnectionString);
            $type = explode(".",$_FILES['Filedata']['name']);
            $blobName = $imageId.'.'.$type[1];

            $blockMaxSize = 4*1024*1024; //4MB
            $fileSize = $_FILES['Filedata']['size'];
            $numOfBlocks = $fileSize/$blockMaxSize;
            $currentFileIndex = 0;
            $blockId=1;
            $blocklist = new BlockList();
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

            $blobRestProxy->commitBlobBlocks(Actual_Image, $blobName, $blocklist->getEntries());
        }
        catch (ServiceException $e)
        {
            $username = $data['username'];
            $albumName = $data['albumName'];
            $album_id = md5($this->db->escape($data['albumName']).$this->db->escape($data['username']));
            $imageId = md5($username.$album_id.$_FILES['Filedata']['name']);
            $this->rollBackImage($imageId);
            //show_error($e->getMessage(),502);
            $this->output->set_header("HTTP/1.1 502 Bad Gateway");
            return;
        }
        catch (Exception $e)
        {
            $username = $data['username'];
            $albumName = $data['albumName'];
            $album_id = md5($this->db->escape($data['albumName']).$this->db->escape($data['username']));
            $imageId = md5($username.$album_id.$_FILES['Filedata']['name']);
            $this->rollBackImage($imageId);
            $this->output->set_header("HTTP/1.1 502 Bad Gateway");
            //show_error($e->getMessage(),502);
            return;
        }

    }

    private function saveThumbnail($imageId)
    {
        $blobRestProxy = ServicesBuilder::getInstance()->createBlobService(blobConnectionString);
        $type = explode(".",$_FILES['Filedata']['name']);
        $blobName = $imageId.'.'.$type[1];

        $blobRestProxy->createBlockBlob(Thumbnail, $blobName, $content);
    }

    private function saveMetadata($imageId, $album_id)
    {
        $params = array($_FILES['Filedata']['tmp_name']);
        $this->load->library('My_metadata', $params);

        $gps = $this->my_metadata->GPSmetadata_inDecimals();
        $datetime = $this->my_metadata->getDateTimeOriginal();
        $imageSettings = $this->my_metadata->getImageSettings(); //some items might be unavaliable! Decide whether or not to store them.

        //var_dump($gps,$datetime,$imageSettings);

        //Save image metadata to table storage
        $tableRestProxy = ServicesBuilder::getInstance()->createTableService(tableConnectionString);
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