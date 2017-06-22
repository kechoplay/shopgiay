<?php
session_start();
ob_start();
include('ketnoi.php');
$set_lang=mysql_query("SET NAMES 'utf8'");
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Shop giay</title>

	<link href="css/bootstrap.min.css" rel="stylesheet">
	<link rel="stylesheet" type="text/css" href="CSS/resetcss.css" />
	<link rel="stylesheet" type="text/css" href="CSS/css.css" />
	<link rel="stylesheet" type="text/css" href="CSS/home.css"/>
	<link rel="stylesheet" type="text/css" href="CSS/style.css"/>
	<link rel="stylesheet" type="text/css" href="CSS/them-sp.css" />
	<link rel="stylesheet" type="text/css" href="CSS/cart.css"/>
	<link rel="stylesheet" type="text/css" href="CSS/chitietsp.css"/>
	<title>My Shop</title>

</head>

<body>
	<fieldset>
		<header id="dau">
			<img src="CSS/images/bia.jpg" style="width:100%; height:150px; ">
		</header>
		<nav class="navbar navbar-inverse" style="margin-bottom: 10px;margin-top: 10px;">
			<div class="container-fluid">
				<div class="navbar-header">
					<a class="navbar-brand" href="index.php">Shop Giầy</a>
				</div>
				<ul class="nav navbar-nav">
					<li><a href="index.php?page=gioithieu">Giới Thiệu</a></li> 
					<li><a href="index.php?page=cart">Giỏ Hàng</a></li> 
				</ul>
				<ul class="nav navbar-nav navbar-right" id="main_menu">
					<?php
					if(isset($_SESSION['Name1'])&& $_SESSION['Pass1']){
						?>

						<li> <a>Xin chào <?php echo $_SESSION['Name1'] ?></a>
							<ul class="sub_menu">
								<li><a href="index.php?page=account">Thông tin tài khoản</a></li>
								<li><a href="index.php?page=changepassword">Đổi mật khẩu</a></li>
								<li> <a href="logout.php">Logout</a></li>
							</ul>
						</li>
						<?php
					}
					else{
						?>
						<li><a href="dang-ky.php"><span class="glyphicon glyphicon-user"></span> Sign Up</a></li>
						<li><a href="dang-nhap.php"><span class="glyphicon glyphicon-log-in"></span> Login</a></li>
						<?php
					}?>
				</ul>
			</div>
		</nav>
		<div id="sidebar">
			<div class="box search">
				<h2>Search by <span></span></h2>
				<div class="box-content">
					<form action="index.php" method="get">

						<label>Keyword</label>
						<input type="search" name="tukhoa" class="field" />
						<input type="submit" name="submit_tk" class="search-submit" value="Search" />

					</form>
				</div>
			</div>
			<div class="box categories">
				<h2 id="h2">Categories <span></span></h2>
				<div class="box-content">
					<?php
					$sql = "SELECT * FROM progroup";
					$query= mysql_query($sql);
					if(mysql_num_rows($query)==0){

					}else {
						while($row=mysql_fetch_array($query)){
							?>
							<ul>
								<li><a href="index.php?page=nhanhieugiay&group=<?php echo $row['gro_id'];?>"><?php echo $row['gro_name']; ?></a></li>
							</ul>
							<?php
						}
					}
					?>	
				</div>
			</div>

		</div>
		<!-- End Sidebar -->
		<article>
			<?php
			if (isset($_GET['submit_tk'])) {
				$tk=addslashes($_GET['tukhoa']);
				if(empty($tk)){
					echo "<script>alert(\"Bạn hãy nhập từ tìm kiếm\")</script>";
				}
				else{
					if(!isset($_GET['trang'])){
						$trang=1;
					}
					else{
						$trang=$_GET['trang'];
					}
					$max_result=5;
					$index_row=$trang*$max_result-$max_result;

					$sql="SELECT * FROM product INNER JOIN progroup ON product.gro_id = progroup.gro_id where pro_name like '%$tk%' limit $index_row,$max_result";
					$query=mysql_query($sql);
					$num_row=mysql_num_rows($query);

					if($num_row>0 && $tk!=""){
						?>
						<div id="products-wrapper">
							<h1 id="prod">Sản phẩm</h1>
							<div class="products">
								<?php
								while ($row=mysql_fetch_array($query)) {
									?>
									<div class="product">
										<form method="post" action="cart_update.php">
											<div class="product-thumb">
												<img width="150px;" src="hinhanh/<?php echo $row['pro_image']; ?> "/>
											</div>
											<div class="product-content"><h3><?php echo $row['pro_name']; ?></h3>
												<div class="product-desc"><?php echo $row['pro_description']; ?>
												</div>
												<div class="product-desc"><?php echo $row['gro_name']; ?>	
												</div>
												<div class="product-info">
													Giá: <?php echo number_format($row['pro_price']); ?> | 
													<a href="addcart.php?id=<?php echo $row['pro_id']; ?>">Thêm vào giỏ hàng</a>
												</div>
											</div>
											<input type="hidden" name="product_code" value='<?php echo $row["pro_id"]; ?>' />
										</form>
									</div>
									<?php            
								}			
								?>
							</div>
							<div class="shopping-cart">
								<h2>Your Shopping Cart</h2>
								<?php
								$ok=1;
								if(isset($_SESSION['cart'])){
									foreach($_SESSION['cart'] as $k=>$v)
									{
										if(isset($k))
										{
											$ok=2;
										}
									}
								}

								if ($ok != 2)
								{
									echo '<p>Ban khong co mon hang nao trong gio hang</p>';
								} else {
									$items = $_SESSION['cart'];
									echo '<p id="cart-info">Ban dang co <a href="index.php?page=cart">'.count($items).' mon hang trong gio hang</a></p>';
								}
								?>
							</div>
						</div>
						<div id="trang">
							<hr>
							<?php
							$total_row=mysql_num_rows(mysql_query("SELECT * FROM product INNER JOIN progroup ON product.gro_id = progroup.gro_id where pro_name like '%$tk%' "));
							$total_trang=ceil($total_row/$max_result);
							$list_trang='';
							for($i=1; $i<=$total_trang; $i++){
								if($trang == $i){
									$list_trang .= "<b>$i </b>";
								}
								else{
									$list_trang .= "<a href=".$_SERVER['PHP_SELF']."?tukhoa=adidas&submit_tk=Search&trang=$i>".$i." </a>";
								}
							}
							echo "<p id='num'>$list_trang</p>";
							?>
						</div>
						<?php
					}else{
						echo "<script>alert(\"Không tìm thấy kết quả tương ứng\")</script>";
					}
				}
			}
			else{		
				if(!isset($_GET['page'])){
					include 'home.php';
				}
				else{				
					if($_GET['page']=='thanhtoan')
						include_once 'thanh-toan.php';

					if($_GET['page']=='cart')
						include_once 'cart.php';

					if($_GET['page']=='account')
						include_once 'account.php';

					if($_GET['page']=='changepassword')
						include_once 'changepassword.php';

					if($_GET['page']=='chitietsp')
						include_once 'chitietsanpham.php';	

					if($_GET['page']=='xoasp')
						include_once 'xoa-sp.php';

					if($_GET['page']=='suasp')
						include_once 'sua-sp.php';

					if($_GET['page']=='themsp')
						include_once 'them-sp.php';

					if($_GET['page']=='gioithieu')
						include 'gioi-thieu.php';

					if($_GET['page']=='giohang')
						include 'gio-hang.php';

					if($_GET['page']=='nhanhieugiay')
						include 'nhan-hieu-giay.php'; 

					if($_GET['page']=='xuly')
						include 'xuly.php';

					if($_GET['page']=='logout')
						include 'logout.php';
				}
			}	
			?>
		</article>
		<footer>
			<div id="footer">
				<p class="left">
					<a href="index.php">Home</a>
					<span>|</span>
					<a href="https://www.facebook.com/profile.php?id=100010235921601">Contact with Facebook</a>
				</p>
				<p class="right">
					Copyright @ 2016
					Design by TVĐ
				</p>
			</div>
		</footer>
	</feildset>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
	<script src="js/bootstrap.min.js"></script>

</body>
</html>