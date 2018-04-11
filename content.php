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

    <!-- Bootstrap core CSS -->
    <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="css/shop-homepage.css" rel="stylesheet">



    <script>
    function showResult(str) {
      if (str.length==0) { 
        document.getElementById("livesearch").innerHTML="";
        document.getElementById("livesearch").style.border="0px";
        return;
      }
      if (window.XMLHttpRequest) {
        // code for IE7+, Firefox, Chrome, Opera, Safari
        xmlhttp=new XMLHttpRequest();
      } else {  // code for IE6, IE5
        xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
      }
      xmlhttp.onreadystatechange=function() {
      if (this.readyState==4 && this.status==200) {
        document.getElementById("livesearch").innerHTML=this.responseText;
        document.getElementById("livesearch").style.border="1px solid #A5ACB2";
      }
    }
    xmlhttp.open("GET","livesearch.php?q="+str,true);
    xmlhttp.send();
    }
    </script>


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
              <a class="nav-link" href="product.php">물건 올리기</a>
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
        
          <form>
        <input type="text" size="30" onkeyup="showResult(this.value)">
        <div id="livesearch"></div>
        </form>

          <div class="list-group">
            <a href="content.php" class="list-group-item">Home</a>
            <a href="everyboard.php" class="list-group-item">게시판</a>
          </div>

        </div>
        <!-- /.col-lg-3 -->


        <div class="col-lg-9">

          <div id="carouselExampleIndicators" class="carousel slide my-4" data-ride="carousel">
            <ol class="carousel-indicators">
              <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
              <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
              <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
            </ol>
            <div class="carousel-inner" role="listbox">
              <div class="carousel-item active">
                <img class="d-block img-fluid" src="image/aa1.png" alt="First slide" width="900" height="350">
              </div>
              <div class="carousel-item">
                <img class="d-block img-fluid" src="image/aa2.png" alt="Second slide" width="900" height="350">
              </div>
              <div class="carousel-item">
                <img class="d-block img-fluid" src="image/aa3.png" alt="Third slide" width="900" height="350">
              </div>
            </div>
            <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
              <span class="carousel-control-prev-icon" aria-hidden="true"></span>
              <span class="sr-only">Previous</span>
            </a>
            <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
              <span class="carousel-control-next-icon" aria-hidden="true"></span>
              <span class="sr-only">Next</span>
            </a>
          </div>

          <div class="row">

            <?php
              $count = 0;
              $con = mysqli_connect("localhost","root","123123","users_db") or die(mysqli_connect_error());
              $result = mysqli_query($con, "SELECT * FROM public_db");

              $_POST['title'] = "";
              $title = $_POST['title'];

              $receive_title = "";
              $receive_price = "";
              $receive_explain = "";
              $receive_call = "";

              while ($row = mysqli_fetch_array($result)){
                  $receive_image = "<img class='card-img-top' align='center' width='100' height='200' src='get.php?title=$row[title]'>";
                  
                  $receive_title = $row['title'];
                  $receive_price = $row['price'];
                  $receive_explain = $row['explain'];
                  $receive_call = $row['call'];                  
            ?>  

            <div class="col-lg-4 col-md-6 mb-4">
              <div class="card h-100">
                <a href="#"><?php echo $receive_image;?></a>
                <div class="card-body">
                  <h4 class="card-title">
                    <a href="detail.php?var=<?=$receive_title?>"><?=$receive_title?></a>
                  </h4>
                  <h5><?=$receive_price?></h5>
                  <p class="card-text"><?=$receive_explain?></p>
                </div>
                <div class="card-footer">
                  <small class="text-muted">&#9733; &#9733; &#9733; &#9733; &#9734;</small>
                </div>
              </div>
            </div>

            <?php
            $count++;
              }
            ?>


          </div>
          <!-- /.row -->

        </div>
        <!-- /.col-lg-9 -->

      </div>
      <!-- /.row -->

    </div>
    <!-- /.container -->

    <!-- Footer -->
    <footer class="py-5 bg-dark">
      <div class="container">
        <p class="m-0 text-center text-white">Copyright &copy; 임지환</p>
      </div>
      <!-- /.container -->
    </footer>

    <h2>게시되있는 물품 수 : <?php echo $count; ?></h2>

    <!-- Bootstrap core JavaScript -->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>



</body>
</html>

<?php



?>