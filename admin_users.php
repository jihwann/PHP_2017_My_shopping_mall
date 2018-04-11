<?php
session_start();
if (!isset($_SESSION['admin_login'])) {
        header("Location: admin_login.php");
    }
?>

<html>
<head>
	<meta charset="utf-8">

	<link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="css/shop-homepage.css" rel="stylesheet">
</head>

<body style="background-color: skyblue">
<center>
<h1> Admin Panel for User Management </h1>
<h2> Welcome <?=$_SESSION['admin_login']?></h2>
<hr>
<center>
<div class="container">
    
    <div class="row">
        <div class="panel panel-primary filterable">
            <div class="panel-heading">
                <div class="pull-right">
                    
                </div>
            </div>
            <table class="table" align="ceneter">
                <thead>
                    <tr class="filters">
                        <th><input type="text" class="form-control" placeholder="chart" disabled></th>
                        <th><input type="text" class="form-control" placeholder="ID" disabled></th>
                        <th><input type="text" class="form-control" placeholder="password" disabled></th>
                        <th><input type="text" class="form-control" placeholder="email" disabled></th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    $con = mysqli_connect('localhost', 'root', '123123', 'users_db');
                    $query = "SELECT * FROM users";
                    $result = mysqli_query($con, $query);

                    while($row = mysqli_fetch_array($result)){
                      $id = $row[0];
                      $username = $row[1];
                      $password = $row[2];
                      $email = $row[3];
                    ?>
                    <tr>
                      <td> <?php echo $id; ?> </td>
                      <td> <?=$username ?> </td>
                      <td> <?=$password ?> </td>
                      <td> <?=$email ?> </td>
                      <td> <a href="delete.php?del=<?=$id?>"><span style="color: green">계정삭제</span></a></td>
                      <td><a href="modify.php?edit=<?=$id?>"><span style="color: green">비밀번호변경</span></a></td>
                      
                      
                    </tr>
                    <?php
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
</center>
<b> <a href="./admin_login.php" align="right"> <h1><span style="color: red">로그아웃</span></h1> </a> </b>

</center>
</body>



</html>