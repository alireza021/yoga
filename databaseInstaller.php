<?php
$connect = mysqli_connect("localhost", "root", "") or die ("check your server connection.");

mysqli_query($connect,"DROP DATABASE yoga");

mysqli_query($connect,"CREATE DATABASE yoga");

mysqli_select_db($connect,"yoga");

$course="CREATE TABLE course (
id int(11) NOT NULL auto_increment,
duration varchar(255) NOT NULL,
style varchar(255) NOT NULL,
instructor varchar(255) NOT NULL,
deleted tinyint(4) NOT NULL default '0',
full tinyint(4) NOT NULL default '0',
description varchar(255) NOT NULL,
class_date datetime NOT NULL,
PRIMARY KEY (id)
)Engine=InnoDB AUTO_INCREMENT=1 ";

$students="CREATE TABLE students (
id int(11) NOT NULL auto_increment,
full_name varchar(255) NOT NULL,
email varchar(255) NOT NULL,
telephone text NOT NULL,
gender varchar(255) NOT NULL,
course_id int(11) NOT NULL,
PRIMARY KEY (id)
)Engine=InnoDB AUTO_INCREMENT=1 ";

$users="CREATE TABLE users (
id int(11) NOT NULL auto_increment,
full_name varchar(255) NOT NULL,
email varchar(255) NOT NULL,
password varchar(255) NOT NULL,
join_date datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
last_login datetime NOT NULL,
permissions varchar(255) NOT NULL,
PRIMARY KEY (id)
)Engine=InnoDB AUTO_INCREMENT=1 ";


$results = mysqli_query($connect, $course) or die (mysql_error());
$results = mysqli_query($connect, $students) or die (mysql_error());
$results = mysqli_query($connect, $users) or die (mysql_error());


$conn = new mysqli("localhost", "root", "","yoga");
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "INSERT INTO course (duration, style, instructor, description, class_date)
VALUES ('90 Minutes', 'Hot Yoga', 'Emannuel', 'Please bring your own mats', '2018-03-03 14:00:00');";
$sql.= "INSERT INTO course (duration, style, instructor, description, class_date)
VALUES ('60 Minutes', 'Cold Yoga', 'Marco', 'Get ready to sweat!', '2018-03-04 13:00:00');";
$sql.= "INSERT INTO course (duration, style, instructor, full, description, class_date)
VALUES ('90 Minutes', 'Japanese Yoga', 'Michael','1', 'Please bring your own mats', '2018-03-13 14:00:00');";
$sql.= "INSERT INTO course (duration, style, instructor, full, description, class_date)
VALUES ('60 Minutes', 'Hatha Yoga', 'Natalie', '1', 'Relaxing session', '2018-03-13 17:00:00');";
$sql.= "INSERT INTO course (duration, style, instructor, description, class_date)
VALUES ('60 Minutes', 'Vinyasa Yoga', 'Sara', 'Looking forward to seeing you all!', '2018-03-17 12:00:00');";
$sql.= "INSERT INTO users (full_name, email, password, permissions)
VALUES ('Alireza Shafiei', 'alireza.021@hotmail.com', '$2y$10\$ORrDKE3zZd8m15nlRNA94.sRQd0ThOiyOaZFuRkRoDoYrifc5AgYG', 'admin,editor');";
$sql.= "INSERT INTO users (full_name, email, password, permissions)
VALUES ('David Petryca', 'test@test.com', '$2y$10\$IbPJN5qgKEgNXgOiIj81JOEF/35F.hYhoW.f68M6yZ6IKtysKkD.K', 'admin,editor');";
$sql.= "INSERT INTO students (full_name, email, telephone, gender, course_id)
VALUES ('Ema Rylie', 'ema.rylie@gmail.com', '+4202387263', 'Female', '1');";
$sql.= "INSERT INTO students (full_name, email, telephone, gender, course_id)
VALUES ('Michael Philips', 'mich1289@hotmail.com', '+420392844', 'Male', '1');";
$sql.= "INSERT INTO students (full_name, email, telephone, gender, course_id)
VALUES ('Sara Rules', 'sara.r@hotmail.com', '+97150323424', 'Female', '1');";
$sql.= "INSERT INTO students (full_name, email, telephone, gender, course_id)
VALUES ('Dave Rylie', 'davefire@gmail.com', '+4202332333', 'Male', '2');";
$sql.= "INSERT INTO students (full_name, email, telephone, gender, course_id)
VALUES ('Blue Keens', 'blue@hotmail.com', '+420399999', 'Female', '2');";
$sql.= "INSERT INTO students (full_name, email, telephone, gender, course_id)
VALUES ('Sara Saab', 'sara.s@hotmail.com', '+9715032334', 'Female', '2');";
$sql.= "INSERT INTO students (full_name, email, telephone, gender, course_id)
VALUES ('Dave Philps', 'davefire2@gmail.com', '+4202332333', 'Male', '3');";
$sql.= "INSERT INTO students (full_name, email, telephone, gender, course_id)
VALUES ('Ava Dople', 'ava.dd@hotmail.com', '+420393221', 'Female', '3');";
$sql.= "INSERT INTO students (full_name, email, telephone, gender, course_id)
VALUES ('Maria Khateeb', 'mariamk@hotmail.com', '+9715032221', 'Female', '3');";
$sql.= "INSERT INTO students (full_name, email, telephone, gender, course_id)
VALUES ('Marco Ryan', 'mkryan@gmail.com', '+420292762', 'Male', '4');";
$sql.= "INSERT INTO students (full_name, email, telephone, gender, course_id)
VALUES ('Yasmin Zeit', 'ysalzeit@hotmail.com', '+4202891392', 'Female', '4');";
$sql.= "INSERT INTO students (full_name, email, telephone, gender, course_id)
VALUES ('Carmella Smeir', 'c.smeir@hotmail.com', '+973333255', 'Female', '4');";
$sql.= "INSERT INTO students (full_name, email, telephone, gender, course_id)
VALUES ('Ali Riazi', 'ali_riazi@gmail.com', '+42029232322', 'Male', '5');";
$sql.= "INSERT INTO students (full_name, email, telephone, gender, course_id)
VALUES ('Ahmad Safwan', 'fireinthebooth@hotmail.com', '+4202891392', 'Male', '5');";
$sql.= "INSERT INTO students (full_name, email, telephone, gender, course_id)
VALUES ('Kol Khara', 'k.khara@hotmail.com', '+9733232222', 'Female', '5')";



if (mysqli_multi_query($conn, $sql)) {
    echo "New records added";
} else {
    echo "Error: " . $sql . "<br>" . mysqli_error($conn);
}

echo " & database successfully created!";
mysqli_close($conn);

?>
<html>
<head>
<link rel="stylesheet" type="text/css" href="style.css" />
</head>
<body>
<div id="div1"></div>
</body>
</html>
