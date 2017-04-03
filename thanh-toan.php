<!-- <meta http-equiv="refresh" content="5;url=http://localhost/project/index.php" /> -->
<?php
$ok=1;
if (isset($_SESSION['cart'])) {
	foreach ($_SESSION['cart'] as $key => $value) {
		if (isset($key)) {
			$ok=2;
		}
	}
}
if(isset($_POST["submit_name"])){
	$cusid=0;
	if(isset($_SESSION['Name1']) && $_SESSION['Pass1']){
		$namedn=$_SESSION['Name1'];
		$caulenh="select * from member where username like '$namedn'";
		$thucthi=mysql_query($caulenh);
		$fetch=mysql_fetch_array($thucthi);
		$cusid=$fetch['cus_id'];
		// echo $cusid;
	}
	// else{
	// 	$cusid=0;
	// 	// echo $cusid;
	// }

	if(!isset($_SESSION['cart'])){
		echo "<script>alert('Bạn chưa cóa mặt hàng nào trong giỏ hàng. Xin mời mua một mặt hàng')</script>";
	}else{

		if($_POST['tenkh']){
			$tenkh=$_POST['tenkh'];
		}else {
			$bao_loi="Không được để chống nội dung nào";
		}
		if($_POST['diachikh']){
			$diachikh=$_POST['diachikh'];
		}else{
			$bao_loi="Không được để chống nội dung nào";
		}
		if($_POST['sdtkh']){
			$sdtkh=$_POST['sdtkh'];
		}else{
			$bao_loi="Không được để chống nội dung nào";
		}
		if($_POST['tt']!=0){
			$tt=$_POST['tt'];
		}else{
			$bao_loi="Không được để chống nội dung nào";
		}
		if(isset($bao_loi)){
			echo "<script>alert(\"$bao_loi\")</script>";
			echo "<meta http-equiv=\"refresh\" content=\"0;url=index.php?page=thanhtoan\">";
		}else{		
			$sql = "insert into orders(cus_id,name,mobile,address,ord_payment) values ('$cusid','$tenkh','$sdtkh','$diachikh','$tt')";
			$query = mysql_query($sql);
			$last_id=mysql_insert_id($conn);
			foreach ($_SESSION['cart'] as $key => $value) {
				$sql3 = "SELECT * FROM product WHERE pro_id = $key";
				$query3 = mysql_query($sql3);
				$row3 = mysql_fetch_array($query3);
				$price=$row3['pro_price'];

				$sql2='insert into orderdetail(ord_id,pro_id,number,price) ';
				$sql2.='values ("'.$last_id.'","'.$key.'","'.$_SESSION['cart'][$key].'","'.$price.'")';
				mysql_query($sql2);
			// header("location:index.php?page=thanhtoan");
			}
			unset($_SESSION['cart']);
			echo "<script>alert('Thanh cong')</script>";
			echo "<meta http-equiv=\"refresh\" content=\"0;url=index.php\">";
		}
	}

}else{

}

if($ok==2)
{
	?>
	<form method="post">
		<table width="850px" id="main-contentsp" border="0px" cellpadding="0px" cellspacing="0px">
			<tr id="main-barsp" height="36px">
				<td colspan="2"><h3>Thông tin mua hàng</h3></td>
			</tr>
			<?php
			if(isset($_SESSION["Name1"])){
				$tendangnhap=$_SESSION['Name1'];
				$sql4="select * from member where username like '$tendangnhap'";
				$query4=mysql_query($sql4);
				$row=mysql_fetch_array($query4);
				?>
				<tr height="50">
					<td width="421" class="form"><label>Họ tên khách hàng :</label></td>
					<td width="429"><input type="text" name="tenkh" required="required" value="<?php echo $row['fullname']; ?>" /></td>
				</tr>
				<tr height="50">
					<td class="form"><label>Địa chỉ :</label></td>
					<td><input type="text" name="diachikh" required="required" value="<?php echo $row['address']; ?>" /></td>
				</tr>
				<tr height="50">
					<td class="form"><label>Số điện thoại :</label></td>
					<td><input type="text" name="sdtkh" required="required" value="<?php echo $row['mobile'] ?>" /></td>
				</tr>

				<?php
			}
			?>
			<tr>
				<td class="form"><label>Phương thức thanh toán :</label></td>
				<td><select name="tt">
					<option value="0" selected="selected">
						--- Lựa chọn ---
					</option>
					<option value="1">
						Thanh toán qua thẻ
					</option>
					<option value="2">
						Thanh toán trực tiếp
					</option>
				</select></td>
			</tr>
			<tr height="50">
				<td class="form"></td>
				<td><input type="submit" name="submit_name" value="Thanh toán" /> <input type="reset" name="reset_name" value="Làm mới" /></td>
			</tr>
		</table>
	</form>
	<?php
}
else{
	?>

	<h3>Bạn hãy mua hàng để đc thanh toán <h3>
		<?php
	}
	?>

	<!-- <?php
// 	if(isset($_SESSION['Name1'])){
// 		$tendangnhap=$_SESSION['Name1'];
// 	} 
// 	$sql="select * from member where username like '$tendangnhap'";
// 	$query=mysql_query($sql);
// 	$row=mysql_fetch_array($query);
// 	$cusid=$row['cus_id'];
// 	$name=$row['fullname'];
// 	$mobi=$row['mobile'];
// 	$addr=$row['address'];
// 	$sql1="insert into orders(cus_id,name,mobile,address) values ('$cusid','$name','$mobi','$addr')";
// 	$query1=mysql_query($sql1);

// 	$last_id=mysql_insert_id($conn);
// 	foreach ($_SESSION['cart'] as $key => $value) {
// 		$sql3 = "SELECT * FROM product WHERE pro_id = $key";
// 		$query3 = mysql_query($sql3);
// 		$row3 = mysql_fetch_array($query3);
// 		$price=$row3['pro_price'];

// 		$sql2='insert into orderdetail(ord_id,pro_id,number,price) ';
// 		$sql2.='values ("'.$last_id.'","'.$key.'","'.$_SESSION['cart'][$key].'","'.$price.'")';
// 		mysql_query($sql2);
// 	}
// unset($_SESSION['cart']);
// 	echo "<h2>Cảm ơn bạn đã mua hàng ở cửa hàng chúng tôi.</h2>";
// 	?> -->