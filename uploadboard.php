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

<form action='uploadboard.php' method='POST'> 

<TR> <TD>제목</TD> 
<TD><input type='text' name='title1'></TD></TR> 

<TR> <TD>날짜</TD> 
<TD><input type='text' name='time'></TD></TR> 

<TR> <TD colspan = 2> 
<input type='submit' value='업로드' name="submit2"></TD></TR> 

</TABLE> 
</form> 

</body>
</html>




<?php
	
	if (isset($_POST['submit2'])) {

		$con2 = mysqli_connect('localhost', 'root', '123123', 'users_db') or die(mysqli_connect_error());

		$title1 = $_POST['title1'];
		$time = $_POST['time'];


		if ( empty($_POST['title1']) || empty($_POST['time'])) {
			echo "<script> alert('Please enter all required fields !!!') </script>";
		}
		else{
			$sql2 = "INSERT INTO board VALUES (NULL, '$title1', '$time', '$user_name')";
			if(!mysqli_query($con2, $sql2)){
				echo "Problem in uploading image !". mysqli_error($con2); 
			}
			else{
                header("Location: everyboard.php");
			}
		}
		
	}

?>