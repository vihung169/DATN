<?php
session_start(); // Starting Session
$error = ''; // Variable To Store Error Message
if (isset($_POST['submit'])) {
    if (empty($_POST['username']) || empty($_POST['password'])) {
        $error = "Username or Password is invalid";
    } 
    else {
            // Define $username and $password
            $username = $_POST['username'];
            $password = $_POST['password'];
            // Define svr
            $svrname = "localhost";
            $user = "vihung169";
            $pass = "Hunghung169@";
            $db = "iotsforhuman";
            // Establishing Connection with Server by passing server_name, user_id and password as a parameter
            $connection = new mysqli($svrname,$user,$pass,$db);
            // To protect MySQL injection for Security purpose
            // $username = stripslashes($username);
            // $password = stripslashes($password);
            // $username = mysql_real_escape_string($username);
            // $password = mysql_real_escape_string($password);
            $sql = "SELECT * FROM user WHERE pass = '$password' AND username='$username';";
            $result = $connection->query($sql);
            if($result->num_rows == 1)
            {
                $_SESSION['username'] = $username; // Initializing Session
                $_SESSION['password'] = $password; // Initializing Session
                header("location: dashboard.php"); // Redirecting To Other Page
            } else {
                echo "Username or Password is invalid";
            }
            $connection->close(); // Closing Connection
        }
}
