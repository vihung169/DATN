<?php
$servername = "localhost";
$username = "vihung169";
$password = "Hunghung169@";
$dbname = "iotsforhuman";

header('content-type: application/json; charset=utf-8');
header("access-control-allow-origin: *");

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    // Check if we got the field from the user
    if (isset($_GET['username']) && isset($_GET['maybom']))
    {
        $user = $_GET['username'];
        $maybom = (int)$_GET['maybom'];

        $recordDB = "UPDATE `status` SET `maybom`= $maybom WHERE `username`='$user'";

        $connect = new mysqli($servername, $username, $password, $dbname);

        if ($connect->connect_error) {
            die("Connect Failed:" . $connect->connect_error);
        }
        if ($connect->query($recordDB) === TRUE) {
            // echo "New record creater successfully";
        } else {
            echo ("Error!!");
        }
        }
    }
?>