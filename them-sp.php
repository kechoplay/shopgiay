<?php
$set_lang=mysql_query("SET NAMES 'utf8'");
if(isset($_POST["submit_name"])){
	
	if($_POST["tensp"]){
		$ten_sp = $_POST["tensp"];
	}else{
		$bao_loi = "Không được để trống trường nội dung nào!";
	}

	if($_POST["giasp"]){
		$gia_sp = $_POST["giasp"];
	}else{
		$bao_loi = "Không được để trống trường nội dung nào!";
	}
	
	if($_POST["iddm"] !=0){
		$id_dm = $_POST["iddm"];
	}else{
		$bao_loi = "Không được để trống trường nội dung nào!";
	}

	if($_FILES["image_upload"]["name"]){
		$image_name = $_FILES["image_upload"]["name"];
		$image_path = $_FILES["image_upload"]["tmp_name"];
	}else{
		$bao_loi = "Không được để trống trường nội dung nào!";
	}

	if($_POST["chitietsp"]){
		$chitiet_sp = $_POST["chitietsp"];
	}else{
		$bao_loi = "Không được để trống trường nội dung nào!";
	}

	if($bao_loi){
		echo "<script>alert(\"$bao_loi\")</script>";
		echo "<meta http-equiv=\"refresh\" content=\"0;url=admin.php\">";
	}else{	
		$new_image_path = "hinhanh/".$image_name;
		$image_upload = move_uploaded_file($image_path, $new_image_path);

		$sql = "INSERT INTO product(pro_name,pro_price,pro_image,pro_description,gro_id) 
		VALUES('$ten_sp', '$gia_sp', '$image_name', '$chitiet_sp', '$id_dm')";
		$query = mysql_query($sql);
		header("location:admin.php?page=themsp");
		echo "<script>alert(\"Thành công\")</script>";
	}
}
else{
	$sql = "SELECT * FROM progroup";
	$query = mysql_query($sql);
}
?>
<form method="post" enctype="multipart/form-data">
	<table width="850px" id="main-contentsp" border="0px" cellpadding="0px" cellspacing="0px">
		<tr id="main-barsp" height="36px">
			<td colspan="2"><h2>Thêm sản phẩm mới</h2></td>
		</tr>
		<tr height="50">
			<td width="421" class="form"><label>Tên sản phẩm :</label></td>
			<td width="429"><input type="text" name="tensp" required="required" /></td>
		</tr>
		<tr height="50">
			<td class="form"><label>Giá của sản phẩm :</label></td>
			<td><input type="text" name="giasp" required="required" /></td>
		</tr>
		<tr height="50">
			<td class="form"><label>Ảnh sản phẩm :</label></td>
			<td><input type="file" name="image_upload" required="required" /></td>
		</tr>
		<tr>
			<td class="form"><label>Mô tả sản phẩm :</label></td>
			<td><textarea name="chitietsp" required="required"></textarea></td>
		</tr>                
		<tr height="50">
			<td class="form"><label>Sản phẩm thuộc hãng :</label></td>
			<td>
				<select name="iddm">
					<option value=0 selected="selected">--- Lựa chọn hãng giầy ---</option>
					<?php
					while($row = mysql_fetch_array($query)){
						?>                            
						<option value="<?php echo $row['gro_id'];?>"><?php echo $row["gro_name"];?></option>
						<?php
					}
					?>                            
				</select>                    	
			</td>
		</tr>
		<tr height="50">
			<td class="form"></td>
			<td><input type="submit" name="submit_name" value="Thêm sản phẩm" /> <input type="reset" name="reset_name" value="Làm mới" /></td>
		</tr>
	</table>
</form>