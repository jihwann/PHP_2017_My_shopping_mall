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
	$username = $_POST['username'];
	$password = $_POST['password'];

	if (empty($_POST['username'])) {//if you did not enter a username
		echo "<script> alert('Please enter Useername !') </script>";
	}
	if (empty($_POST['password'])) {//if you did not enter password
		echo "<script> alert('Please enter Password !') </script>";
	}

	$query = "SELECT name, pass FROM users 
	WHERE name='$username' AND pass='$password'";

	$result = mysqli_query($con, $query);

	if (mysqli_num_rows($result) > 0) {
		$_SESSION['login'] = $username;
		// keep the session information from $username to $_SESSION['login'] that is session variable used later.
		header("Location: content.php");
	}
	else{
		echo "Wrong username or password !";
	}

}

if (isset($_POST['registration'])) {
	header("Location: registration.php");
}
if (isset($_POST['admin'])) {
	header("Location: admin_login.php");
}


?>

<html lang="en">

  <head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>인터넷쇼핑</title>

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
    <nav class="navbar navbar-expand-lg bg-secondary fixed-top text-uppercase" id="mainNav" >
        <button class="navbar-toggler navbar-toggler-right text-uppercase bg-primary text-white rounded" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
          Menu
          <i class="fa fa-bars"></i>
        </button>
        <div class="collapse navbar-collapse" id="navbarResponsive">
          <ul class="navbar-nav ml-auto">
            <li class="nav-item mx-0 mx-lg-1">
              <a class="nav-link py-3 px-0 px-lg-3 rounded js-scroll-trigger" a href="registration.php"><h1><span style="color: red">회원가입</span></h1></a>
            </li>
            <li class="nav-item mx-0 mx-lg-1">
              <a class="nav-link py-3 px-0 px-lg-3 rounded js-scroll-trigger" a href="admin_login.php"><h1><span style="color: red">관리자 로그인</span></h1></a>
            </li>
          </ul>
        </div>
      </div>
    </nav>

    <header class="masthead bg-primary text-white text-center">


    </header>

    <body>
    <div class="container" align="center">
      <div class="row">
        <div class="page-header">
        <h1>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</h1>
        </div>
        <div class="col-md-3">
          <div class="login-box well">
        <form accept-charset="UTF-8" role="form" method="post" action="login.php">
            <br><br><br><br><br><br>
            <legend><h1>로그인</h1></legend>
            <div class="form-group">
                <input name="username" value='' id="username" placeholder="enter your id" type="text" class="form-control" />
            </div>
            <div class="form-group">
                <input name="password" id="password" value='' placeholder="enter your password" type="password" class="form-control" />
            </div>
            <div class="form-group">
                <input type="submit" class="btn btn-default btn-login-submit btn-block m-t-md" value="로그인" name="submit" style="background-color: gray" />
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

</body>
</html>