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
$sql="select * from feedback join member on feedback.cus_id=member.cus_id join product on feedback.pro_id=product.pro_id ";
$query=mysql_query($sql);
$num_row=mysql_num_rows($query);

if(isset($_POST['submit_xoaph'])){
  $idph=$_POST['feedid'];
  $sqls="delete from feedback where feed_id=$idph";
  $querys=mysql_query($sqls);
  if($querys){
    echo "<meta http-equiv=\"refresh\" content=\"0\">";
    echo "<script>alert('Thành công')</script>";
  }else{
    echo "<meta http-equiv=\"refresh\" content=\"0\">";
    echo "<script>alert('Xin vui lòng tử lại')</script>";
  }
}

if(isset($_POST['submit_ph'])){
  $idph=$_POST['feedid'];
  $tt=$_POST['stt'];
  $query1=mysql_query("update feedback set feed_status=$tt where feed_id=$idph");
  if($query1){
    echo "<meta http-equiv=\"refresh\" content=\"0\">";
    echo "<script>alert('Thành công')</script>";
  }else{
    echo "<meta http-equiv=\"refresh\" content=\"0\">";
    echo "<script>alert('Xin vui lòng tử lại')</script>";
  }
}
?>

<div class="container">
  <div class="row">
    <div class="panel panel-primary filterable">
      <div class="panel-heading">
        <h3 class="panel-title">Bình luận khách hàng</h3>
        <div class="pull-right">
          <button class="btn btn-default btn-xs btn-filter"><span class="glyphicon glyphicon-filter"></span> Filter</button>
        </div>
      </div>
      <table id="mytable" class="table">
        <thead>
          <tr class="filters">
            <th width="6%"><input type="text" class="form-control" placeholder="ID" disabled></th>
            <th><input type="text" class="form-control" placeholder="Tên khách hàng" disabled></th>
            <th><input type="text" class="form-control" placeholder="Tên sản phẩm" disabled></th>
            <th><input type="text" class="form-control" placeholder="Ngày viết" disabled></th>
            <th width="25%"><input type="text" class="form-control" placeholder="Nội dung" disabled></th>
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
                  <td><input type="hidden" name="feedid" value="<?php echo $row['feed_id']; ?>"/><?php echo $row['feed_id']; ?></td>
                  <td><?php echo $row['fullname']; ?></td>
                  <td><?php echo $row['pro_name']; ?></td>
                  <td><?php echo $row['feed_date']; ?></td>
                  <td><?php echo $row['feed_content']; ?></td>
                  <td>
                    <select name="stt">
                      <?php
                      if($row['feed_status']==0){
                        ?>
                        <option selected="selected" value="0">Chưa xử lý</option>
                        <option value="1">Phản hồi tốt</option>
                        <option value="2">Phản hồi kém</option>
                        <?php
                      }elseif ($row['feed_status']==1) {
                        ?>
                        <option value="0">Chưa xử lý</option>
                        <option selected="selected" value="1">Phản hồi tốt</option>
                        <option value="2">Phản hồi kém</option>
                        <?php
                      }else{
                        ?>
                        <option value="0">Chưa xử lý</option>
                        <option value="1">Phản hồi tốt</option>
                        <option selected="selected" value="2">Phản hồi kém</option>
                        <?php
                      }
                      ?>
                    </select>
                  </td>
                  <td align="center">
                    <button type="submit" name="submit_ph" class="btn btn-success btn-xs" ><span class="glyphicon glyphicon-upload"></span></button>
                  </td>
                  <td align="center">
                    <a class="btn btn-danger btn-xs" data-title="Delete" data-toggle="modal" data-target="#delete<?php echo $row['feed_id']; ?>" ><span class="glyphicon glyphicon-trash"></span></a>
                  </td>
                </form>

                <div class="modal fade" tabindex="-1" role="dialog" aria-labelledby="delete" aria-hidden="true" id="delete<?php echo $row['feed_id']; ?>">
                  <div class="modal-dialog">
                    <div class="modal-content">
                      <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></button>
                        <h4 class="modal-title custom_align" id="Heading">Xóa phản hồi</h4>
                      </div>
                      <form method="POST">
                        <div class="modal-body">
                          <div class="form-group">
                            <input class="form-control " name="feedid" type="hidden" value="<?php echo $row['feed_id']; ?>">
                          </div>
                          <div class="alert alert-danger"><span class="glyphicon glyphicon-warning-sign"></span> Are you sure you want to delete feedback <?php echo $row['feed_id']; ?>?</div>

                        </div>
                        <div class="modal-footer ">
                          <button type="submit" name="submit_xoaph" class="btn btn-success" ><span class="glyphicon glyphicon-ok-sign"></span> Yes</button>
                          <button type="button" class="btn btn-default" data-dismiss="modal"><span class="glyphicon glyphicon-remove"></span> No</button>
                        </div>
                      </form>
                    </div>
                    <!-- /.modal-content --> 
                  </div>
                  <!-- /.modal-dialog -->   
                </div>             
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