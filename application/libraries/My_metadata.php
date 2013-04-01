<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

 /*
 This library contains all the functions required to extract metatdat information from a image file.
 The metadata stored in the EXIF file is extracted.
 */

class My_metadata{
    
    var $file_path      =   "";
    var $exif           =   "";

    public function __construct($params)
	{
		$this->file_path = $params[0];
        $this->exif = exif_read_data($this->file_path);
	}

    function GPSmetadata_inDecimals()
    {
        //i.e. this file doesn't have metadata info.
        if(!$this->exif || empty($this->exif['GPSLatitude']))
            return false;

        //get the Hemisphere multiplier
        $LatM = 1; $LongM = 1;
        if($this->exif["GPSLatitudeRef"] == 'S')
        {
            $LatM = -1;
        }
        if($this->exif["GPSLongitudeRef"] == 'W')
        {
            $LongM = -1;
        }

        //get the GPS data
        $gps['LatDegree']=$this->exif["GPSLatitude"][0];
        $gps['LatMinute']=$this->exif["GPSLatitude"][1];
        $gps['LatgSeconds']=$this->exif["GPSLatitude"][2];
        $gps['LongDegree']=$this->exif["GPSLongitude"][0];
        $gps['LongMinute']=$this->exif["GPSLongitude"][1];
        $gps['LongSeconds']=$this->exif["GPSLongitude"][2];

        //convert strings to numbers
        foreach($gps as $key => $value)
        {
            $pos = strpos($value, '/');
            if($pos !== false)
            {
                $temp = explode('/',$value);
                $gps[$key] = $temp[0] / $temp[1];
            }
        }

        //calculate the decimal degree
        $result['latitude'] = $LatM * ($gps['LatDegree'] + ($gps['LatMinute'] / 60) + ($gps['LatgSeconds'] / 3600));
        $result['longitude'] = $LongM * ($gps['LongDegree'] + ($gps['LongMinute'] / 60) + ($gps['LongSeconds'] / 3600));

        //return json_encode($result);
        return $result;
    }

    function getDateTimeOriginal()
    {
        //i.e. this file doesn't have metadata info.
        if(!$this->exif || empty($this->exif['DateTimeOriginal']))
            return false;

        return $this->exif['DateTimeOriginal'];
    }

    function getImageSettings()
    {
        //i.e. this file doesn't have metadata info.
        if(!$this->exif )
            return false;
        
        //error control
        $notFound = "Unavailable";

         if (array_key_exists('ExposureTime',$this->exif))
            $imageSpecific['ExposureTime'] = $this->exif['ExposureTime'];
        else
            $imageSpecific['ExposureTime'] = $notFound;

        if (array_key_exists('FNumber',$this->exif))
            $imageSpecific['FNumber'] = $this->exif['FNumber'];
        else
            $imageSpecific['FNumber'] = $notFound;

        if (array_key_exists('ISOSpeedRatings',$this->exif))
            $imageSpecific['ISOSpeedRatings'] = $this->exif['ISOSpeedRatings'];
        else
            $imageSpecific['ISOSpeedRatings'] = $notFound;
        
        if (array_key_exists('CompressedBitsPerPixel',$this->exif))
            $imageSpecific['CompressedBitsPerPixel'] = $this->exif['CompressedBitsPerPixel'];
        else
            $imageSpecific['CompressedBitsPerPixel'] = $notFound;
        
        if (array_key_exists('ShutterSpeedValue',$this->exif))
            $imageSpecific['ShutterSpeedValue'] = $this->exif['ShutterSpeedValue'];
        else
            $imageSpecific['ShutterSpeedValue'] = $notFound;
        
        if (array_key_exists('ApertureValue',$this->exif))
            $imageSpecific['ApertureValue'] = $this->exif['ApertureValue'];
        else
            $imageSpecific['ApertureValue'] = $notFound;
        
        if (array_key_exists('FocalLength',$this->exif))
            $imageSpecific['FocalLength'] = $this->exif['FocalLength'];
        else
            $imageSpecific['FocalLength'] = $notFound;

        //convert strings to numbers
        /*foreach($imageSpecific as $key => $value)
        {
            $pos = strpos($value, '/');
            if($pos !== false)
            {
                $temp = explode('/',$value);
                $imageSpecific[$key] = $temp[0] / $temp[1];
            }
        }*/

        return $imageSpecific;
    }


}