<?php
Class userModel extends CI_Model
{
    function getAlbums($username)
    {
        $sql = "SELECT albumName, totalImages
                FROM albums
                WHERE username =".$this->db->escape($username)."LIMIT 4";
        
        $query = $this->db->query($sql);
        return $query->row_array();
    }
}
?>