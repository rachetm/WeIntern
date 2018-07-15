<?php
/* Registration process, inserts user info into the database
and sends account confirmation email message
 */

//Random salt generator
function unique_salt()
{
    return substr(sha1(mt_rand()), 0, 22);
}

session_start();

require_once 'include/db.php';
include 'include/sendmailbasic.php';

// Check if user with that email already exists

$stmt = $con->prepare("SELECT * FROM `login` WHERE `email` = ?");
$stmt->bind_param("s", $email);
$email = $_POST['email'];
$stmt->execute();
$result = $stmt->get_result();

// We know email exists if the rows returned are more than 0
if ($result->num_rows > 0) {
    $_SESSION['message'] = "User with this email already exists!";
    $_SESSION['type'] = "danger";
    header("Location: ./admin.php");
    die();
}

// Check if user with that username already exists

$stmt = $con->prepare("SELECT * FROM `login` WHERE `username` = ?");
$stmt->bind_param("s", $username);
$username = $_POST['username'];
$stmt->execute();
$result = $stmt->get_result();

// We know  username exists if the rows returned are more than 0
if (mysqli_num_rows($result) > 0) 
{
    $_SESSION['message'] = "User with this username already exists!";
    $_SESSION['type'] = "danger";
    header("Location: ./admin.php");
}
else
{
    // username doesn't already exist in a database, proceed..
    if ($_SERVER['REQUEST_METHOD'] == 'POST') 
    {
        if ($_POST['newpassword'] == $_POST['confirmpassword']) 
        {
            $stmt = $con->prepare("INSERT INTO `login` VALUES (?, ?, ?, ?, ?, ?,1)");
            $stmt->bind_param("sssssi", $username, $name, $email, $password, $hash, $status);
            $username = $_POST['username'];
            $name = $_POST['name'];
            $password = $_POST['newpassword'];
            $email = $_POST['email'];
            //Use Bycrypt method to one way encrypt the password before storing in database
            $password = password_hash($password, PASSWORD_BCRYPT);
            $hash = password_hash(unique_salt(), PASSWORD_BCRYPT);
            $status = 0;

            // Add user to the database
            if ($stmt->execute()) 
            {
                // Send registration confirmation link
                $to = $email;
                $subject = 'Login Details [WeIntern]';
                $message_body = '
                Hello ' . $name .','.'

                Please login using the following details and change your password accordingly

                USERNAME:'.$username.'
                PASSWORD:'.$_POST['newpassword'].'
                LOGIN HERE: localhost/WeIntern/';

                
                email_std($to, $subject, $message_body);
                $_SESSION['message'] = "User added successfully";
                $_SESSION['type'] = "success";
                header("Location: ./admin.php");
            } 
            else 
            {
                $_SESSION['message'] = "Registration failed! Try again!";
                $_SESSION['type'] = "danger";
                header("Location: ./admin.php");
            }
        }
        else 
        {
            $_SESSION['message'] = "Passwords do not match!";
            $_SESSION['type'] = 'danger';
            header("Location: ./admin.php");
        }
    }
}      