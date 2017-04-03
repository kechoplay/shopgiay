<?php
session_start();
$id = $_GET['proid'];
if($id == 0){
	unset($_SESSION['cart']);	
}
elseif($id!=0){
	unset($_SESSION['cart'][$id]);
}
header('location:index.php?page=cart');
exit();
?>