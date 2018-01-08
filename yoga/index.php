
<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/yoga/core/init.php';

include 'includes/head.php';
include 'includes/navigation.php';


//sanitizes all fields to make sure bad data is not entered in the database (class booking form)
if (isset($_GET['book'])){
$full_name = ((isset($_POST['full_name']) && !empty($_POST['full_name']))?sanitize($_POST['full_name']):'');
$email = ((isset($_POST['email']) && !empty($_POST['email']))?sanitize($_POST['email']):'');
$telephone = ((isset($_POST['telephone']) && !empty($_POST['telephone']))?sanitize($_POST['telephone']):'');
$gender = ((isset($_POST['gender'])) && !empty($_POST['gender'])?sanitize($_POST['gender']):'');
$book_id = (int)$_GET['book'];
$courseResults = $db->query("SELECT * FROM course WHERE id = '$book_id'");
$bookCourse = mysqli_fetch_assoc($courseResults);


//post handling for class booking form
if ($_POST) {
  $errors= array();
  $required = array('full_name', 'email', 'telephone');
  //check to see if all required fields are filled
  foreach($required as $field){
    if($_POST[$field] == ''){
      $errors[] = 'All fields with an astrisk are required.';
      break;
    }
  }
  //check if email is valid
  if(!filter_var($email,FILTER_VALIDATE_EMAIL)){
    $errors[] = 'Please enter a valid email address.';
  }

  //show errors if fields not filled
  if(!empty($errors)){
    echo display_errors($errors);
  }else{
    //insert into database if all is good
    $insertSql = "INSERT INTO students (`full_name`,`email`,`telephone`,`gender`, `course_id`)
     VALUES ('$full_name','$email', '$telephone', '$gender', '$book_id')";
     $db->query($insertSql);
     header("Location: confirmBooking.php?book=$book_id.php");
  }
}
 ?>

 <!-- Class booking form -->
 <h3 class="text-center">Enter Your Details</h3><hr>
 <div class="container">
 <form action="index.php?book=<?=$book_id?>" method="POST" enctype="multipart/form-data">
   <div class="form-group col-md-3">
     <label for="full_name">Full Name*:</label>
     <input type="text" name="full_name" class="form-control" id="full_name" value="<?=$full_name;?>">
   </div>
   <div class="form-group col-md-3">
     <label for="email">Email*:</label>
     <input type="email" name="email" class="form-control" id="email" value="<?=$email;?>">
   </div>
   <div class="form-group col-md-3">
     <label for="telephone">Telephone*:</label>
     <input type="text" id="telephone" name="telephone" class="form-control" value="<?=$telephone;?>">
     </select>
   </div>
   <div class="form-group col-md-3">
     <label for="gender">Gender:</label>
     <select class="form-control" id="gender" name="gender">
       <option value="Female">Female</option>
       <option value="Male">Male</option>
     </select>
   </div>
   <div class="form-group pull-right">
     <a href="index.php" class="btn btn-default">Cancel</a>
     &nbsp;
     <input type="submit" value="Submit Booking" class="btn btn-danger">
   </div><div class="clearfix"></div>
 </form>
 </div>

<?php }

//get all future classes from database that have not been deleted
else{
$sql = "SELECT * FROM course WHERE deleted = 0 AND class_date >= CURDATE() ORDER BY class_date";
$presults = $db->query($sql);

?>
 <hr>
 <!-- View all available classes -->
 <div class="container">
  <h3 class="text-center">Yoga Classes</h3>
  <hr>
  <table class="table table-bordered table-condensed table-striped">
    <thead><th></th><th>Date & Time</th><th>Duration</th><th>Style</th><th>Instructor</th><th>Description</th></thead>
    <tbody>
      <?php while($course = mysqli_fetch_assoc($presults)):

      ?>
      <tr>
        <td align="center">
        <a href="index.php?book=<?=$course['id'];?>" type="button" class ="btn btn-xs btn-default"<?=(($course['full'] == 1)?'disabled':'');?>><?=(($course['full'] == 1)?'Class Full ':'Book Class ');?><span class="glyphicon <?=(($course['full'] == 1)?'glyphicon-remove':'glyphicon-log-in');?>"></span></a>
        </td>
        <td><?=pretty_date($course['class_date'])?></td>
        <td><?=$course['duration'];?></td>
        <td><?=$course['style'];?></td>
        <td><?=$course['instructor'];?></td>
        <td><?=$course['description'];?></td>

      </tr>
    <?php endwhile; ?>
  </tbody>
</table>
</div>


<?php } include 'includes/footer.php'; ?>
