<?php 
 require_once("/application/libraries/WindowsAzure/WindowsAzure.php");
 use WindowsAzure\Common\ServicesBuilder;
 use WindowsAzure\Common\ServiceException;
 use WindowsAzure\Blob\Models\BlockList;
 use WindowsAzure\Table\Models\Entity;
 use WindowsAzure\Table\Models\EdmType;

Class createAlbumModel extends CI_Model
{
    function _construct()
    {
        parent::__construct();
    }

    public function createAlbumDatabase($data)
    {
        $album_id = md5($this->db->escape($data['albumName']).$this->db->escape($data['username']));
        $sql = "INSERT INTO albums (user_created, albumName,privacy,albumId)
                VALUES (" .$this->db->escape($data['username']).", ".strtoupper($this->db->escape($data['albumName'])).", ".$this->db->escape($data['privacy']).", '".$album_id."')";

        $query = $this->db->query($sql);

        if($this->db->affected_rows() == 1) //album was created.
            return TRUE;
        else
            return FALSE; //album name already exists.
    }
}
?>