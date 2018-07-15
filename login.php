<?php
/* User login process, checks if user exists and password is correct */

// Escape email to protect against SQL injections
session_start();

require_once 'include/db.php';

$stmt = $con->prepare("SELECT * FROM `login` WHERE `username` = ?");
$stmt->bind_param("s", $username);
$username = $_POST['username'];
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows == 0) 
{ // User doesn't exist
    $_SESSION['message'] = "Username doesn't exist!";
    $_SESSION['type'] = 'danger';
    header('Location: ./index.php');
} 
else
{   // User exists 
    $row = $result->fetch_assoc();

    if (password_verify($_POST['password'], $row['password'])) 
    {
        
        if($row['user_status'])
        {
            $_SESSION['username'] = $row['username'];
            $_SESSION['name'] = $row['name'];
            if($_SESSION['username'] == 'admin')
            {
                $_SESSION['logged_in'] = true;
                header("location: ./admin.php");
                exit();
            }

            $_SESSION['logged_in'] = true;      // This is how we'll know the user is logged in
            header("location: ./af_log.php");
        }
        else
        {
            $_SESSION['message'] = "Your account is not active. Please contact administrator!";
            $_SESSION['type'] = 'danger';
            header('Location: ./index.php');
        }
        
    } 
    else 
    {
        $_SESSION['message'] = "Incorrect password!";
        $_SESSION['type'] = 'danger';
        header('Location: ./index.php');
    }
}