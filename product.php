<?php
session_start();


if (!isset($_SESSION['login'])) {
	header("Location: login.php");
}

$user_name = $_SESSION['login'];

?>

<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>

<form action='product.php' method='POST' enctype='multipart/form-data'> 
<INPUT TYPE=hidden name=mode value=insert> 
<TABLE> 
<TR> <TD>올릴 이미지:</TD> 
<TD><input type='file' name='image'></TD></TR> 

<TR> <TD>제목</TD> 
<TD><input type='text' name='title'></TD></TR> 

<TR> <TD>가격</TD> 
<TD><input type='text' name='price'></TD></TR> 

<TR> <TD>설명</TD> 
<TD><textarea name="explain" rows="5" cols="40"></textarea></TR> 

<TR> <TD>전화번호</TD> 
<TD><input type='text' name='call'></TD></TR> 


<TR> <TD colspan = 2> 
<input type='submit' value='업로드' name="submit1"></TD></TR> 
<TR> <TD colspan = 2> 
<input type='submit' value='물품등록하기' name="submit2"></TD></TR> 
</TABLE> 
</form> 

</body>
</html>




<?php
	
	if (isset($_POST['submit1'])) {

		$con1 = mysqli_connect('localhost', 'root', '123123', 'users_db') or die(mysqli_connect_error());

		$file = $_FILES['image']['tmp_name'];

		$title = $_POST['title'];
		$price = $_POST['price'];
		$explain = $_POST['explain'];
		$call = $_POST['call'];

		if (!isset($file) || empty($_POST['title']) || empty($_POST['price']) || empty($_POST['explain']) || empty($_POST['call']) ) {
			echo "<script> alert('Please enter all required fields !!!') </script>";
		}
		else{
			$image_name = addslashes($_FILES['image']['name']);
			$image_data = addslashes(file_get_contents($_FILES['image']['tmp_name']));
			$image_size = getimagesize($_FILES['image']['tmp_name']);

			if ($image_size == FALSE) {
			echo "That's not an image ! ";
			}
			else{
				//$sql1 = "INSERT INTO public_db (image_data, title, price, explain, call) VALUES ('$image_data', '$title', '$price', '$explain', '$call')";
				$sql1 = "INSERT INTO public_db VALUES (NULL,'$image_data', '$title', '$price', '$explain', '$call', '$image_name', '$user_name')";
				//header("Location: content.php");
				
				if(!mysqli_query($con1, $sql1)){
					echo "Problem in uploading image !". mysqli_error($con1); 
				}
				else{
					echo "<p> Your Image : $image_name </p>";
                // using separate php file 
                	//echo "<img width='200' height='200' src='get.php?title=$title'>";
                	//echo "<img align='center' width='200' height='200' src='get.php?title=$title'>";
                	echo "<img align='center' width='200' height='200' src='get.php?title=$title'>";
                	header("Location: content.php");
				}
				if (isset($_POST['submit2'])) {
					header("Location: content.php");
				}
			}

			

		}
		

	}

?>