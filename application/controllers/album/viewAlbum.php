<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
session_start(); //we need to call PHP's session object to access it through CI

/*Need to check privacy and sharing option

1) Have three functions:
    a) View own album : Check with album id that the logged in user is the current user and then only allow access.
    b) View Shared Album : Check with album id that the logged in user is allowed to view the album, i.e. the album is actually shared with him
    c) View collaborated album : Check with album id that the logged in user had been given collaboration access to this album.

All the above cross check is neccessay to make sure that someone with the album id is not allowed to view the albums.

If an album is being accessed to which access is not allowed, then just show Album does not exist instead of saying that access is not allowed.
This helps in making sure that no one will realize if the album id he/she put in is the correct one.
*/

class viewAlbum extends CI_Controller {

    var $userdata   =   "";

 function __construct()
 {
   parent::__construct();

   if($this->session->userdata('logged_in'))
     $this->userdata = $this->getSessionData();
   else
   {
        //If no session, redirect to login page
        redirect('login', 'refresh');
   }
 }

 private function getSessionData()
 {
     $session_data = $this->session->userdata('logged_in');
     $data['username'] = $session_data['username'];
     $data['name'] = $session_data['name'];
     return $data;
 }

 function myAlbum($albumId, $percent = 30)
 {
    $this->load->model("album/viewAlbumModel");
    $result = $this->viewAlbumModel->myAlbum($albumId,$this->userdata, $percent);
 
    if(empty($result)) //user does not own the album
       show_404("album/viewAlbum/myAlbum");

    else
    {
        //var_dump($imagesToDisplay);
        $data["albumName"] = $result[0];
        $data["displayImages"] = $result[1];
        $data["totalImagesInAlbum"] = $result[2];
        $data["imageURL"] = Actual_Image_blobURL;
        $data["name"] = $this->userdata["name"];
        $data["albumId"] = $albumId;
        //$data["percent"] = $percent;
        $this->load->view("user/album/viewAlbum_view",$data);
    }
 }

 function sharedAlbum($albumId)
 {
     
 }

 function collaboratedAlbum($albumId)
 {
     
 }

 function sliderUpdate($albumId, $percent)
 {
     if($this->input->is_ajax_request())
     {
        $this->load->model("album/viewAlbumModel");
        $result = $this->viewAlbumModel->myAlbum($albumId,$this->userdata, $percent);
 
        if(empty($result)) //user does not own the album
           show_404("album/viewAlbum/myAlbum");

        else
        {
            $data["displayImages"] = $result[1];
            $data["totalImagesInAlbum"] = $result[2];
            $data["imageURL"] = Actual_Image_blobURL;
            echo json_encode($data);
         }
     }
     else
        show_404('album/viewAlbum/sliderUpdate');
 }
}

?>