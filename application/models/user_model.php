<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
Class User_model extends CI_Model
{
    function getCreatedAlbums($username)
    {
        $sql = "SELECT albumName, albumId
                FROM albums
                WHERE user_created =".$this->db->escape($username);
        
        $query = $this->db->query($sql);
        return $query->result_array();
    }

    //Use the views for these two functions
    /*function getSharedAlbums($username)
    {
        $sql = "SELECT albumName, albumId
                FROM albums
                WHERE user_created =".$this->db->escape($username);

                //echo $sql."</br>";
        
        $query = $this->db->query($sql);
        return $query->result_array();
    }

    function getCollaboratedAlbums($username)
    {
        $sql = "SELECT albumName, albumId
                FROM albums
                WHERE user_created =".$this->db->escape($username);

                //echo $sql."</br>";
        
        $query = $this->db->query($sql);
        return $query->result_array();
    }*/
}
?>