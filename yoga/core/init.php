<?php

//innitialize database connection and create session
$db = mysqli_connect('127.0.0.1', 'root', '', 'yoga');
if (mysqli_connect_errno()) {
  echo 'Database connection failed with following errors: '. mysqli_connect_error();
  die();
}
session_start();
require_once $_SERVER['DOCUMENT_ROOT'].'/yoga/config.php';

if(isset($_SESSION['success_flash'])){
  echo '<div class="bg-success"><p class="text-success text-center">'.$_SESSION['success_flash'].'</p></div>';
  unset($_SESSION['success_flash']);
}

if(isset($_SESSION['error_flash'])){
  echo '<div class="bg-danger"><p class="text-danger text-center">'.$_SESSION['error_flash'].'</p></div>';
  unset($_SESSION['error_flash']);
}

//keep instructors logged in using session
if(isset($_SESSION['SBUser'])){
  $user_id = $_SESSION['SBUser'];
  $query = $db->query("SELECT * FROM users WHERE id='$user_id'");
  $user_data = mysqli_fetch_assoc($query);
  $fn = explode(' ', $user_data['full_name']);
  $user_data['first'] = $fn[0];
  $user_data['last'] = $fn[1];
}

//below are a list of functions that are used multiple times during the project


//this function makes sure bad data cant be entered into the database
function sanitize($dirty){
  return htmlentities($dirty, ENT_QUOTES, "UTF-8");
}

//function for displaying form errors
function display_errors($errors) {
  $display = '<ul class="bg-danger">';
  foreach ($errors as $error) {
    $display .= '<li class="text-danger">&nbsp;&nbsp;&nbsp;'.$error.'</li>';
  }
  $display .= '</ul>';
  return $display;
}

//update user "last login date" field in the database
function login($user_id){
  $_SESSION['SBUser'] = $user_id;
  global $db;
  $date = date("Y-m-d H:i:s");
  $db->query("UPDATE users SET last_login = '$date' WHERE id = '$user_id'");
  $_SESSION['success_flash'] = 'You are now logged in!';
  header('Location: index.php');
}

//check to see if user is logged in
function is_logged_in(){
  if(isset($_SESSION['SBUser']) && $_SESSION['SBUser'] > 0) {
    return true;
  }
  else{
    return false;
  }
}

function login_error_redirect($url = 'login.php'){
  $_SESSION['error_flash'] = 'You must be logged in to access that page.';
  header('Location: '.$url);

}

//check to see if user has permissions to be admin page
function permission_error_redirect($url = 'login.php'){
  $_SESSION['error_flash'] = 'You do not have permission to access that page.';
  header('Location: '.$url);

}

//check to see if admin has permissions to add other admins (only some do)
function has_permission($permission = 'admin'){
  global $user_data;
  $permissions = explode(',', $user_data['permissions']);
  if(in_array($permission, $permissions, true)){
    return true;
  }
    return false;
}

//simple function to make the date look nicer
function pretty_date($date){
  return date("M d, Y h:i A", strtotime($date));
}
