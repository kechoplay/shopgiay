<?php
session_start();
ob_start();
include("ketnoi.php");
$set_lang=mysql_query("SET NAMES 'utf8'");
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Admin</title>

	<link href="css/bootstrap.min.css" rel="stylesheet">
	<link rel="stylesheet" type="text/css" href="CSS/admin.css"/>
	<link rel="stylesheet" type="text/css" href="CSS/style.css"/>
	<link rel="stylesheet" type="text/css" href="CSS/them-sp.css" />
	<link rel="stylesheet" type="text/css" href="CSS/resetcss.css" />
	<title>My Shop</title>
</head>
<body>
	<?php
	if (isset($_SESSION['Name']) && $_SESSION['Pass']) {
		?>
		<div id="wrapper">
			<div id="head" class="clearfix">
				<div class="wrapper_container">
					<div id="logo">
						<a href="">
							<img src="CSS/images/logo.jpg">
						</a>
					</div>
					<ul id="main_menu">
						<li><a href="admin.php">QL sản phẩm</a></li>
						<li><a href="admin.php?page=qlthanhvien">QL thành viên</a></li>
						<li><a href="admin.php?page=qldanhmuc">ql danh mục</a></li>
						<li><a href="admin.php?page=qlhoadon">Ql hóa đơn</a></li>
						<li><a href="admin.php?page=binhluankh">Bl khách hàng</a></li>
						<li><a href="logout.php">Log out</a></li>
					</ul>
				</div>
			</div>
			<div class="clearfix"></div>
			<div id="main_content">
				<div class="wrapper_container">
					<div class="info_page">
						<?php
						if(!isset($_GET['page'])){
							include('homeadmin.php');
						}else{
							if($_GET['page']=='suasp'){
								include_once 'sua-sp.php';
							}
							if($_GET['page']=='xoasp'){
								include_once 'xoa-sp.php';
							}
							if($_GET['page']=='themsp'){
								include_once 'them-sp.php';
							}
							if($_GET['page']=='qldanhmuc'){
								include_once 'qldanhmuc.php';
							}
							if($_GET['page']=='qlthanhvien'){
								include_once 'qlthanhvien.php';
							}
							if($_GET['page']=='qlhoadon'){
								include_once 'qlhoadon.php';
							}
							if($_GET['page']=='binhluankh'){
								include_once 'binhluankh.php';
							}
							if($_GET['page']=='chitiethoadon'){
								include_once 'chitiethoadon.php';
							}
						}
						?>
					</div>
				</div>
			</div>
			<div id="footer">
				<div class="wrapper_container">
					<div class="info">
						<p></p>
						<p></p>
						<p>Tel:01645220249</p>
						<p>Email:kechoplay@gmail.com</p>
					</div>
				</div>
			</div>
		</div>
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
		<script src="js/bootstrap.min.js"></script>
		<?php
	}
	else{
		header("location:index.php");
	}
	?>
</body>
</html>