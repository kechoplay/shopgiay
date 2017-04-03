<?php
$idsp=$_GET['proid'];
$sql1="select * from product join orderdetail on product.pro_id=orderdetail.pro_id join orders on orderdetail.ord_id=orders.ord_id where product.pro_id=$idsp";
$query1=mysql_query($sql1);
$row=mysql_fetch_array($query1);
$anh=$row['pro_image'];
if(mysql_num_rows($query1)>0){
	
	echo "<script>alert('Bạn không thể xóa sản phẩm này')</script>";
}else{
echo "hinhanh/".$anh;
	$sql="delete from product where pro_id=$idsp";
	$sql2="delete from feedback where pro_id=$idsp";
	$query2=mysql_query($sql2);
	$query=mysql_query($sql);
	unlink("hinhanh/".$anh);
	header("location:admin.php");
}
?>