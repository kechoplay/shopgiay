<?php
$id=$_GET['ordid'];
$sql1="select * from orders where ord_id=$id";
$query1=mysql_query($sql1);
$row1=mysql_fetch_array($query1);

$sql="select * from orderdetail join orders on orderdetail.ord_id=orders.ord_id join product on orderdetail.pro_id=product.pro_id where orderdetail.ord_id=$id";
$query=mysql_query($sql);

$total=0;
?>

<p><h2 style="text-align:center;">Chi tiết hóa đơn</h2></p>
Tên khách hàng:<span><?php echo $row1['name']; ?></span><br>
Địa chỉ:<span><?php echo $row1['address']; ?></span><br>
Điện thoại:<span><?php echo $row1['mobile']; ?></span><br>
<style type="text/css">
	th,td{
		border: 1px thin black;
		padding: 5px;
	}
</style>
<table class="table table-hover">
	<thead>
		<tr>
			<th>Tên mặt hàng</th>
			<th>Số lượng</th>
			<th>Đơn giá</th>
			<th>Thành tiền</th>
		</tr>
	</thead>
	<tbody>
		<?php
		if($num_row=mysql_num_rows($query)>0){
			while($row=mysql_fetch_array($query)){
				?>
				<tr>

					<td><?php echo $row['pro_name']; ?></td>
					<td><?php echo $row['number']; ?></td>
					<td><?php echo number_format($row['price']); ?></td>
					<td><?php echo number_format($row['number']*$row['price']); ?></td>

				</tr>
				<?php
				$total+=$row['number']*$row['price'];
			}
		}else{
			echo "Không có dữ liệu";
		}
		?>
		<tr>
			<td colspan="3">Tổng tiền</td>
			<td><?php echo number_format($total); ?></td>
		</tr>
	</tbody>
</table>