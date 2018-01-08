<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/yoga/core/init.php';

//make sure user is logged in to be on this page
if(!is_logged_in()){
  header('Location: login.php');
}

include 'includes/head.php';
include 'includes/navigation.php';


//delete product
if(isset($_GET['delete'])){
  $id = sanitize($_GET['delete']);
  $db->query("UPDATE course SET deleted = 1 WHERE id = '$id'");
  header('Location: index.php');
}


//sanitize "edit" and "add" forms for security
if (isset($_GET['add']) || isset($_GET['edit'])){
$class_date = ((isset($_POST['class_date']) && !empty($_POST['class_date']))?sanitize($_POST['class_date']):'');
$duration = ((isset($_POST['duration']) && !empty($_POST['duration']))?sanitize($_POST['duration']):'');
$style = ((isset($_POST['style'])) && !empty($_POST['style'])?sanitize($_POST['style']):'');
$instructor = ((isset($_POST['instructor']) && $_POST['instructor'] != '')?sanitize($_POST['instructor']):'');
$description = ((isset($_POST['description']) && $_POST['description'] != '')?sanitize($_POST['description']):'');

//get the class that needs to be edited
if(isset($_GET['edit'])){
  $edit_id = (int)$_GET['edit'];
  $courseResults = $db->query("SELECT * FROM course WHERE id = '$edit_id'");
  $course = mysqli_fetch_assoc($courseResults);

  $class_date = ((isset($_POST['class_date']) && $_POST['class_date'] != '')?sanitize($_POST['class_date']):$course['class_date']);
  $duration = ((isset($_POST['duration']) && $_POST['duration'] != '')?sanitize($_POST['duration']):$course['duration']);
  $style = ((isset($_POST['style']) && $_POST['style'] != '')?sanitize($_POST['style']):$course['style']);
  $instructor = ((isset($_POST['instructor']) && $_POST['instructor'] != '')?sanitize($_POST['instructor']):$course['instructor']);
  $description = ((isset($_POST['description']))?sanitize($_POST['description']):$course['description']);
}

//handling post for editing and adding new classes
if ($_POST) {
  $errors= array();
  $required = array('class_date', 'duration', 'style', 'instructor');
  //form validation
  foreach($required as $field){
    if($_POST[$field] == ''){
      $errors[] = 'All fields with an astrisk are required.';
      break;
    }
  }
  //display errors if any problems
  if(!empty($errors)){
    echo display_errors($errors);
  }else{
  //insert into database if no problems
    $insertSql = "INSERT INTO course (`class_date`,`duration`,`style`,`instructor`, `description`)
     VALUES ('$class_date', '$duration', '$style','$instructor', '$description')";
     if(isset($_GET['edit'])){
       $insertSql = "UPDATE course SET `class_date` = '$class_date',
       `duration` = '$duration', `style` = '$style', `instructor` = '$instructor', `description` = '$description'
       WHERE id ='$edit_id'";
     }
     $db->query($insertSql);
     header('Location: index.php');
  }
}

?>
<!-- Form for adding new class and editing existing class -->
<h3 class="text-center"><?=((isset($_GET['edit']))?'Edit':'Add A New');?> Class</h3><hr>
<div class="container">

  <form action="index.php?<?=((isset($_GET['edit']))?'edit='.$edit_id:'add=1');?>" method="POST" enctype="multipart/form-data">
    <div class="form-group col-md-3">
      <label for="class_date">Date & Time*:</label>
      <input type="datetime-local" name="class_date" class="form-control" id="class_date" value="<?=$class_date;?>">
    </div>
    <div class="form-group col-md-3">
      <label for="duration">Duration*:</label>
      <select class="form-control" id="duration" name="duration">
        <option value="60 Minutes">60 Minutes</option>
        <option value="90 Minutes">90 Minutes</option>
      </select>
    </div>
    <div class="form-group col-md-3">
      <label for="style">Style*:</label>
      <input type="text" id="style" name="style" class="form-control" value="<?=$style;?>">
      </select>
    </div>
    <div class="form-group col-md-3">
      <label for="instructor">Instructor*:</label>
      <input type="text" id="instructor" name="instructor" class="form-control" value="<?=$instructor;?>">
    </div>
    <div class="form-group col-md-6">
      <label for="description">Description:</label>
      <textarea id="description" name="description" class="form-control" rows="6"><?=$description;?></textarea>
    </div>

    <div class="form-group pull-right">
      <a href="index.php" class="btn btn-default">Cancel</a>
      &nbsp;
      <input type="submit" value="<?=((isset($_GET['edit']))?'Edit':'Add');?> Class" class="btn btn-danger">
    </div><div class="clearfix"></div>
  </form>
</div>



<?php
}
//get all enrolled students for specific class
else if(isset($_GET['enrolled'])){
  $enrol_id = (int)$_GET['enrolled'];
  $enrolled_students = $db->query("SELECT * FROM students WHERE course_id = $enrol_id");
?>

<!-- List for viewing all enrolled students in a specific class -->
<h3 class="text-center">Enrolled Students for Class <?=$enrol_id?></h3><hr>
<div class="container">
  <table class="table table-bordered table-condensed table-striped enrolled">
    <thead><th>Name</th><th>Email</th><th>Telephone</th><th>Gender</th></thead>
    <tbody>
      <?php while($student = mysqli_fetch_assoc($enrolled_students)):
        ?>
        <tr>
          <td><?=$student['full_name'];?></td>
          <td><?=$student['email'];?></td>
          <td><?=$student['telephone'];?></td>
          <td><?=$student['gender'];?></td>
        </tr>
      <?php endwhile; ?>
    </tbody>
  </table>
  <div class="pull-right">
    <a href="index.php" class="btn btn-default">Cancel</a>
    &nbsp;
    <a href="index.php?full=1&id=<?=$enrol_id?>" type="button" class="btn btn-danger">Mark Class as Full</a>
  </div><div class="clearfix"></div>
  <br>
</div>


<?php
//Get all classes that have not been deleted
}else{
$sql = "SELECT * FROM course WHERE deleted = 0 ORDER BY class_date";
$presults = $db->query($sql);

//change "class full" field in database
if (isset($_GET['full'])) {
  $id = (int)$_GET['id'];
  $full = (int)$_GET['full'];
  $fullSql = "UPDATE course SET full = '$full' WHERE id = '$id'";
  $db->query($fullSql);
  header('Location: index.php');
}
 ?>

 <!-- list for viewing all available classes -->
 <hr>
 <div class="container">
<h3 class="text-center">Yoga Classes</h3>
<a href="index.php?add=1" class="btn btn-danger pull-right" id="add-product-btn">Add Class</a><div class="clearfix"></div>
<hr>
<table class="table table-bordered table-condensed table-striped">
  <thead><th></th><th>Date & Time</th><th>Duration</th><th>Style</th><th>Instructor</th><th>Description</th><th>Enrolled Students<th>Mark as Full</th></thead>
  <tbody>
    <?php while($course = mysqli_fetch_assoc($presults)):

      ?>
      <tr>
        <td align="center">
          <a href="index.php?edit=<?=$course['id'];?>" class="btn btn-xs btn-default"><span class="glyphicon glyphicon-edit"></span></a>
          <a href="index.php?delete=<?=$course['id'];?>" class="btn btn-xs btn-default"><span class="glyphicon glyphicon-remove"></span></a>

        </td>
        <td><?=pretty_date($course['class_date'])?></td>
        <td><?=$course['duration'];?></td>
        <td><?=$course['style'];?></td>
        <td><?=$course['instructor'];?></td>
        <td><?=$course['description'];?></td>
        <td><a href="index.php?enrolled=<?=$course['id'];?>" class="btn btn-xs btn-default">View Enrolled Students</a></td>
        <td><a href="index.php?full=<?=(($course['full'] == 0)?'1':'0');?>&id=<?=$course['id'];?>" class="btn btn-xs btn-default">
          <span class="glyphicon glyphicon-<?=(($course['full']==1)?'minus':'plus');?>"></span>
        </a>&nbsp <?=(($course['full'] == 1)?'Class Full':'');?></td>
      </tr>
    <?php endwhile; ?>
  </tbody>
</table>
</div>


<?php
}
include 'includes/footer.php';
?>
