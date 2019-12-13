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
          
          <li><a href="dashboard.php"> <i class="fas fa-server"></i>Quản lý hệ thống </a></li>
          <!-- <li><a href="forms.html"> <i class="icon-form"></i>Forms </a></li> -->
          <li><a href="charts.php"> <i class="fa fa-bar-chart"></i>Biểu đồ</a></li>
          <li><a href="caytrong.php"> <i class="icon-grid"></i>Tình hình cây trồng</a></li>
          <li><a href="#exampledropdownDropdown" aria-expanded="false" data-toggle="collapse"> <i class="icon-interface-windows"></i>Bảng dữ liệu</a>
            <ul id="exampledropdownDropdown" class="collapse list-unstyled ">
              <li><a href="dataday.php">Bảng dữ liệu theo ngày</a></li>
              <li><a href="dataweek.php">Bảng dữ liệu theo tuần</a></li>
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
    <section class="dashboard-header section-padding">
      <div class="container-fluid">
        <div class="row d-flex align-items-md-stretch">
          <!-- Temp Chart-->
          <div class="col-lg-6 col-md-6">
            <div class="card project-progress">
              <h2 class="display h4">Đồ thị nhiệt độ</h2>
              <p>Ngày: <?php echo $row['curngay']; ?></p>
              <div class="line-chart">
                <canvas id="tempChart"> </canvas>
              </div>
            </div>
          </div>
          <!-- Humi Chart -->
          <div class="col-lg-6 col-md-12 flex-lg-last flex-md-first align-self-baseline">
            <div class="card sales-report">
              <h2 class="display h4">Đồ thị độ ẩm</h2>
              <p>Ngày: <?php echo ($row['curngay']); ?></p>
              <div class="line-chart">
                <canvas id="humiChart"></canvas>
              </div>
            </div>
          </div>
        </div>
        <hr>
        <div class="row d-flex align-items-md-stretch">
          <!-- Lux Chart-->
          <div class="col-lg-6 col-md-6">
            <div class="card project-progress">
              <h2 class="display h4">Đồ thị cường độ ánh sáng</h2>
              <p>Ngày: <?php echo ($row['curngay']); ?></p>
              <div class="line-chart">
                <canvas id="luxChart"> </canvas>
              </div>
            </div>
          </div>
          <!-- ph Chart -->
          <div class="col-lg-6 col-md-12 flex-lg-last flex-md-first align-self-baseline">
            <div class="card sales-report">
              <h2 class="display h4">Đồ thị nồng độ pH</h2>
              <p>Ngày: <?php echo ($row['curngay']); ?></p>
              <div class="line-chart">
                <canvas id="phChart"></canvas>
              </div>
            </div>
          </div>
          <hr>
          <!-- ec Chart -->
          <div class="col-lg-12 col-md-12">
            <div class="card sales-report">
              <h2 class="display h4">Đồ thị nồng độ TDS</h2>
              <p>Ngày: <?php echo ($row['curngay']); ?></p>
              <div class="line-chart">
                <canvas id="ecChart"></canvas>
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
    <!-- <script src="js/charts-custom.js"></script> -->
    <!-- Main File-->
    <script src="js/front.js"></script>
    <script>
     var checkUsername = '<?php echo $username;?>';
    //  console.log(checkUsername);
     if(checkUsername){
    $(document).ready(function() {
      showGraph1(checkUsername);
      showGraph2(checkUsername);
      showGraph3(checkUsername);
      showGraph4(checkUsername);
      showGraph5(checkUsername);

    });
    }
// chart temp
    function showGraph1(name) {
      {
        $.post("http://iotsforhuman.com//API/ApiGetTempCurrentDay.php",{username:name},
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
                // borderJoinStyle: 'miter',
                // borderCapStyle: 'butt',

              }]
            };

            var graphTarget = $("#tempChart");

            var barGraph = new Chart(graphTarget, {
              type: 'line',
              data: chartdata,

            });
          });
      }
    }
// chart humi
    function showGraph2(name) {
      {
        $.post("http://iotsforhuman.com//API/ApiGetHumiCurrentDay.php",{username:name},
          function(data) {
            console.log(data);
            var doam = [];
            var ngay = [];
            var gio = [];

            for (var i in data) {
              doam.push(data[i].humi);
              ngay.push(data[i].curngay);
              gio.push(data[i].curgio);
            }

            var chartdata = {
              labels: gio,
              datasets: [{
                label: 'Độ ẩm',
                borderColor: '#64dd17',
                fill: false,
                data: doam,
                borderWidth: 1,
                pointHoverBorderWidth: 2,
                borderJoinStyle: 'miter',
                borderCapStyle: 'butt',

              }]
            };

            var graphTarget = $("#humiChart");

            var barGraph = new Chart(graphTarget, {
              type: 'line',
              data: chartdata,

            });
          });
      }
    }
    // chart lux
    function showGraph3(name) {
      {
        $.post("http://iotsforhuman.com//API/ApiGetLuxCurrentDay.php",{username:name},
          function(data) {
            console.log(data);
            var anhsang = [];
            var ngay = [];
            var gio = [];

            for (var i in data) {
              anhsang.push(data[i].lux);
              ngay.push(data[i].curngay);
              gio.push(data[i].curgio);
            }

            var chartdata = {
              labels: gio,
              datasets: [{
                label: 'lux',
                borderColor: '#64dd17',
                fill: false,
                data: anhsang,
                borderWidth: 1,
                pointHoverBorderWidth: 2,
                borderJoinStyle: 'miter',
                borderCapStyle: 'butt',

              }]
            };

            var graphTarget = $("#luxChart");

            var barGraph = new Chart(graphTarget, {
              type: 'line',
              data: chartdata,

            });
          });
      }
    }
    // Chart ph
    function showGraph4(name) {
      {
        $.post("http://iotsforhuman.com//API/ApiGetPhCurrentDay.php",{username:name},
          function(data) {
            console.log(data);
            var phday = [];
            var ngay = [];
            var gio = [];

            for (var i in data) {
              phday.push(data[i].ph);
              ngay.push(data[i].curngay);
              gio.push(data[i].curgio);
            }

            var chartdata = {
              labels: gio,
              datasets: [{
                label: 'pH',
                borderColor: '#64dd17',
                fill: false,
                data: phday,
                borderWidth: 1,
                pointHoverBorderWidth: 2,
                borderJoinStyle: 'miter',
                borderCapStyle: 'butt',

              }]
            };

            var graphTarget = $("#phChart");

            var barGraph = new Chart(graphTarget, {
              type: 'line',
              data: chartdata,

            });
          });
      }
    }
    // Chart EC
    function showGraph5(name) {
      {
        $.post("http://iotsforhuman.com//API/ApiGetEcCurrentDay.php",{username:name},
          function(data) {
            console.log(data);
            var ecday = [];
            var ngay = [];
            var gio = [];

            for (var i in data) {
              ecday.push(data[i].tds);
              ngay.push(data[i].curngay);
              gio.push(data[i].curgio);
            }

            var chartdata = {
              labels: gio,
              datasets: [{
                label: 'ppm',
                borderColor: '#64dd17',
                fill: false,
                data: ecday,
                borderWidth: 1,
                pointHoverBorderWidth: 2,
                borderJoinStyle: 'miter',
                borderCapStyle: 'butt',

              }]
            };

            var graphTarget = $("#ecChart");

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