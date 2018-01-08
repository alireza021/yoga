<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/yoga/core/init.php';
include 'includes/head.php';


//sanitize information entering database
$email = ((isset($_POST['email']))?sanitize($_POST['email']):'');
$email = trim($email);
$password = ((isset($_POST['password']))?sanitize($_POST['password']):'');
$password = trim($password);

$errors = array();
?>
<div class="single_top">
	 <div class="container">
	    <div class="register" id="login-form">
			  <div class="login-right">
			  	<h3 class="text-center">ADMINISTRATOR LOGIN</h3>

        <div>
          <?php
            if($_POST){
              //form validation
              if(empty($_POST['email']) || empty($_POST['password'])){
                $errors[] = 'You must provide email and password.';
              }

              //validate email
              if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
                $errors[] = 'You must enter a valid email.';
              }

              //password is more than 6 character
              if(strlen($password) < 6) {
                $errors[] = 'Password must be at least 6 characters long.';
              }

              //check if emails exist in DB
              $query = $db->query("SELECT * FROM users WHERE email='$email'");
              $user = mysqli_fetch_assoc($query);
              $userCount = mysqli_num_rows($query);
              if($userCount < 1){
                $errors[] = 'Your email does not exist in our database.';
              }

              if(!password_verify($password, $user['password'])){
                $errors[] = 'The password does not match your email, please try again.';

              }
              //check for errors
              if(!empty($errors)){
                echo display_errors($errors);
              }
              else{
                //log user in
                $user_id = $user['id'];
                login($user_id);
              }
            }

          ?>
				<!-- login form -->
        </div>
				<form action="login.php" method="post">
				  <div>
					<span><label for="email">Email Address*</label></span>
					<input type="email" name="email" id="email" class="form-control" value="<?=$email;?>">
				  </div>
				  <div>
					<span><label for="password">Password*</label></span>
					<input type="password" name="password" id="password" class="form-control" value-"<?=$password;?>">
				  </div>

				  <input type="submit" value="Login" class="btn btn-danger">
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
