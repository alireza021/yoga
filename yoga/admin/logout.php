<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/yoga/core/init.php';
//remove loged-in session when logging out
unset($_SESSION['SBUser']);
header('Location: login.php');
?>
