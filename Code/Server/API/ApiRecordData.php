<?php
$servername = "localhost";
$username = "vihung169";
$password = "Hunghung169@";
$dbname = "iotsforhuman";

header('content-type: application/json; charset=utf-8');
header("access-control-allow-origin: *");

if ($_SERVER['REQUEST_METHOD'] === 'POST') 
{
    // Check if we got the field from the user
    if (isset($_POST['username']) && isset($_POST['temp'])&& isset($_POST['humi'])&& isset($_POST['lux'])&& isset($_POST['ph'])&& isset($_POST['tds']))
    {
        $user = $_POST['username'];
        $temp = (float)$_POST['temp'];
        $humi = (float)$_POST['humi'];
        $lux  = (float)$_POST['lux'];
        $ph   = (float)$_POST['ph'];
        $tds   = (int)$_POST['tds'];
   
        $recordDB = "INSERT INTO `weather` (`username`,`temp`, `humi`, `lux`, `ph`, `tds`,`curngay`,`curgio`)
                    VALUES ('$user','$temp','$humi','$lux','$ph','$tds',DATE_ADD(NOW(), INTERVAL 14 HOUR),DATE_ADD(NOW(), INTERVAL 14 HOUR))";
                    
        $connect = new mysqli($servername,$username,$password,$dbname);
        
        if( $connect->connect_error)
        {
            die("Connect Failed:".$connect->connect_error);
        }
        if($connect->query($recordDB)===TRUE)
        {
            // echo "New record creater successfully";
        }
        else
        {
        echo("Error!!");
        }
        
        //--------------------------------------------------------------------------------------------------//
        //  Xu ly du lieu //
        
        $selectDbcaytrong = "SELECT * FROM dbcaytrong WHERE tencay='xalach'";
        $connectDbCaytrong = $connect->query($selectDbcaytrong);
        if ($connectDbCaytrong->num_rows > 0) {
           // echo(" vao db cay trong");
            // Storing the returned array in response
            $response = array();
            // While loop to store all the returned response in variable
            $row = $connectDbCaytrong->fetch_assoc();
                // temperoary user array
                
                $id = $row["id"];
                $tencay = $row["tencay"];
                $tempMax = (float)$row["tempmax"];
                $tempMin = (float)$row["tempmin"];
                $phMax = (float)$row["phmax"];
                $phMin = (float)$row["phmin"];
                $tdsMax = (int)$row["tdsmax"];
                $tdsMin = (int)$row["tdsmin"];
                $lighttime = (int)$row["lighttime"];
            }
            //echo($phmin);
           // echo("nhiet do:".$temp."\n");
           // echo("nhiet do max:".$tempMax."\n");
            // Kiem tra nhiet do cao hon muc song cua cay thi dieu khien quat
                if($temp >= $tempMax)
                {
                    
                  $connect1 = new mysqli($servername,$username,$password,$dbname);
                  $updateControl1 ="UPDATE `status` SET `username`='$user',`quat`= 1,`phunsuong`=1";
                  $connect1->query($updateControl1);
                  
                  $ketnoidbthongbao = new mysqli($servername,$username,$password,$dbname);
                  mysqli_set_charset($ketnoidbthongbao,'utf8');
                  $thongbao="INSERT INTO `thongbao`(`username`, `tieude`, `noidung`, `curngay`, `curgio`) VALUES ('$user','NHIỆT ĐỘ','Hệ thống đã TỰ ĐỘNG bật Quạt khi nhiệt độ vườn $temp °C',DATE_ADD(NOW(), INTERVAL 14 HOUR),DATE_ADD(NOW(), INTERVAL 14 HOUR))";
                  $ketnoidbthongbao->query($thongbao);
                }
            // Kiem tra nhiet do thap hon 
                if($temp < $tempMax){
                  $connect2 = new mysqli($servername,$username,$password,$dbname);
                  $updateControl2 ="UPDATE `status` SET `username`='$user',`quat`= 0,`phunsuong`=0";
                  $connect2->query($updateControl2); 
                  
                  
                }
                // kiem tra nong do Tds trong bon nuoc.
                // neu > muc quy dinh thi thong bao
                if($tds > $tdsMax){
                    //echo("thong bao tds lon hon muc quy dinh\n");
                  $ketnoidbthongbao = new mysqli($servername,$username,$password,$dbname);
                  mysqli_set_charset($ketnoidbthongbao,'utf8');
                  $thongbao="INSERT INTO `thongbao`(`username`, `tieude`, `noidung`, `curngay`, `curgio`) VALUES ('$user','Nồng độ TDS','TDS: $tds trên mức quy định. Vui lòng pha thêm NƯỚC vào Bồn',DATE_ADD(NOW(), INTERVAL 14 HOUR),DATE_ADD(NOW(), INTERVAL 14 HOUR))";
                  $ketnoidbthongbao->query($thongbao);
                }
                // neu < thi thong bao
                if($tds<$tdsMin){
                    //echo("thong bao tds nho hon muc quy dinh\n");
                  $ketnoidbthongbao = new mysqli($servername,$username,$password,$dbname);
                  mysqli_set_charset($ketnoidbthongbao,'utf8');
                  $thongbao="INSERT INTO `thongbao`(`username`, `tieude`, `noidung`, `curngay`, `curgio`) VALUES ('$user','Nồng độ TDS','TDS: $tds dưới mức quy định. Vui lòng pha thêm dinh dưỡng vào Bồn',DATE_ADD(NOW(), INTERVAL 14 HOUR),DATE_ADD(NOW(), INTERVAL 14 HOUR))";
                  $ketnoidbthongbao->query($thongbao);
                }
                //-------------------------------------------------------//
                // kiem tra nong do pH trong bon nuoc.
                // neu > muc quy dinh thi thong bao
                
                if($ph > $phMax){
                   // echo("thong bao pH lon hon muc quy dinh\n");
                  $ketnoidbthongbao = new mysqli($servername,$username,$password,$dbname);
                  mysqli_set_charset($ketnoidbthongbao,'utf8');
                  $thongbao="INSERT INTO `thongbao`(`username`, `tieude`, `noidung`, `curngay`, `curgio`) VALUES ('$user','Nồng độ pH','pH: $ph trên mức quy định. Vui lòng điều chỉnh',DATE_ADD(NOW(), INTERVAL 14 HOUR),DATE_ADD(NOW(), INTERVAL 14 HOUR))";
                  $ketnoidbthongbao->query($thongbao);
                }
                // neu < thi thong bao
                if($ph < $phMin){
                    //echo("thong bao pH nho hon muc quy dinh\n");
                    $ketnoidbthongbao = new mysqli($servername,$username,$password,$dbname);
                  mysqli_set_charset($ketnoidbthongbao,'utf8');
                  $thongbao="INSERT INTO `thongbao`(`username`, `tieude`, `noidung`, `curngay`, `curgio`) VALUES ('$user','Nồng độ pH','pH: $ph dưới mức quy định. Vui lòng điều chỉnh',DATE_ADD(NOW(), INTERVAL 14 HOUR),DATE_ADD(NOW(), INTERVAL 14 HOUR))";
                  $ketnoidbthongbao->query($thongbao);
                }
                
        }
        //--------------------------------------------------------------------------------------------------//
        //  truy xuat cau lenh dieu khien va truyen lenh ve Gateway //
        
            //Creating Array for JSON response  
        $sql = "SELECT * FROM status";
        $kn = $connect->query($sql);
        
        if ($kn->num_rows > 0) {
            
            // Storing the returned array in response
            $response = array();
            // While loop to store all the returned response in variable
            while ($row = $kn->fetch_assoc()) {
                // temperoary user array
                $status = array();
                // $status["id"] = $row["id"];
                $status["username"] = $row["username"];
                $status["maybom"] = $row["maybom"];
                $status["phunsuong"] = $row["phunsuong"];
                $status["den"] = $row["den"];
                $status["quat"] = $row["quat"];
                // Push all the items 
                array_push($response, $status);
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
        
    }
?>