<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') 
{
  // Check if we got the field from the user
  if (isset($_POST['username'])) {
      $user = $_POST['username'];
    //   echo($user);
    //address of the server where db is installed
    $servername = "localhost";
    //username to connect to the db
    //the default value is root
    $username = "vihung169";
    //password to connect to the db
    //this is the value you would have specified during installation of WAMP stack
    $password = "Hunghung169@";
    //name of the db under which the table is created
    $dbName = "iotsforhuman";
    //establishing the connection to the db.
    $conn = new mysqli($servername, $username, $password, $dbName);
    //checking if there were any error during the last connection attempt
    if ($conn->connect_error) {
      die("Connection failed: " . $conn->connect_error);
    }
    //the SQL query to be executed
    $query = "SELECT username,tds,curngay,curgio FROM weather WHERE username='$user' AND DATE_SUB(DATE_ADD(NOW(), INTERVAL 14 HOUR),INTERVAL 01 DAY) <= curngay";
    //storing the result of the executed query
    $result = $conn->query($query);
    //initialize the array to store the processed data
    $jsonArray = array();
    //check if there is any data returned by the SQL Query
    if ($result->num_rows > 0) {
      //Converting the results into an associative array
      while($row = $result->fetch_assoc()) {
        $jsonArrayItem = array();
        // $jsonArrayItem['username'] = $row['username'];
        $jsonArrayItem['tds'] = $row['tds'];
        $jsonArrayItem['curngay'] = $row['curngay'];
        $jsonArrayItem['curgio'] = $row['curgio'];
        //append the above created object into the main array.
        array_push($jsonArray, $jsonArrayItem);
      }
    }
    //Closing the connection to DB
    $conn->close();
    //set the response content type as JSON
    header('Content-type: application/json');
    //output the return value of json encode using the echo function.
    echo json_encode($jsonArray);
  }
}
?>