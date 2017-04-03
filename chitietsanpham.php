<?php
if (isset($_SESSION['Name1'])) {
	$ten=$_SESSION['Name1'];
	$sql3="select * from member where username='$ten'";
	$query3=mysql_query($sql3);
	$row3=mysql_fetch_array($query3);
	$idmem=$row3['cus_id'];	
}

$idsp=$_GET['id'];
$sql="SELECT * FROM product JOIN progroup ON product.gro_id = progroup.gro_id where pro_id=$idsp";
$query=mysql_query($sql);
$row=mysql_fetch_array($query);

$sql2="select * from feedback JOIN member on feedback.cus_id=member.cus_id JOIN product on feedback.pro_id=product.pro_id where feed_status = 1 and product.pro_id=$idsp order by feed_id desc";
$query2=mysql_query($sql2);
$num_row=mysql_num_rows($query2);

if(isset($_POST['submit_name'])){
	$content=$_POST['txtcontent'];
	if($content!=""){
		$sql4="insert into feedback(cus_id,pro_id,feed_content) values ('$idmem','$idsp','$content')";
		$query4=mysql_query($sql4);
		echo "<meta http-equiv=\"refresh\" content=\"0\">";
		if($query4){
			echo "<script>alert('cảm ơn bạn đã cho chúng tôi những lời khuyên có ích')</script>";
		}
		else{
			echo "<script>alert('Bạn hãy thử lại đi')</script>";
		}
	}
}
?>
<div id="bod">
	<div id="tieude"><h2 style="font-size:30px;">Chi tiết sản phẩm</h2></div>
	<div id="info">
		<div id="imagesp"><img width="200px;" src="hinhanh/<?php echo $row['pro_image']; ?>"/></div>
		<div id="infosp">
			<div id="name">[<?php echo $row['pro_name']; ?>]</div>
			<div id="nhanhieu">-Nhãn hiệu: <?php echo $row['gro_name']; ?></div>
			<div id="gia">-Giá: <?php echo number_format($row['pro_price']); ?> VND</div>
		</div>		
	</div>	
	<div id="danhgia">
		<div class="containers">
			<div class="row">
				<div class="col-sm-12">
					<h4>User Comment Example</h4>
				</div>
			</div>
			<?php
			if(isset($_SESSION['Name1'])){

				?>
				<div class="row">
					<div class="col-sm-1">
						<div class="thumbnail">
							<img class="img-responsive user-photo" src="hinhanh/avatar_2x.png">
						</div>
					</div>
					<div class="col-sm-5">
						<div class="panel panel-default">
							<div class="panel-heading">
								<strong><?php echo $row3['fullname']; ?></strong>
							</div>
							<div class="panel-body" style="padding-bottom: 9px;">
								<form method="POST">
									<textarea id="txtarea" name="txtcontent"></textarea>
									<button type="submit" name="submit_name" class="btn btn-success green">Đăng</button>
								</form>
							</div>
						</div>
					</div>
				</div>

				<?php
			}while ($row2=mysql_fetch_array($query2)) {
				$getday=getdate();
				?>
				<div class="row">
					<div class="col-sm-1">
						<div class="thumbnail">
							<img class="img-responsive user-photo" src="hinhanh/avatar_2x.png">
						</div><!-- /thumbnail -->
					</div><!-- /col-sm-1 -->
					<div class="col-sm-5">
						<div class="panel panel-default">
							<div class="panel-heading">
								<strong><?php echo $row2['fullname']; ?></strong> <span class="text-muted">commented at <?php echo $row2['feed_date']; ?></span>
							</div>
							<div class="panel-body">
								<?php echo $row2['feed_content']; ?>
							</div><!-- /panel-body -->
						</div><!-- /panel panel-default -->
					</div><!-- /col-sm-5 -->
				</div><!-- /row -->
				<?php
			}
			?>
		</div><!-- /container -->
	</div>
</div>