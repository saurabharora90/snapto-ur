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

 function album($albumId)
 {
     
 }

 function sharedAlbum($albumId)
 {
     
 }

 function collaboratedAlbum($albumId)
 {
     
 }
}

?>