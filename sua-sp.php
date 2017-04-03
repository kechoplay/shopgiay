<?php
$idsp= $_GET['pro_id'];
if(isset($_POST['submit_suasp'])){
    $tensp =$_POST["sua_tensp"];
    $giasp=$_POST["sua_giasp"];
    $motasp=$_POST["sua_chitietsp"];
    $dmsp=$_POST["iddm"];

    if($_FILES["sua_image_upload"]["name"]){
        $file_name=$_FILES["sua_image_upload"]["name"];
        $file_path=$_FILES["sua_image_upload"]["tmp_name"];
        $file_path_moi="hinhanh/".$file_name;
        $image_upload=move_uploaded_file($file_path, $file_path_moi);
        $imagesp=$file_name;
        $anhcu=$_POST["imagesp"];
        unlink("hinhanh/".$anhcu);
    }
    else{
        $imagesp=$_POST["imagesp"];
    }

    $sql="update product set pro_name='$tensp', pro_price='$giasp',pro_image='$imagesp',pro_description='$motasp',gro_id='$dmsp' where pro_id=$idsp";
    $query=mysql_query($sql);
    header("location:admin.php");
}
else{
    $sql="select * from product where pro_id=$idsp";
    $query=mysql_query($sql);
    $row=mysql_fetch_array($query);

    $sql1="select * from progroup";
    $query1=mysql_query($sql1);
}
?>
<form method="post" enctype="multipart/form-data">
	<table width="850px" id="main-contentsp" border="0px" cellpadding="0px" cellspacing="0px">
		<tr id="main-barsp" height="36px">
            <td colspan="2"><h2>Sửa sản phẩm</h2></td>
        </tr>
        <tr height="50">
            <td width="421" class="form"><label>Tên sản phẩm :</label></td>
            <td width="429"><input type="text" name="sua_tensp" value="<?php echo $row['pro_name']; ?>" required="required" /></td>
        </tr>
        <tr height="50">
            <td class="form"><label>Giá của sản phẩm :</label></td>
            <td><input type="text" name="sua_giasp" value="<?php echo $row['pro_price']; ?>" required="required" /></td>
        </tr>
        <tr height="50">
            <td class="form"><label>Ảnh sản phẩm :</label></td>
            <td><input type="file" name="sua_image_upload" /><input type="hidden" name="imagesp" value="<?php echo $row['pro_image']; ?>" /></td>
        </tr>
        <tr>
            <td class="form"><label>Mô tả sản phẩm :</label></td>
            <td><textarea name="sua_chitietsp" required="required"><?php echo $row["pro_description"]; ?></textarea></td>
        </tr>                
        <tr height="50">
            <td class="form"><label>Sản phẩm thuộc hãng :</label></td>
            <td>
                <select name="iddm" required="required">
                    <option value=0>--- Lựa chọn hãng ---</option>
                    <?php
                    while($row1=mysql_fetch_array($query1)){
                        ?>                            
                        <option value="<?php echo $row1["gro_id"];?>" <?php if($row["gro_id"]==$row1["gro_id"]){echo "selected=\"selected\"";} ?> ><?php echo $row1["gro_name"];?></option>
                        <?php
                    }
                    ?>                            
                </select>                    	
            </td>
        </tr>
        <tr height="50">
            <td class="form"></td>
            <td><input type="submit" name="submit_suasp" value="Sửa sản phẩm" /> <input type="reset" name="reset_name" value="Làm mới" /></td>
        </tr>
    </table>
</form>