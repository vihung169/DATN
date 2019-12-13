<?php
$servername = "localhost";
$username = "vihung169";
$password = "Hunghung169@";
$dbname = "iotsforhuman";

header('content-type: application/json; charset=utf-8');
header("access-control-allow-origin: *");

if ($_SERVER['REQUEST_METHOD'] === 'GET') 
{
    // Check if we got the field from the user
    if (isset($_GET['username']) && isset($_GET['temp'])&& isset($_GET['humi'])&& isset($_GET['lux'])&& isset($_GET['ph'])&& isset($_GET['tds']))
    {
        $user = $_GET['username'];
        $temp = (float)$_GET['temp'];
        $humi = (float)$_GET['humi'];
        $lux  = (float)$_GET['lux'];
        $ph   = (float)$_GET['ph'];
        $tds   = (int)$_GET['tds'];
        // echo "New recordy";
        $recordDB = "INSERT INTO `weather` (`username`,`temp`, `humi`, `lux`, `ph`, `tds`,`curngay`,`curgio`)
                    VALUES ('$user','$temp','$humi','$lux','$ph','$tds',DATE_ADD(NOW(), INTERVAL 14 HOUR),DATE_ADD(NOW(), INTERVAL 14 HOUR))";
                    
        $connect = new mysqli($servername,$username,$password,$dbname);
        
        if( $connect->connect_error)
        {
            die("Connect Failed:".$connect->connect_error);
        }
        if($connect->query($recordDB)===TRUE)
        {
            echo "New record creater successfully";
        }
        else
        {
        echo("Error!!");
        }
        
    }
}
?>