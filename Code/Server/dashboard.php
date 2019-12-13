<?php
session_start();
$username = $_SESSION['username'];
$password = $_SESSION['password'];


$svrname = "localhost";
$user = "vihung169";
$pass = "Hunghung169@";
$db = "iotsforhuman";

$connection = new mysqli($svrname, $user, $pass, $db);
// them vao de hien thi tieng viet
mysqli_set_charset($connection,'utf8');
$sql = "SELECT * FROM weather WHERE id=(SELECT max(id) FROM weather WHERE username='$username')";
//them set name vao hien thi tieng viet
$result = $connection->query($sql);
if ($result->num_rows > 0) {
    // output data of each row
    $row = $result->fetch_assoc();
    // echo ("id: " . $row["username"] . "-" . $row["temp"] . "- " . $row["humi"] . "- " . $row["lux"] ."- " . $row["ph"] . "- " . $row["ec"] ."<br>");

}
$st = "SELECT * FROM `status` WHERE id=(SELECT max(id) FROM status WHERE username='$username')";
$result2 = $connection->query($st);
if ($result2->num_rows > 0) {
    // output data of each row
    $row1 = $result2->fetch_assoc();
    // echo (" " . $row1["username"] . "-" . $row1["maybom"] . "- " . $row1["phunsuong"] . "<br>");

}
?>
<!DOCTYPE html>
<html>

<head>
    <!--hien thi tieng viet-->
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <!--<meta charset="utf-8">-->
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>LoRaFarm</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="all,follow">
    <!-- Bootstrap CSS-->
    <link rel="stylesheet" href="vendor/bootstrap/css/bootstrap.min.css">
    <!-- Font Awesome CSS-->
    <!-- <link rel="stylesheet" href="vendor/font-awesome/css/font-awesome.min.css"> -->
    <!-- Fontastic Custom icon font-->
    <link rel="stylesheet" href="css/fontastic.css">
    <!-- Google fonts - Roboto -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700">
    <!-- jQuery Circle-->
    <link rel="stylesheet" href="css/grasp_mobile_progress_circle-1.0.0.min.css">
    <!-- Custom Scrollbar-->
    <link rel="stylesheet" href="vendor/malihu-custom-scrollbar-plugin/jquery.mCustomScrollbar.css">
    <!-- theme stylesheet-->
    <link rel="stylesheet" href="css/style.default.css" id="theme-stylesheet">
    <!-- Custom stylesheet - for your changes-->
    <link rel="stylesheet" href="css/custom.css">
    <!-- Favicon-->
    <link rel="shortcut icon" href="img/logoicon.ico">
    <!-- Tweaks for older IEs-->
    <!-- icon -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel='stylesheet' href='https://use.fontawesome.com/releases/v5.7.0/css/all.css' integrity='sha384-lZN37f5QGtY3VHgisS14W3ExzMWZxybE1SJSEsQp9S+oqd12jhcu+A56Ebc1zFSJ' crossorigin='anonymous'>
    <!--[if lt IE 9]>
        <!-- <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script><![endif]--> -->
</head>

