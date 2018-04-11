<?php
session_start();

$con = mysqli_connect('localhost', 'root', '123123', 'users_db');

/*  // 연결이 잘 돼는지 test용 
if (mysqli_connect_errno()) {
	echo "Connection Failed ". mysqli_connect_errno();
}
else{
	echo "Succeed in Connection !!";
}
*/

if (isset($_POST['submit'])) {
	$admin_username = $_POST['admin_username'];
	$admin_password = $_POST['admin_password'];

	if (empty($_POST['admin_username'])) {//if you did not enter a username
		echo "<script> alert('Please enter Admin Useername !') </script>";
	}
	if (empty($_POST['admin_password'])) {//if you did not enter admin password
		echo "<script> alert('Please enter Admin Password !') </script>";
	}

	$query = "SELECT admin_name, admin_pass FROM admin 
	WHERE admin_name='$admin_username' AND admin_pass='$admin_password'";

	$result = mysqli_query($con, $query);

	if (mysqli_num_rows($result) > 0) {
		$_SESSION['admin_login'] = $admin_username;
		// keep the session information from $username to $_SESSION['login'] that is session variable used later.
		header("Location: admin_users.php");
	}
	else{
		header("Location: login.php");
		//echo "Wrong admin username or admin password !";
	}

}

?>

<!DOCTYPE html>
<html lang="en">

  <head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>관리자 페이지</title>

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

  <body id="page-top" style="background-color: skyblue">

    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg bg-secondary fixed-top text-uppercase" id="mainNav">
      <div class="container">
        <button class="navbar-toggler navbar-toggler-right text-uppercase bg-primary text-white rounded" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
          Menu
          <i class="fa fa-bars"></i>
        </button>
        <div class="collapse navbar-collapse" id="navbarResponsive">
          <ul class="navbar-nav ml-auto">
            <li class="nav-item mx-0 mx-lg-1">
              <a class="nav-link py-3 px-0 px-lg-3 rounded js-scroll-trigger" a href="login.php"><h1><span style="color: red">사용자 로그인</span></h1></a>
            </li>
          </ul>
        </div>
      </div>
    </nav>

    
    <header class="masthead bg-primary text-white text-center">
      <div class="container">
        <img class="img-fluid mb-5 d-block mx-auto"  alt="">
        
      </div>
    </header>


    <body>
       
    <div class="container" align="center">
      <div class="row">
        <div class="page-header">
        <h1>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</h1>
        </div>
        <div class="col-md-3">
          <div class="login-box well">
        <form accept-charset="UTF-8" role="form" method="post" action="admin_login.php">
            <br><br><br><br><br>

            <legend><h1>관리자 로그인</h1></legend>
            <div class="form-group">
                <input name="admin_username" value='' id="adminname" placeholder=" adminname" type="text" class="form-control" />
            </div>
            <div class="form-group">
                <input name="admin_password" id="password" value='' placeholder="Password" type="password" class="form-control" />
            </div>
            <div class="form-group">
                <input type="submit" class="btn btn-default btn-login-submit btn-block m-t-md" value="관리자 로그인" name="submit"/>
            </div>
            <hr />
        </form>
          </div>
        </div>
      </div>
    </div>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
  <script src="js/bootstrap.min.js"></script>
   
  </body>
  </html>