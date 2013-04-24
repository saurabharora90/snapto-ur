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

        //var_dump($query->result_array());

        return $query->result_array();
    }

    function getfilteredSet()
    {
        $imagesByDay = $this->ImagesIndexedByDate_ArrangedByTime();
        $imagesByDay_TimeInterval = $this->ImagesIndexedByDate_SubIndexedbyTimeIntervals($imagesByDay);
        $imagesByDay = NULL;
        $selected = array();
        $count = 0;
        foreach($imagesByDay_TimeInterval as $date=>$timeSlot)
        {
            foreach($timeSlot as $slot=>$photos)
            {
                
                $totalInTHisDay = sizeof($photos);
                $toSelectFromthisDay = (($this->percent) * ($totalInTHisDay))/100;
                $toSelectFromthisDay = ceil($toSelectFromthisDay);

                for($i=0;$i<$toSelectFromthisDay;$i++)
                {
                    srand();
                    $choose = mt_rand(0,$totalInTHisDay-1);
                    //echo $choose.", ";
                    $selected[$count] = array("imageId" => $photos[$choose]["imageId"], "imageName" => $photos[$choose]["imageName"]);
                    $count++;
                }
                //echo "</br> </br>";
            }
        }
        return $selected;
    }

    /*
    Returns an array which contains all the images in the album organised ans sorted by data
    return @array such that array[date1]=>all Images taken on this date, array[date2]=>all Images taken on this date and soo on. Only the time component of the images are returned as the array index key represents the date
    */
    private function ImagesIndexedByDate_ArrangedByTime()
    {
        $sql = "SELECT imageId, date(DateTimeTaken) as date FROM metadata WHERE albumId = {$this->CI->db->escape($this->albumId)} Order By DateTimeTaken";
        $query = $this->CI->db->query($sql);
        
        $albumStartDate = $query->first_row('array'); //to force output as an array.
        $albumStartDate = DateTime::createFromFormat('Y-m-d', $albumStartDate['date']);

        $albumEndDate = $query->last_row('array');
        $albumEndDate = DateTime::createFromFormat('Y-m-d', $albumEndDate['date']);

        //find the number of days over which the album is spread.
        $interval = $albumEndDate->diff($albumStartDate);
        //var_dump($interval);

        //reclaim memory
        $query = NULL;
        
        //retrive total number of days over which album is spread.
        $imagesByDay = array();
        $startDate = $albumStartDate;

        for($i=0; $i<=$interval->d;$i++)
        {
            $start = $startDate->format('Y-m-d');
            $endDate = $startDate->add(new DateInterval('P1D'));
            $end = $endDate->format('Y-m-d');

            $sql = "SELECT imageId, time(DateTimeTaken) as time
                    FROM metadata
                    WHERE albumId = {$this->CI->db->escape($this->albumId)} AND DateTimeTaken >= '{$start}' AND DateTimeTaken < '{$end}' 
                    Order By DateTimeTaken";
            $query = $this->CI->db->query($sql);
            $imagesByDay[$start] = $query->result_array();
            $startDate = $endDate;
        }

        return $imagesByDay;
    }

    private function ImagesIndexedByDate_SubIndexedbyTimeIntervals($imagesByDay)
    {
        $timePeriod = array(); //the period over which the photos are taken, i.e. 4 hours or 3 hours or 10 hours!
        $imagesByDay_TimeInterval = array();

        foreach($imagesByDay as $key=>$value)
        {
            $startTime = $imagesByDay[$key][0]['time'];
            $startTime = DateTime::createFromFormat('H:i:s', $startTime);

            $last = $imagesByDay[$key][sizeof($imagesByDay[$key])-1]['time'];
            $last = DateTime::createFromFormat('H:i:s', $last);
            
            $interval = $last->diff($startTime);
            $timePeriod[$key] = $interval->h;

            if($interval->i != 0)  //if the period is like 1 hour and some minutes then make the period be 2 hours.
                $timePeriod[$key]++;

            if($timePeriod[$key] <= 6)
                $timeIntervals = 1;  //group photos which are one hour apart
            elseif($timePeriod[$key] > 6 && $timePeriod[$key] <= 12)
                $timeIntervals = 2; //group photos which are 2 hour apart
            elseif($timePeriod[$key] > 12 && $timePeriod[$key] <=18 )
                $timeIntervals = 3; //group photos which are 3 hour apart
            else
                $timeIntervals = 4; //group photos which are 4 hour apart

            $last = $last->format('H:i:s');
            $last = $key." ".$last;

            for($i=0; $i<ceil($timePeriod[$key]/$timeIntervals);$i++)  //$timePeriod[$key]/$timeIntervals represents the number of intervals that we will have
            {
                $start = $startTime->format('H:i:s');
                $endTime = $startTime->add(new DateInterval("PT".$timeIntervals."H"));
                $end = $endTime->format('H:i:s');

                $start = $key." ".$start;
                $end = $key." ".$end;

                if($i == ceil($timePeriod[$key]/$timeIntervals) -1 )
                    $end = $key." "."23:59:59";

                $sql = "SELECT m.imageId, m.DateTimeTaken, i.imageName
                        FROM metadata m, images i
                        WHERE m.imageId = i.imageId AND m.albumId = {$this->CI->db->escape($this->albumId)} AND m.DateTimeTaken >= '{$start}' AND m.DateTimeTaken < '{$end}' 
                        Order By m.DateTimeTaken";
                //echo $sql ."</br></br>";

                //store as arr["date"]["timeStart-timeEnd"] = imageId's
                $query = $this->CI->db->query($sql);
                $imagesByDay_TimeInterval[$key][$start."-".$end] = $query->result_array();

                $startTime = $endTime;
            }
        }
        
        //var_dump($imagesByDay_TimeInterval);
        return $imagesByDay_TimeInterval;
    }

}