<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
Class Login_model extends CI_Model
{
 function login_verify($username, $password)
 {
   $this -> db -> select('email, password, name');
   $this -> db -> from('users');
   $this -> db -> where('email', $username);
   $this -> db -> where('password', MD5($password));
   $this -> db -> limit(1);

   $query = $this -> db -> get();

   if($query -> num_rows() == 1)
   {
     return $query->result();
   }
   else
   {
     return false;
   }
 }
}
?>