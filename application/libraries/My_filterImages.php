<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 
 require_once("/application/libraries/WindowsAzure/WindowsAzure.php");
 use WindowsAzure\Common\ServicesBuilder;
 use WindowsAzure\Common\ServiceException;
 use WindowsAzure\Table\Models\QueryEntitiesOptions;

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
        if(ENVIRONMENT == 'development')
            $tableRestProxy = ServicesBuilder::getInstance()->createTableService('UseDevelopmentStorage=true');
        if(ENVIRONMENT == 'production')
            $tableRestProxy = ServicesBuilder::getInstance()->createTableService(tableConnectionString);

        $filter = "PartitionKey eq '".$this->albumId."'";
        //$options = new QueryEntitiesOptions();
        //$options->addSelectField("DateTimeOriginal");
        //$options->setNextPartitionKey($this->albumId);
        //var_dump($options);
        $datetimearr = array();
        try 
        {
            $result = $tableRestProxy->queryEntities("metadata", $filter);
            $entities = $result->getEntities();

            foreach($entities as $entity)
            {
                $photoTaken = $entity->getPropertyValue("DateTimeOriginal");
                $imageId = $entity->getRowKey();
                $datetimearr[$imageId] = $photoTaken;
            }
            array_multisort($datetimearr, SORT_ASC);
            var_dump ($datetimearr);
        }
        catch(ServiceException $e)
        {
            // Handle exception based on error codes and messages.
            // Error codes and messages are here: 
            // http://msdn.microsoft.com/en-us/library/windowsazure/dd179438.aspx
            $code = $e->getCode();
            $error_message = $e->getMessage();
            echo $code.": ".$error_message."<br />";
        }
    }

}