<?php
session_start();
$id=$_GET['edit'];
$con = mysqli_connect('localhost','root','123123','users_db');


if (isset($_POST['submit'])) {
    
  $pass = $_POST['pass'];
  $up_id = $_POST['up_id'];
  
  if (empty($_POST['pass'])) {
        echo "<script> alert('Please enter your pass!')</script>";
        }   
  
    $query = "UPDATE users SET pass='$pass' WHERE id='$up_id'";
    $result = mysqli_query($con,$query);
    
    if ( mysqli_query($con,$query)) {
            header("Location: login.php");
    } else {
        echo "Wrong name or pass !";
    }

}
?>

<html lang="en">

  <head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Freelancer - Start Bootstrap Theme</title>

    <!-- Bootstrap core CSS -->
    <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom fonts for this template -->
    <link href="vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Lato:400,700,400italic,700italic" rel="stylesheet" type="text/css">

    <!-- Plugin CSS -->
    <link href="vendor/magnific-popup/magnific-popup.css" rel="stylesheet" type="text/css">

    <!-- Custom styles for this template -->
    <link href="css/freelancer.min.css" rel="stylesheet">

  </head>

  <body id="page-top">

    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg bg-secondary fixed-top text-uppercase" id="mainNav">
      <div class="container">
        <a class="navbar-brand js-scroll-trigger" a href="login.php">Login</a>
        <button class="navbar-toggler navbar-toggler-right text-uppercase bg-primary text-white rounded" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
          Menu
          <i class="fa fa-bars"></i>
        </button>
        <div class="collapse navbar-collapse" id="navbarResponsive">
          <ul class="navbar-nav ml-auto">
            <li class="nav-item mx-0 mx-lg-1">
              <a class="nav-link py-3 px-0 px-lg-3 rounded js-scroll-trigger" a href="login.php">사용자 로그인</a>
            </li>
            
            <li class="nav-item mx-0 mx-lg-1">
              <a class="nav-link py-3 px-0 px-lg-3 rounded js-scroll-trigger" a href="admin_login.php">관리자 로그인</a>
            </li>
          </ul>
        </div>
      </div>
    </nav>

    <header class="masthead bg-primary text-white text-center">


    </header>

    
    <div class="container" align="center">
      <div class="row">
        <div class="page-header">
        <h1>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</h1>
        </div>
        <div class="col-md-3">
          <div class="login-box well">
        <form accept-charset="UTF-8" role="form" method="post" action="modify.php">
            
            <div class="form-group">
                <br><br><br><br><br><br><br><br>
                <label for="username">비밀번호 변경</label>

                <input type="hidden" name="up_id" value=<?php echo $id; ?>>

                <input name="pass" id="pass" placeholder="Translate password" type="text" class="form-control" >            

            </div>
            <div class="form-group">
                <input type="submit" class="btn btn-default btn-login-submit btn-block m-t-md" value="변경" name="submit"/>
            </div>
            <hr />
           
        </form>
          </div>
        </div>
      </div>
    </div>
 
  <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
  <!-- Include all compiled plugins (below), or include individual files as needed -->
  <script src="js/bootstrap.min.js"></script>
    
  </body>
  </html>