<body>
    <!-- Side Navbar -->
    <nav class="side-navbar">
        <div class="side-navbar-wrapper">
            <!-- Sidebar Header    -->
            <div class="sidenav-header d-flex align-items-center justify-content-center">
                <!-- Logo -->
                <div class="sidenav-header-inner text-center"><img src="img/logo.png" alt="person" class="img-fluid">
                    <!-- User Info-->
                    <h2 class="h5"><?php echo $username; ?></h2><span>Address: <?php echo $row["address"]; ?></span>
                </div>
                <!-- Small Brand information, appears on minimized sidebar-->
                <div class="sidenav-header-logo"><a href="dashboard.php" class="brand-small text-center"> <strong>L</strong><strong class="text-primary">F</strong></a></div>
            </div>
            <!-- Sidebar Navigation Menus-->
            <div class="main-menu">
                <h5 class="sidenav-heading">Thông tin</h5>
                <ul id="side-main-menu" class="side-menu list-unstyled">
                    <li><a href="dashboard.php"> <i class="fas fa-server"></i>Quản lý hệ thống </a></li>
                    <!-- <li><a href="forms.html"> <i class="icon-form"></i>Forms </a></li> -->
                    <li><a href="charts.php"> <i class="fa fa-bar-chart"></i>Biểu đồ</a></li>
                    <li><a href="caytrong.php"> <i class="icon-grid"></i>Tình hình cây trồng</a></li>
                    <li><a href="#exampledropdownDropdown" aria-expanded="false" data-toggle="collapse"> <i class="icon-interface-windows"></i>Bảng dữ liệu</a>
                        <ul id="exampledropdownDropdown" class="collapse list-unstyled ">
                            <li><a href="dataday.php">Bảng dữ liệu theo ngày</a></li>
                            <li><a href="datamonth.php">Bảng dữ liệu theo tuần</a></li>
                        </ul>
                    </li>
                    <!-- <li><a href="login.php"> <i class="far fa-user"></i>Đăng nhập</a></li> -->
                </ul>
            </div>
            <div class="admin-menu">
                <h5 class="sidenav-heading">Hệ thống LoRaFarm</h5>
                <ul id="side-admin-menu" class="side-menu list-unstyled">
                    <li> <a href="hardware.php"> <i class="fas fa-microchip"> </i>Phần cứng</a></li>
                    <li> <a href="software.php"> <i class="fas fa-desktop"> </i>Phần mềm</a></li>
                </ul>
            </div>
        </div>
    </nav>
    <div class="page">
        <!-- navbar-->
        <header class="header">
            <nav class="navbar">
                <div class="container-fluid">
                    <div class="navbar-holder d-flex align-items-center justify-content-between">
                        <div class="navbar-header"><a id="toggle-btn" href="#" class="menu-btn"><i class="icon-bars"> </i></a><a href="index.php" class="navbar-brand">
                                <div class="brand-text d-none d-md-inline-block"><strong class="text-primary">Lorafarm</strong></div>
                            </a></div>
                        <!-- Log out-->
                        <li class="nav-item"><a href="logout.php" class="nav-link logout">
                                ĐĂNG XUẤT<i class="far fa-caret-square-right"></i></a></li>
                        </ul>
                    </div>
                </div>
            </nav>
        </header>
        <!-- Counts Section -->
        <section class="statistics section-padding">
            <div class="container-fluid">
                <div class="row d-flex">
                    <div class="col-lg-4">
                        <!-- Income-->
                        <div class="card income text-center">
                            <div class="icon "><i class='fas fa-temperature-high' style='font-size:48px;color:#212529;'></i></div>
                            <div class="text" style="font-size:30px;color:black">Nhiệt độ</div>
                            <p>Ngày: <?php echo ($row['curngay']); ?></p>
                            <p>Giờ: <?php echo ($row['curgio']); ?></p>
                            <div class="number" style='font-size:36px;color:#33b35a'><?php echo ($row["temp"] . "°C"); ?></div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="card income text-center">
                            <div class="icon"><i class='fas fa-tint' style='font-size:48px;color:#212529;'></i></i> </div>
                            <div class="text" style="font-size:30px;color:black">Độ ẩm</div>
                            <p>Ngày: <?php echo ($row['curngay']); ?></p>
                            <p>Giờ: <?php echo ($row['curgio']); ?></p>
                            <div class="number" style='font-size:36px;color:#33b35a'><?php echo ($row["humi"] . "%"); ?></div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <!-- User Actibity-->
                        <div class="card income text-center">
                            <div class="icon"><i class='fas fa-cloud-sun' style='font-size:48px;color:#212529;'></i></i> </div>
                            <div class="text" style="font-size:30px;color:black">Cường độ ánh sáng</div>
                            <p>Ngày: <?php echo ($row['curngay']); ?></p>
                            <p>Giờ: <?php echo ($row['curgio']); ?></p>
                            <div class="number" style='font-size:36px;color:#33b35a'><?php echo ($row["lux"] . " lux"); ?></div>
                        </div>
                    </div>
                </div>
                <hr>
                <div class="row d-flex">
                    <div class="col-lg-4">
                        <!-- Income-->
                        <div class="card income text-center">
                            <div class="icon"><i class='icon-flask' style='font-size:48px;color:#212529;'></i> </div>
                            <div class="text" style="font-size:30px;color:black">Nồng độ pH</div>
                            <p>Ngày: <?php echo ($row['curngay']); ?></p>
                            <p>Giờ: <?php echo ($row['curgio']); ?></p>
                            <div class="number" style='font-size:36px;color:#33b35a'><?php echo ($row["ph"]); ?></div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <!-- User Actibity-->
                        <div class="card income text-center">
                            <div class="icon"><i class='icon-flask' style='font-size:48px;color:#212529;'></i></i> </div>
                            <div class="text" style="font-size:30px;color:black">Nồng độ TDS</div>
                            <p>Ngày: <?php echo ($row['curngay']); ?></p>
                            <p>Giờ: <?php echo ($row['curgio']); ?></p>
                            <div class="number" style='font-size:36px;color:#33b35a'><?php echo ($row["tds"] . " ppm"); ?></div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- Header Section-->
        <section class="dashboard-header section-padding">
            <div class="container-fluid">
                <div class="row d-flex align-items-md-stretch">
                    <!-- Pie Chart-->
                    <div class="col-lg-6 col-md-6">
                        <div class="card project-progress">
                            <h2 class="display h4">Nồng độ TDS</h2>
                            <p>Ngày: <?php echo ($row['curngay']); ?></p>
                            <div class="line-chart">
                                <canvas id="ECchart"> </canvas>
                            </div>
                        </div>
                    </div>
                    <!-- Line Chart -->
                    <div class="col-lg-6 col-md-12 flex-lg-last flex-md-first align-self-baseline">
                        <div class="card sales-report">
                            <h2 class="display h4">Đồ thị nhiệt độ</h2>
                            <p>Ngày: <?php echo ($row['curngay']); ?></p>
                            <div class="line-chart">
                                <canvas id="tempchart"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- Statistics Section-->
        <section class="statistics">
            <div class="container-fluid">
                <div class="row d-flex">
                    <div class="col-lg-4">
                        <!-- Income-->
                        <div class="card income text-center">
                            <!-- Hiện thị ON/OFF   -->
                            <div class="number">MÁY BƠM</div>
                            <div id="content1" class="text-primary" >
                                 <?php
                                $quat = $row1["maybom"];
                                if ($quat == '0') {
                                    echo 'OFF';
                                } else echo 'ON';
                                ?>
                            </div>
                            <input type="button" id="btn1" class="btn btn-primary" value="ON"/>
                            <input type="button" id="btn2"  value="OFF"/>
                        
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <!-- Monthly Usage-->
                        <div class="card income text-center">
                            <!-- !-- Hiện thị ON/OFF   -->
                            <div class="number">QUẠT</div>
                            <div class="icon"><i class="fas fa-power-off" style='font-size:48px;color:green'></i></div>
                            <strong class="text-primary">
                                <?php
                                $quat = $row1["quat"];
                                if ($quat == '0') {
                                    echo 'OFF';
                                } else echo 'ON';
                                ?>
                            </strong>
                           
                            
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="card income text-center">
                            <!-- !-- Hiện thị ON/OFF   -->
                            <div class="number">ĐÈN</div>
                             <div id="content2" class="text-primary" >
                                 <?php
                                $den = $row1["den"];
                                if ($den == '0') {
                                    echo 'OFF';
                                } else echo 'ON';
                                ?>
                            </div>
                            <input type="button" id="btn3" class="btn btn-primary" value="ON"/>
                            <input type="button" id="btn4" value="OFF"/>
                        </div>
                    </div>
                </div>
            </div>
        </section>
       
       
        <footer class="main-footer">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-sm-6">
                        <p>Lorafarm &copy; 2019-2020</p>
                    </div>

                </div>
            </div>
        </footer>
    </div>
    <!-- JavaScript files-->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/popper.js/umd/popper.min.js"> </script>
    <script src="vendor/bootstrap/js/bootstrap.min.js"></script>
    <script src="js/grasp_mobile_progress_circle-1.0.0.min.js"></script>
    <script src="vendor/jquery.cookie/jquery.cookie.js"> </script>
    <script src="vendor/chart.js/Chart.min.js"></script>
    <script src="vendor/jquery-validation/jquery.validate.min.js"></script>
    <script src="vendor/malihu-custom-scrollbar-plugin/jquery.mCustomScrollbar.concat.min.js"></script>
    <script src="js/charts-home.js"></script>
    <!-- Main File-->
    <script src="js/front.js"></script>
     <script language="javascript">
            // Lấy 2 button và thẻ div cho MAY BOM
            var button1 = document.getElementById("btn1");
            var button2 = document.getElementById("btn2");
            // Lấy 2 button và thẻ div cho DEN
            var button3 = document.getElementById("btn3");
            var button4 = document.getElementById("btn4");
            
            var div1 = document.getElementById('content1');
            var div2 = document.getElementById('content2');
            // Thiết lập click cho button bat may bom
            button1.onclick = function(){
                $.get("http://iotsforhuman.com/API/ApiUpdateBom.php", {username:"admin",maybom:"1"});
                div1.innerHTML = 'ON';
            };
             
            // Thiết lập click cho button tat may bom
            button2.onclick = function(){
                div1.innerHTML = 'OFF';
                $.get("http://iotsforhuman.com/API/ApiUpdateBom.php", {username:"admin",maybom:"0"});
            };
                        // Thiết lập click cho button bat DEN
            button3.onclick = function(){
                $.get("http://iotsforhuman.com/API/ApiUpdateDen.php", {username:"admin",den:"1"});
                div2.innerHTML = 'ON';
            };
             
            // Thiết lập click cho button tat DEN
            button4.onclick = function(){
                div2.innerHTML = 'OFF';
                $.get("http://iotsforhuman.com/API/ApiUpdateDen.php", {username:"admin",den:"0"});
            };

        </script>
    <script>
    
     var checkUsername = '<?php echo $username;?>';
    //  console.log(checkUsername);
     if(checkUsername){
        $(document).ready(function() {
            showGraph1(checkUsername);
            showGraph2(checkUsername);
            
        });
     }
     
        function showGraph1(name) {
            {
                // console.log(username);
                $.post("http://iotsforhuman.com/API/ApiGetEcCurrentDay.php",{username:name},
                    function(data) {
                        console.log(data);
                        var ec = [];
                        var ngay = [];
                        var gio = [];

                        for (var i in data) {
                            ec.push(data[i].tds);
                            ngay.push(data[i].curngay);
                            gio.push(data[i].curgio);
                        }

                        var chartdata = {
                            labels: gio,
                            datasets: [{
                                label: 'ppm',
                                borderColor: '#64dd17',
                                fill: false,
                                data: ec,
                                borderWidth: 1,
                                pointHoverBorderWidth: 2,
                                // borderJoinStyle: 'miter',
                                // borderCapStyle: 'butt',

                            }]
                        };

                        var graphTarget = $("#ECchart");

                        var barGraph = new Chart(graphTarget, {
                            type: 'line',
                            data: chartdata,

                        });
                    });
            }
        }

        function showGraph2(name) {
            {
                $.post("http://iotsforhuman.com/API/ApiGetTempCurrentDay.php",{username:name},
                    function(data) {
                        console.log(data);
                        var nhietdo = [];
                        var ngay = [];
                        var gio = [];

                        for (var i in data) {
                            nhietdo.push(data[i].temp);
                            ngay.push(data[i].curngay);
                            gio.push(data[i].curgio);
                        }

                        var chartdata = {
                            labels: gio,
                            datasets: [{
                                label: 'Nhiệt độ',
                                borderColor: '#64dd17',
                                fill: false,
                                data: nhietdo,
                                borderWidth: 1,
                                pointHoverBorderWidth: 2,
                                borderJoinStyle: 'miter',
                                borderCapStyle: 'butt',

                            }]
                        };

                        var graphTarget = $("#tempchart");

                        var barGraph = new Chart(graphTarget, {
                            type: 'line',
                            data: chartdata,

                        });
                    });
            }
        }
    </script>
</body>

</html>