<?php
Class createAlbumModel extends CI_Model
{
    function _construct()
    {
        parent::__construct();
    }

    function uploadImages($data)
    {
        //the images shall be uploaded to /uploads/images/username/albumName
         $this->load->library('upload');
         $username = $data['username'];
         $albumName = $data['albumName'];
         $album_id = md5($this->db->escape($data['albumName']).$this->db->escape($data['username']));

         if(!($this->createAlbumDatabase($data,$album_id)))
         {
             $error = "Album name already exists";
             //echo $error;
             return $error; //figure out how to display the error most likely parse in JSON and return.
         }

         for($i=0;$i<count($_FILES['file_up']['name']);$i++)
         {  
          $_FILES['userfile']['name']    =   $_FILES['file_up']['name'][$i];
          $_FILES['userfile']['type']    =   $_FILES['file_up']['type'][$i];
          $_FILES['userfile']['tmp_name'] =   $_FILES['file_up']['tmp_name'][$i];
          $_FILES['userfile']['error']       =   $_FILES['file_up']['error'][$i];
          $_FILES['userfile']['size']    =   $_FILES['file_up']['size'][$i]; 
  
          $config['upload_path'] = './uploads/full/';
          $config['allowed_types'] = 'jpg|jpeg|png';
          $config['max_size']	= '0';
          
          $imageId = md5($username.$album_id.$_FILES['userfile']['name']);
          $type = explode("/",$_FILES['userfile']['type']);  //File type is image/jpeg. So split the string at '/'. type[0]=image and type[1] = extension.
          $config['file_name'] = $imageId.'.'.$type[1];
          
          $this->upload->initialize($config);
   
          if (!$this->upload->do_upload()) {  
            $error =  $this->upload->display_errors();
            echo $error;
            return $error; //figure out how to display the error most likely parse in JSON and return.
          } 
    
          $picture = $this->upload->data();
  
          $this->load->library('image_lib');  
          $this->image_lib->clear();
  
          $this->image_lib->initialize(array(
           'image_library' => 'gd2',
           'source_image' => 'uploads/full/'.$picture['file_name'],
           'new_image' => 'uploads/thumbs/'.$picture['file_name'],
           'maintain_ratio' => TRUE,
           'quality' => '100%',
           'width' => 602,
           'height' => 237
          ));
     
     
          if(!$this->image_lib->resize()){  
            $error = $this->image_lib->display_errors();    
          }
          
          if(!$this->addImagesDatabase($data,$picture,$imageId,$album_id))
          {
             //$error = "Album name already exists";
             //echo $error;
             return $error; //figure out how to display the error most likely parse in JSON and return.
         }        
        }
    }

    private function createAlbumDatabase($data, $album_id)
    {
        try
        {
            $sql = "INSERT INTO albums (user_created, albumName,privacy,totalImages,albumId)
                    VALUES (" .$this->db->escape($data['username']).", " .$this->db->escape($data['albumName']).", ".$this->db->escape($data['privacy']).", ".count($_FILES['file_up']['name']).", '".$album_id."')";

            $query = $this->db->query($sql);

            if($this->db->affected_rows() == 1) //album was created.
                return TRUE;
            else
                return FALSE; //album name already exists.
        }
        catch(Exception $error)
        {
            //var_dump ($this->db->error_message());
            //catch exception if the database is offline.
        }
    }

    private function addImagesDatabase($data,$picture,$imageId, $album_id)
    {
        try
        {
            $sql = "INSERT INTO images (owner_userId, albumId,privacy,imageName,imageId)
                    VALUES (" .$this->db->escape($data['username']).", '" .$album_id."', ".$this->db->escape($data['privacy']).", '".$picture['client_name']."', '".$imageId."')";

            $query = $this->db->query($sql);

            if($this->db->affected_rows() == 1) //album was created.
                return TRUE;
            else
                return FALSE; //album name already exists.
        }
        catch(Exception $error)
        {
            //var_dump ($this->db->error_message());
            //catch exception if the database is offline.
        }
    }
}
?>