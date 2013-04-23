
<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
session_start(); //we need to call PHP's session object to access it through CI

class User extends CI_Controller {

 function __construct()
 {
   parent::__construct();

   if($this->session->userdata('logged_in'));
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

 function index()
 {
    $data = $this->getSessionData();
    $this->load->model('userModel');
    $data['created_album_info'] = $this->userModel->getCreatedAlbums($data['username']);
    $data['random_images'] = $this->userModel->getRandomImages($data['username']);
    $data["imageURL"] = Actual_Image_blobURL;
    //var_dump($data['random_images'][0]['imageId']);
    //Get shared and collaborated album info's as well and pass it to the view for display.

    $this->load->view('user/user_view', $data);
 }

 function logout()
 {
   $this->session->unset_userdata('logged_in');
   session_destroy();
   redirect('home', 'refresh');
 }

}

?>