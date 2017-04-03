<?php 
session_start();
 
if (isset($_SESSION['Name']) && $_SESSION['Pass']){
	session_destroy(); // xóa session login
	header('location:index.php');
}
if (isset($_SESSION['Name1']) && $_SESSION['Pass1']){
	session_destroy(); // xóa session login
	header('location:index.php');
}
?>