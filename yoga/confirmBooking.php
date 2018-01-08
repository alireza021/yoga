<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/yoga/core/init.php';
    include 'includes/head.php';
    include 'includes/navigation.php';

//once students finish booking for a class, they are redirected here to get confirmation and see their class information
if (isset($_GET['book'])) {
    $book_id = (int)$_GET['book'];
}
    $sql = "SELECT * FROM course WHERE id = $book_id";
    $presults = $db->query($sql);
    while($course = mysqli_fetch_assoc($presults)):
      ?>
    <div class="container">
      <hr>
      <h1 class="text-center">Thank you!</h1>
      <p>Your booking has been confirmed!</p>
      <p>Please be at the yoga studio on <strong><?=pretty_date($course['class_date'])?></strong>.</p>
      <p>Your instructor for this class is <strong><?=$course['instructor']?></strong>, and the yoga style is <strong><?=$course['style']?></strong>.</p>

      <br>
      <p>In case you can't make it to the class, please try contacting us atleast a day in advance so we can keep your place open for other students.</p>
      <br>
   </div>

  <?php
  endwhile;
  include 'includes/footer.php';
?>
