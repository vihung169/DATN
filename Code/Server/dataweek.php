<?php
session_start();
$username = $_SESSION['username'];
$password = $_SESSION['password'];


$svrname = "localhost";
$user = "vihung169";
$pass = "Hunghung169@";
$db = "iotsforhuman";

$connection = new mysqli($svrname, $user, $pass, $db);

$sql = "SELECT * FROM weather WHERE id=(SELECT max(id) FROM weather WHERE username='$username')";
$result = $connection->query($sql);
if ($result->num_rows > 0) {
    // output data of each row
    $row = $result->fetch_assoc();
    // echo ("id: " . $row["username"] . "-" . $row["temp"] . "- " . $row["humi"] . "- " . $row["lux"] ."- " . $row["ph"] . "- " . $row["ec"] ."<br>");

} else {
    echo "0 results";
}

?>
<!DOCTYPE html>
<html>

<head>
<meta charset="utf-8">
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
                    <h2 class="h5"><?php echo $username; ?></h2><span>Address</span>
                </div>
                <!-- Small Brand information, appears on minimized sidebar-->
                <div class="sidenav-header-logo"><a href="dashboard.php" class="brand-small text-center"> <strong>L</strong><strong class="text-primary">F</strong></a></div>
            </div>
            <!-- Sidebar Navigation Menus-->
            <div class="main-menu">
                <h5 class="sidenav-heading">Thông tin</h5>
                <ul id="side-main-menu" class="side-menu list-unstyled">
                    <!--<li><a href="home.php"> <i class="icon-home"></i>Trang chủ</a></li>-->
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
        <section>
            <div class="container-fluid">
                <!-- Page Header-->
                <header>
                    <h1 class="h3 display">Biểu đồ ngày:</h1>
                </header>
                <div class="row">
                    <div class="col-lg-6">
                        <div class="card">
                            <div class="card-header">
                                <h4>Bảng nhiệt độ trong ngày</h4>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th>Ngày</th>
                                                <th>Giờ</th>
                                                <th>Nhiệt độ</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $st = "SELECT * FROM weather WHERE username='$username' AND DATE_SUB(CURDATE(),INTERVAL 6 DAY) <= curngay ORDER BY id DESC ";
                                            $result2 = $connection->query($st);
                                            if ($result2->num_rows > 0) {
                                                // output data of each row

                                                while ($row2 = $result2->fetch_assoc()) {
                                                    echo ("<tr><td>" . $row2["curngay"] . "</td><td>" . $row2["curgio"] . "</td><td>" . $row2["temp"] . "°C" . "</td><tr>");
                                                }
                                            }
                                            ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="card">
                            <div class="card-header">
                                <h4>Bảng độ ẩm trong ngày</h4>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th>Ngày</th>
                                                <th>Giờ</th>
                                                <th>Độ ẩm</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $st = "SELECT * FROM weather WHERE username='$username' AND DATE_SUB(CURDATE(),INTERVAL 6 DAY) <= curngay ORDER BY id DESC ";
                                            $result2 = $connection->query($st);
                                            if ($result2->num_rows > 0) {
                                                // output data of each row

                                                while ($row2 = $result2->fetch_assoc()) {
                                                    echo ("<tr><td>" . $row2["curngay"] . "</td><td>" . $row2["curgio"] . "</td><td>" . $row2["humi"] . "%" .  "</td><tr>");
                                                }
                                            }
                                            ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="card">
                            <div class="card-header">
                                <h4>Bảng cường độ ánh sáng trong ngày</h4>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th>Ngày</th>
                                                <th>Giờ</th>
                                                <th>Cường độ ánh sáng</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $st = "SELECT * FROM weather WHERE username='$username' AND DATE_SUB(CURDATE(),INTERVAL 6 DAY) <= curngay ORDER BY id DESC ";
                                            $result2 = $connection->query($st);
                                            if ($result2->num_rows > 0) {
                                                // output data of each row

                                                while ($row2 = $result2->fetch_assoc()) {
                                                    echo ("<tr><td>" . $row2["curngay"] . "</td><td>" . $row2["curgio"] . "</td><td>" . $row2["lux"] . " lux" .  "</td><tr>");
                                                }
                                            }
                                            ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="card">
                            <div class="card-header">
                                <h4>Bảng nồng độ pH</h4>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table">
                                    <thead>
                                            <tr>
                                                <th>Ngày</th>
                                                <th>Giờ</th>
                                                <th>pH</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $st = "SELECT * FROM weather WHERE username='$username' AND DATE_SUB(CURDATE(),INTERVAL 6 DAY) <= curngay ORDER BY id DESC ";
                                            $result2 = $connection->query($st);
                                            if ($result2->num_rows > 0) {
                                                // output data of each row

                                                while ($row2 = $result2->fetch_assoc()) {
                                                    echo ("<tr><td>" . $row2["curngay"] . "</td><td>" . $row2["curgio"] . "</td><td>" . $row2["ph"]  .  "</td><tr>");
                                                }
                                            }
                                            ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="card">
                            <div class="card-header">
                                <h4>Bảng nồng độ TDS</h4>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table">
                                    <thead>
                                            <tr>
                                                <th>Ngày</th>
                                                <th>Giờ</th>
                                                <th>TDS</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $st = "SELECT * FROM weather WHERE username='$username' AND DATE_SUB(CURDATE(),INTERVAL 6 DAY) <= curngay ORDER BY id DESC ";
                                            $result2 = $connection->query($st);
                                            if ($result2->num_rows > 0) {
                                                // output data of each row

                                                while ($row2 = $result2->fetch_assoc()) {
                                                    echo ("<tr><td>" . $row2["curngay"] . "</td><td>" . $row2["curgio"] . "</td><td>" . $row2["tds"]."ppm"  .  "</td><tr>");
                                                }
                                            }
                                            ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <footer class="main-footer">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-sm-6">
                        <p>LoRaFarm &copy; 2019-2020</p>
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
    <!-- Main File-->
    <script src="js/front.js"></script>
</body>

</html>