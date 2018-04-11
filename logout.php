<?php
session_start();
session_destroy();  // when you did logout you have to destroy session information.
header("Location: login.php");

?>