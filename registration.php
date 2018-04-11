<!DOCTYPE html>
<?php // registrate the information that is entered by users.
session_start();

$con = mysqli_connect('localhost', 'root', '123123', 'users_db');

if (isset($_POST['submit'])) {
	$username = $_POST['username'];
	$password = $_POST['password'];
	$email = $_POST['email'];

	if ( empty($_POST['username']) || empty($_POST['password']) ||empty($_POST['email']) ) {
		echo "<script> alert('Please enter all required fields !!!') </script>";
	}
	else{
		$query = "SELECT * FROM users 
		WHERE name='$username' OR email='$email'";

		$result = mysqli_query($con, $query);
		if (mysqli_num_rows($result) > 0) {
			header("Location: registration.php?MSG=Username or email already exist, Please use another one!!");
		}
		else{
			$query = "INSERT INTO users (id, name, pass, email) 
			VALUES (NULL, '$username', '$password', '$email')";
			if(mysqli_query($con, $query)){
				$_SESSION['login'] = $username;
				header("Location: login.php");
			}
		}
	}

}

?>


<html>
<head>
	<title> Registration Page </title>
	<meta charset="utf-8">
	<link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="css/shop-homepage.css" rel="stylesheet">

    <style type="text/css">
    	table, td{
    		border: 1px solid red
    	}
    	table{
    		width: 20%;
    		height: 100px;
    		margin: auto;
    		text-align: center;
    	}

    </style>

</head>
<body style="background-color: skyblue">

			<!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
      <div class="container">
        
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarResponsive">
          <ul class="navbar-nav ml-auto">
            
           <li>
           	<h1><span style="color: black">free enrollment fee</span></h1>
           </li>
           
          
          </ul>
        </div>
      </div>
    </nav>





<?php
if (isset($_GET['MSG'])) {
	echo $_GET['MSG'];
}
?>
<br><br><br><br><br><br>

<center>
     <div class="container" align="center">
      <div class="row">
        <div class="page-header">
        <h1>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</h1>
        </div>
        <div class="col-md-3">
          <div class="login-box well">
        <form accept-charset="UTF-8" role="form" method="post" action="registration.php">
            <legend>회원가입</legend>
            <div class="form-group">
                <label for="username">아이디</label>
                <input name="username" value='' id="username" placeholder=" username" type="text" class="form-control" />
            </div>
            <div class="form-group">
                <label for="password">비밀번호</label>
                <input name="password" id="password" value='' placeholder="password" type="password" class="form-control" />
            </div>
             <div class="form-group">
                <label for="email">이메일</label>
                <input name="email" id="email" value='' placeholder="email" type="text" class="form-control" />
            </div>
            <div class="form-group">
                <input type="submit" class="btn btn-default btn-login-submit btn-block m-t-md" value="succese" name="submit"/>
            </div>
            <b> 로그인하러 가기  <a href="login.php"> Login </a> <b>
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
</center>

</body>
</html>