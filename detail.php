<?php
session_start();

if (!isset($_SESSION['login'])) {
	header("Location: login.php");
}


?>

<?php
$con = mysqli_connect("localhost","root","123123","users_db") or die(mysqli_connect_error());
$title = $_REQUEST['var'];
$result = mysqli_query($con, "SELECT * FROM public_db WHERE title='$title'");

//echo $title;   // 잘됨


$receive_id = "";
$receive_image_data = "";
$receive_title = "";
$receive_price = "";
$receive_explain = "";
$receive_call = "";
$receive_image_name = "";


$row = mysqli_fetch_array($result);

$receive_id	= $row['id'];
$receive_image_data = "<img class='card-img-top' align='center' width='300' height='200' src='get.php?title=$row[title]'>";
$receive_title = $row['title'];
$receive_price = $row['price'];
$receive_explain = $row['explain'];
$receive_call = $row['call'];                  
$receive_image_name = $row['image_name'];
$receive_user_name = $row['user_name'];
/*
echo $receive_user_name."<br>";
echo $receive_id."<br>";
echo $receive_image_data."<br>";
echo $receive_title."<br>";
echo $receive_price."<br>";
echo $receive_explain."<br>";
echo $receive_call."<br>";
echo $receive_image_name."<br>";


echo "end";
*/
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

        <div class="col-lg-9">
          

        </div>
        <!-- /.col-lg-9 -->

      </div>
      <!-- /.row -->

    </div>
    <!-- /.container -->

   




    <!-- 게시판 만들기 -->
    <table class="table table-striped">
      <thead>
        <tr>
          <th>등록번호</th>
          <th>사진</th>
          <th>제목</th>
          <th>가격</th>
          <th>설명</th>
          <th>전화번호</th>
          <th>사진정보</th>
          <th>작성자</th>
        </tr>
      </thead>

      <tbody>
        <tr>
          <td><?php echo $receive_id;?></td>
          <th><?php echo $receive_image_data;?></th>
          <th><?php echo $receive_title;?></th>
          <th><?php echo $receive_price;?></th>
          <th><?php echo $receive_explain;?></th>
          <th><?php echo $receive_call;?></th>
          <th><?php echo $receive_image_name;?></th>
          <th><?php echo $receive_user_name;?></th>
        </tr>
      </tbody>
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


