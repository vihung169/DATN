<?php
    $servername = "localhost";
    $username = "vihung169";
    $password = "Hunghung169@";
    $dbname = "iotsforhuman";
    $connect = mysqli_connect($servername, $username, $password,$dbname);
  
    header('content-type: application/json; charset=utf-8');
    header("access-control-allow-origin: *");
    //Creating Array for JSON response  
    $sql = "SELECT * FROM weather";
    $result = mysqli_query($connect, $sql) or die(mysqli_error($connect));
    if (mysqli_num_rows($result) > 0) {
        
        // Storing the returned array in response
        $response = array();
        // While loop to store all the returned response in variable
        while ($row = mysqli_fetch_array($result)) {
            // temperoary user array
            $weather = array();
            $weather["id"] = $row["id"];
            $weather["username"] = $row["username"];
            $weather["temp"] = $row["temp"];
            $weather["humi"] = $row["humi"];
            $weather["lux"] = $row["lux"];
            $weather["ph"] = $row["ph"];
            $weather["ec"] = $row["ec"];
            $weather["curngay"] = $row["curngay"];
            $weather["curgio"] = $row["curgio"];

            // Push all the items 
            array_push($response, $weather);
        }
        // Show JSON response
        echo json_encode($response);
    }
    else 
    {
        // If no data is found
        $response["success"] = 0;
        $response["message"] = "No data on weather found";
    
        // Show JSON response
        echo json_encode($response);
    }	
?>