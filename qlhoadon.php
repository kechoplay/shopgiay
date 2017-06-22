<script src="js/jquery-3.1.0.min.js"></script>
<script type="text/javascript">
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
$sql="select * from orders ";
$query=mysql_query($sql);
$num_row=mysql_num_rows($query);

if(isset($_POST['submit_xoahd'])){
  $idhd=$_POST['ordid'];
  $sql1="delete from orderdetail where ord_id=$idhd";
  $query1=mysql_query($sql1);
  $sqls="delete from orders where ord_id=$idhd";
  $querys=mysql_query($sqls);
  if($querys && $query1){
    echo "<meta http-equiv=\"refresh\" content=\"0\">";
    echo "<script>alert('Thành công')</script>";
  }else{
    echo "<meta http-equiv=\"refresh\" content=\"0\">";
    echo "<script>alert('Xin vui lòng tử lại')</script>";
  }
}

if(isset($_POST['submit_tt'])){
  $idhd=$_POST['ordid'];
  $tt=$_POST['stt'];
  $thucthi=mysql_query("select * from orders where ord_id=$idhd");
  $in=mysql_fetch_array($thucthi);
  if($in['ord_status']==0 || $in['ord_status']==1){
    $query1=mysql_query("update orders set ord_status=$tt where ord_id=$idhd");
    if($query1){
      echo "<meta http-equiv=\"refresh\" content=\"0\">";
      echo "<script>alert('Thành công')</script>";
    }else{
      echo "<meta http-equiv=\"refresh\" content=\"0\">";
      echo "<script>alert('Xin vui lòng tử lại')</script>";
    }
    // echo $in['ord_id'];
  }else{
    echo "<script>alert('Bạn k thể thay đổi trạng thái hóa đơn')</script>";
    // echo $in['ord_status'];
  }
}
?>

<div class="container">
  <div class="row">
    <div class="panel panel-primary filterable">
      <div class="panel-heading">
        <h3 class="panel-title">Quản lý hóa đơn</h3>
        <div class="pull-right">
          <button class="btn btn-default btn-xs btn-filter"><span class="glyphicon glyphicon-filter"></span> Filter</button>
        </div>
      </div>
      <table id="mytable" class="table">
        <thead>
          <tr class="filters">
            <th width="6%"><input type="text" class="form-control" placeholder="ID" disabled></th>
            <th><input type="text" class="form-control" placeholder="Tên khách hàng" disabled></th>
            <th><input type="text" class="form-control" placeholder="Mobile" disabled></th>
            <th width="18%"><input type="text" class="form-control" placeholder="Địa chỉ" disabled></th>
            <th><input type="text" class="form-control" placeholder="Ngày mua" disabled></th>
            <th><input type="text" class="form-control" placeholder="Phương thức TT" disabled></th>
            <th><input type="text" class="form-control" placeholder="Trạng thái" disabled></th>
            <th text-align="center" width="5px"></th>
            <th text-align="center" width="5px"></th>
          </tr>
        </thead>
        <tbody>
          <?php
          if($num_row>0){
            while ($row=mysql_fetch_array($query)) {
              ?>
              <form method="POST">
                <tr>
                  <td><input type="hidden" name="ordid" value="<?php echo $row['ord_id']; ?>"/><?php echo $row['ord_id']; ?></td>
                  <td><?php echo $row['name']; ?></td>
                  <td><?php echo $row['mobile']; ?></td>
                  <td><?php echo $row['address']; ?></td>
                  <td><?php echo $row['ord_date']; ?></td>
                  <td>
                    <?php 
                    if($row['ord_payment']==1)
                    { 
                      echo "Thanh toán qua thẻ";
                    } else if($row['ord_payment']==2)
                    {
                      echo "Thanh toán trực tiếp";
                    } ?>
                  </td>
                  <td>
                    <select name="stt">
                      <?php
                      if($row['ord_status']==0){
                        ?>
                        <option selected="selected" value="0">Chưa xử lý</option>
                        <option value="1">Đang xử lý</option>
                        <option value="2">Đã xử lý</option>
                        <?php
                      }elseif ($row['ord_status']==1) {
                        ?>
                        <option value="0">Chưa xử lý</option>
                        <option selected="selected" value="1">Đang xử lý</option>
                        <option value="2">Đã xử lý</option>
                        <?php
                      }else{
                        ?>
                        <option value="0">Chưa xử lý</option>
                        <option value="1">Đang xử lý</option>
                        <option selected="selected" value="2">Đã xử lý</option>
                        <?php
                      }
                      ?>
                    </select>
                  </td>
                  <td align="center">
                    <button type="submit" name="submit_tt" class="btn btn-success btn-xs" ><span class="glyphicon glyphicon-upload"></span></button>
                  </td>
                  <td align="center">
                    <a href="admin.php?page=chitiethoadon&ordid=<?php echo $row['ord_id']; ?>" class="btn btn-primary btn-xs" ><span class="glyphicon glyphicon-pencil"></span></a>                    
                  </td>
                </form>

                           
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