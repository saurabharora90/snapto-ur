<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

Class viewAlbumModel extends CI_Model
{
    function _construct()
    {
        parent::__construct();
    }

    public function myAlbum($albumId, $userdata, $percent)
    {
        //check if the user owns this album!
        $sql = "SELECT albumName,privacy,date_uploaded
                FROM albums
                WHERE user_created =".$this->db->escape($userdata['username'])." AND albumId=".$this->db->escape($albumId);

        $query = $this->db->query($sql);
        if($query->num_rows() == 0) //User does not own that album
            return;
        else
        {
            $album_Info = $query->row_array();
            $params = array(0=>$albumId,1=>$percent);
            $this->load->library("My_filterImages",$params);

            //$imagesToDisplay = $this->my_filterimages->getRandomSet();
            
            $imagesToDisplay = $this->my_filterimages->getfilteredSet();

            $count = "SELECT COUNT(*) AS cnt FROM images WHERE albumId=".$this->db->escape($albumId);
            $query = $this->db->query($count);
            $result = $query->row();
            
            return array(0=>$album_Info["albumName"], 1=>$imagesToDisplay, 2=>$result->cnt);
        }
    }

    public function sharedAlbum($albumId)
    {
        
    }

    public function collaboratedAlbum($albumId)
    {
        
    }
}
?>