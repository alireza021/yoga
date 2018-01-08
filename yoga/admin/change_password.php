<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/yoga/core/init.php';
if(!is_logged_in()){
  login_error_redirect();
}
include 'includes/head.php';

$hashed = $user_data['password'];
$old_password = ((isset($_POST['old_password']))?sanitize($_POST['old_password']):'');
$old_password = trim($old_password);
$password = ((isset($_POST['password']))?sanitize($_POST['password']):'');
$password = trim($password);
$confirm = ((isset($_POST['confirm']))?sanitize($_POST['confirm']):'');
$confirm = trim($confirm);
$new_hashed = password_hash($password, PASSWORD_DEFAULT);
$user_id = $user_data['id'];
$errors = array();
?>
<div class="single_top">
	 <div class="container">
	    <div class="register" id="login-form">
			  <div class="login-right">
			  	<h3 class="text-center">CHANGE PASSWORD</h3>

        <div>
          <?php
            if($_POST){
              //form validation
              if(empty($_POST['old_password']) || empty($_POST['password']) || empty($_POST['confirm'])){
                $errors[] = 'You must fill out all fields.';
              }

              //password is more than 6 character
              if(strlen($password) < 6) {
                $errors[] = 'Password must be at least 6 characters long.';
              }

              //if new password matches confirm
              if($password != $confirm){
                $errors[] = 'New password confirmation did not match, please try again';
              }

              if(!password_verify($old_password, $hashed)){
                $errors[] = 'You did not enter the correct old password, please try again.';

              }
              //check for errors
              if(!empty($errors)){
                echo display_errors($errors);
              }
              else{
                //change password
                $db->query("UPDATE users SET password = '$new_hashed' WHERE id='$user_id'");
                $_SESSION['success_flash'] = 'Your password has been updated!';
                header('Location: index.php');
              }
            }

          ?>
        </div>
        <!-- Password changing form -->
				<form action="change_password.php" method="post">
				  <div>
					<span><label for="old_password">Old Password:</label></span>
					<input type="password" name="old_password" id="old_password" class="form-control" value="<?=$old_password;?>">
				  </div>
				  <div>
					<span><label for="password">New Password:</label></span>
					<input type="password" name="password" id="password" class="form-control" value-"<?=$password;?>">
				  </div>
          <div>
          <span><label for="confirm">Confirm New Password:</label></span>
					<input type="password" name="confirm" id="confirm" class="form-control" value-"<?=$confirm;?>">
				  </div>
          <a href="index.php" class="btn btn-default">Cancel</a>
				  <input type="submit" value="Update Password" class="btn btn-danger">

			    </form>

			   </div>

			   <div class="clearfix"> </div>
		</div>
     </div>
</div>


<div class="footer_bottom">
  <div class="copy">
            <p>Copyright © 2018 Alireza Shafiei</p>
      </div>
  </div>
