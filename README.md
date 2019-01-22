# Yoga Classes
A yoga class booking web application

## Steps to run web application:

### Step 1: 
Run <b>databaseInstaller.php</b>, and it should automatically create the database for you and add the records.

### Step 2:
Open <b>yoga/index.php</b>, and you will see the list of available classes and will be given the option to fill a form to book for the classes which still have available space.

### Step 3:
You can login to the backend by either clicking the "Admin Login" button on the navigation bar or opening <b>yoga/admin/login.php</b>. You will be asked for login information; enter <b>test@test.com</b> for the email, and <b>123456</b> for the password and login.

## Admin features

In the backend, the admin can view all the classes including the past ones. You have the ability to add, edit, delete classes. The admin also has the ability to view the enrolled students in the classes and mark the class as full if needed. 

There are two types of user admins; <b>admin</b>, and <b>editor</b>. The <b>admin</b> has the ability to add other users to the backend and give access to more instructors, while the <b>editor</b> only has the ability to manage classes. 
