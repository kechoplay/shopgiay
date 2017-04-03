<?php
ob_start();
?>
<script src="js/jquery-3.1.0.min.js"></script>
<script type="text/javascript">
	function confirm_query() {
		if (window.confirm("Bạn có muốn xóa Không")) {
			return true;
		}else{
			return false;
		}
	}

	$(document).ready(function(){
		$('.filterable .btn-filter').click(function(){
			var $panel = $(this).parents('.filterable'),
			$filters = $panel.find('.filters input'),
			$tbody = $panel.find('.table tbody');
			if ($filters.prop('disabled') == true) {
				$filters.prop('disabled', false);
				$filters.first().focus();
			} else {
				$filters.val('').prop('disabled', true);
				$tbody.find('.no-result').remove();
				$tbody.find('tr').show();
			}
		});

		$('.filterable .filters input').keyup(function(e){
			var code = e.keyCode || e.which;
			if (code == '9') return;

			var $input = $(this),
			inputContent = $input.val().toLowerCase(),
			$panel = $input.parents('.filterable'),
			column = $panel.find('.filters th').index($input.parents('th')),
			$table = $panel.find('.table'),
			$rows = $table.find('tbody tr');

			var $filteredRows = $rows.filter(function(){
				var value = $(this).find('td').eq(column).text().toLowerCase();
				return value.indexOf(inputContent) === -1;
			});

			$table.find('tbody .no-result').remove();

			$rows.show();
			$filteredRows.hide();

			if ($filteredRows.length === $rows.length) {
				$table.find('tbody').prepend($('<tr class="no-result text-center"><td colspan="'+ $table.find('.filters th').length +'">No result found</td></tr>'));
			}
		});
	});
</script>
<?php
$sql="SELECT * FROM product INNER JOIN progroup ON product.gro_id = progroup.gro_id ";
$query=mysql_query($sql);
$num_row=mysql_num_rows($query);

if (isset($_SESSION['Name']) && $_SESSION['Pass']) {
	
	?>
	<div class="container">
		<div class="row">
			<div class="panel panel-primary filterable">
				<div class="panel-heading">
					<h3 class="panel-title">Quản lý sản phẩm</h3>
					<div class="pull-right">
						<button class="btn btn-default btn-xs btn-filter"><span class="glyphicon glyphicon-filter"></span> Filter</button>
						<a class="btn btn-default btn-xs" href="admin.php?page=themsp">Thêm sản phẩm (+)</a>
					</div>
				</div>
				<table class="table">
					<thead>
						<tr class="filters">
							<th><input type="text" class="form-control" placeholder="Tên sản phẩm" disabled></th>
							<th><input type="text" class="form-control" placeholder="Giá" disabled></th>
							<th><input type="text" class="form-control" placeholder="Hãng sản phẩm" disabled></th>
							<th><input type="text" class="form-control" placeholder="Ảnh mô tả" disabled></th>
							<th text-align="center" width="5%">Edit</th>
							<th text-align="center" width="5%">Delete</th>
						</tr>
					</thead>
					<tbody>
						<?php
						if($num_row>0){
							while ($row=mysql_fetch_array($query)) {
								?>
								<tr>
									<td><?php echo $row['pro_name']; ?></td>
									<td><?php echo number_format($row['pro_price']); ?></td>
									<td><?php echo $row['gro_name']; ?></td>
									<td><img width="120px" src="hinhanh/<?php echo $row['pro_image']; ?>"/></td>
									<td class="link" align="center"><a class="btn btn-primary btn-xs" href="admin.php?page=suasp&pro_id=<?php echo $row['pro_id']; ?>" ><span class="glyphicon glyphicon-pencil"></span></a></td>
									<td class="link" align="center"><a class="btn btn-danger btn-xs" onclick="return confirm_query()" href="admin.php?page=xoasp&proid=<?php echo $row['pro_id']; ?>"><span class="glyphicon glyphicon-trash"></span></a></td>
								</tr>
								<?php
							} 
						}else{
							echo "không có dữ liệu";
						}
						?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
	<?php
}else{
	header('location:index.php');
}
?>
