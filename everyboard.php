<?php
session_start();

if (!isset($_SESSION['login'])) {
	header("Location: login.php");
}


?>

<!DOCTYPE html>
<html lang="en">

  <head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Shop Homepage</title>

    <!-- 부트스트랩 테이블 쓰기 위해 추가 -->
    <link rel="stylesheet" type="text/css" href="css/bootstrap.css">

    <!-- Bootstrap core CSS -->
    <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="css/shop-homepage.css" rel="stylesheet">

  </head>


<body>
	<!--For using sesstion information at the top of content.php have to define session start()-->
	<h2>Welcome <?php echo $_SESSION['login']; ?></h2>



	<!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
      <div class="container">
        
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarResponsive">
          <ul class="navbar-nav ml-auto">
            <li class="nav-item active">
              <a class="nav-link" href="content.php">Home
                <span class="sr-only">(current)</span>
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="logout.php">로그아웃</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="admin_login.php">관리자 로그인</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="uploadboard.php">게시판글쓰기</a>
            </li>
          </ul>
        </div>
      </div>
    </nav>

    <!-- Page Content -->
    <div class="container">

      <div class="row">

        <div class="col-lg-3">

          <h1 class="my-4">Home Shopping</h1>
          <div class="list-group">
            <a href="content.php" class="list-group-item">Home</a>
            <a href="everyboard.php" class="list-group-item">게시판</a>
          </div>

        </div>
        <!-- /.col-lg-3 -->

        

      </div>
      <!-- /.row -->

    </div>
    <!-- /.container -->

   <table class="table table-striped">
      <thead>
        <tr>
          <th>번호</th>
          <th>제목</th>
          <th>날짜</th>
          <th>작성자</th>
        </tr>
      </thead>

    <?php
      $con = mysqli_connect("localhost","root","123123","users_db") or die(mysqli_connect_error());
      $result1 = mysqli_query($con, "SELECT * FROM board");

      $receive_id1 = "";
      $receive_user_name1 = "";
      $receive_title1 = "";
      $receive_time = "";
      
      

      while ($row = mysqli_fetch_array($result1)) {
        $receive_id1 = $row['id'];
        $receive_user_name1 = $row['user_name1'];
        $receive_title1 = $row['title1'];
        $receive_time = $row['time'];
      
      ?>


      <tbody>
        <tr>
          <td><?=$receive_id1?></td>
          <td><?=$receive_title1?></td>
          <td><?=$receive_user_name1?></td>
          <td><?=$receive_time?></td>
        </tr>
      </tbody>
    

    <?php
      }
    ?>
    </table>


    <hr>



    <script src="js/jquery-3.1.1.js"></script>
    <script src="js/bootstrap.js"></script>



 <!-- Footer -->
    <footer class="py-5 bg-dark">
      <div class="container">
        <p class="m-0 text-center text-white">Copyright &copy; 임지환</p>
      </div>
      <!-- /.container -->
    </footer>

    <!-- Bootstrap core JavaScript -->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>



</body>
</html>

<?php



?>