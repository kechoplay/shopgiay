<script type="text/javascript">
	function confirm_query(){
		if(window.confirm('Bạn có muốn xóa không?')){
			return true;
		}else{
			return false;
		}
	}
	function validate(e) {
		if (
			(e.keyCode >= 48 && e.keyCode <= 57 && !e.shiftKey) ||
			e.keyCode === 8
			)
		{
			return true;
		}
		return false;
	}
</script>
<?php
$total_all = 0;
if(isset($_POST['submit_name'])){
	foreach($_POST['num'] as $id=>$prd){
		if(($prd == 0) and (is_numeric($prd))){
			unset($_SESSION['cart'][$id]);
		}
		elseif(($prd > 0) and (is_numeric($prd))){
			$_SESSION['cart'][$id] = $prd;
		}	
	}
}
?>
<h1> Đăng ký mua hàng</h1>
<p id="cart-info">
	<?php
	$ok=1;
	if(isset($_SESSION['cart']))
	{
		foreach($_SESSION['cart'] as $k => $v)
		{
			if(isset($k))
			{
				$ok=2;
			}
		}
	}
	if($ok == 2)
	{
		echo 'Thông tin chi tiết giỏ hàng của bạn';
	}
	else{
		echo 'Bạn chưa có mặt hàng nào. Sao bạn không vào <a id="linky" href="index.php">vpcart</a> để lựa chọn cho mình một mặt hàng!';
	}
	?>
</p>
<?php
$ok=1;
if(isset($_SESSION['cart']))
{
	foreach($_SESSION['cart'] as $k => $v)
	{
		if(isset($k))
		{
			$ok=2;
		}
	}
}
if($ok == 2)
{
	?>
	<form method="post" >

		<?php
		if(isset($_SESSION['cart']) != NULL){
			foreach($_SESSION['cart'] as $id=>$prd){
				$arr_id[] = $id;
			}

			$str_id = implode(',', $arr_id);
			$sql = "SELECT * FROM product WHERE pro_id IN ($str_id) ORDER BY pro_id ASC";
			$query = mysql_query($sql);
			while($row = mysql_fetch_array($query)){
				?>
				<div class="course-item">
					<p class="title">
						<span>Tên:</span> 
						<?php echo $row['pro_name'];?>
					</p>
					<p class="class">
						<span>Mô tả:</span> <?php echo $row['pro_description'];?>
					</p>
					<p class="price">
						<span>Giá:</span> 
						<span class="pr"><?php echo number_format($row['pro_price']);?> VNĐ</span>
					</p>
					<p class="number">
						<label><span>Số lượng:</span></label> 
						<input type="text" name="num[<?php echo $row['pro_id'];?>]" onkeydown="return validate(event)" value="<?php echo $_SESSION['cart'][$row['pro_id']];?>" size="5" />
						<a href="delcart.php?proid=<?php echo $row['pro_id'];?>">Hủy mặt hàng</a>
					</p>
					<p class="total">
						<span>Tổng số tiền cho đơn hàng : </span> 
						<span class="pr"><?php echo number_format($row['pro_price']*$_SESSION['cart'][$row['pro_id']]);?> VNĐ</span>
					</p>
				</div>
				<?php
				$total_all += $row['pro_price']*$_SESSION['cart'][$row['pro_id']];
			}
		}
	}
	?>
	<p><input type="submit" name="submit_name" value="Cập nhật giỏ hàng" /></p>
</form>
<p id="total-all"><span>Tổng giá trị cho các mặt hàng trong giỏ hàng của bạn là:</span> <span class="pr"><?php echo number_format($total_all);?> VNĐ</p>

<p id="footer-bar">» <a href="index.php">Tiếp tục đăng ký mặt hàng khác</a> » <a href="delcart.php?proid=0" onclick="return confirm_query()">Xóa giỏ hàng</a> 
	<?php
	if(isset($_SESSION['Name1']) && $_SESSION['Pass1']){

		?>
		» <a href="index.php?page=thanhtoan">Ngừng đăng ký và thanh toán</a></p>
		<?php
	}else{
		echo "» <a href='dang-nhap.php'>Bạn hãy đăng nhập để được thanh toán</a></p>";
	}
	?>