<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

 /*
 This library contains the main algorithm information!
 This library is called once we have done all the verification about the album to view. This selects the best "percent" set of images to
 show to the end user based on the metadata information of each of the images and the image processing algorithms (histogram analysis)
 */

class My_filterImages{
    
    var $albumId      =   "";
    var $percent      =   "";
    var $CI           =   "";

    public function __construct($params)
	{
        $this->albumId = $params[0];
        $this->percent = $params[1];
        $this->CI =& get_instance();
	}

    /*
    This function return a random set of images without any filtering and analysis
    This function was created as a part of the demo to show the intial functionality and the idea of the project   
    */
    function getRandomSet()
    {
        //get total number of images in album
        $count = "SELECT COUNT(*) AS cnt FROM images WHERE albumId=".$this->CI->db->escape($this->albumId);
        $query = $this->CI->db->query($count);
        $result = $query->row();

        //show percent of total images.
        $toShow = (($this->percent) * ($result->cnt))/100;
        $toShow = floor($toShow);

        if($toShow == 0)
            $toShow = $result->cnt;

        $sql = "SELECT privacy, imageName, tag, imageId
                FROM images
                WHERE albumId=".$this->CI->db->escape($this->albumId)."ORDER BY rand() LIMIT ".$toShow;
        //var_dump($sql);
        $query = $this->CI->db->query($sql);

        if($query->num_rows() == 0) //User does not own that album
            return "No images in this album";

        return $query->result_array();
    }

    function getfilteredSet()
    {
        $datetimearr = array();
        array_multisort($datetimearr, SORT_ASC);
        var_dump ($datetimearr);

        //retrive total number of days over which album is spread.
    }

}