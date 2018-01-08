<?php
$connect = mysql_connect("localhost", "root", "") or die ("check your server connection.");

mysql_query("DROP DATABASE yoga");

mysql_query("CREATE DATABASE yoga");

mysql_select_db("yoga");

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


$results = mysql_query($course) or die (mysql_error());
$results = mysql_query($students) or die (mysql_error());
$results = mysql_query($users) or die (mysql_error());


$conn = new mysqli("localhost", "root", "","yoga");
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "INSERT INTO course (duration, style, instructor, description, class_date)
VALUES ('90 Minutes', 'Hot Yoga', 'Emannuel', 'Please bring your own mats', '2018-03-03 14:00:00');";
$sql.= "INSERT INTO course (duration, style, instructor, description, class_date)
VALUES ('60 Minutes', 'Cold Yoga', 'Marco', 'Get ready to sweat!', '2018-03-04 13:00:00');";
$sql.= "INSERT INTO course (duration, style, instructor, description, class_date)
VALUES ('90 Minutes', 'Japanese Yoga', 'Michael', 'Please bring your own mats', '2018-03-13 14:00:00');";
$sql.= "INSERT INTO course (duration, style, instructor, description, class_date)
VALUES ('60 Minutes', 'Hatha Yoga', 'Natalie', 'Relaxing session', '2018-03-13 17:00:00');";
$sql.= "INSERT INTO course (duration, style, instructor, description, class_date)
VALUES ('60 Minutes', 'Vinyasa Yoga', 'Sara', 'Looking forward to seeing you all!', '2018-03-17 12:00:00');";
$sql.= "INSERT INTO users (full_name, email, password, permissions)
VALUES ('Alireza Shafiei', 'alireza.021@hotmail.com', '$2y$10\$ORrDKE3zZd8m15nlRNA94.sRQd0ThOiyOaZFuRkRoDoYrifc5AgYG', 'admin,editor');";
$sql.= "INSERT INTO users (full_name, email, password, permissions)
VALUES ('David Petryca', 'david.p@praguecollege.cz', '$2y$10\$IbPJN5qgKEgNXgOiIj81JOEF/35F.hYhoW.f68M6yZ6IKtysKkD.K', 'admin,editor')";


if (mysqli_multi_query($conn, $sql)) {
    echo "New records added successfully";
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
