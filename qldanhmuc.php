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
if(isset($_POST['submit_update'])){
  $iddm=$_POST['groid'];
  $tendm=$_POST['groname'];
  $query1=mysql_query("select * from progroup where gro_name like'$tendm'");
  if(mysql_num_rows($query1)>0){
    echo "<meta http-equiv=\"refresh\" content=\"0\">";
    echo "<script>alert('Ten danh muc da ton tai')</script>";
  }else{
    $sql1="update progroup set gro_name='$tendm' where gro_id=$iddm";
    $query1=mysql_query($sql1);
    if($query1){
      echo "<meta http-equiv=\"refresh\" content=\"0\">";
      echo "<script>alert('Thành công')</script>";
    }else{
      echo "<script>alert('Xin vui lòng tử lại')</script>";
    }
  }
}

if(isset($_POST['submit_xoadm'])){
  $iddm=$_POST['groid'];
  $query2=mysql_query("select * from product where gro_id=$iddm");
  if(mysql_num_rows($query2)>0){
    echo "<meta http-equiv=\"refresh\" content=\"0\">";
    echo "<script>alert('Bạn không thể xóa danh mục này')</script>";
  }else{
    $sql="delete from progroup where gro_id=$iddm";
    $query=mysql_query($sql);
    if($query){
      echo "<meta http-equiv=\"refresh\" content=\"0\">";
      echo "<script>alert('Thành công')</script>";
    }else{
      echo "<script>alert('Xin vui lòng tử lại')</script>";
    }
  }
}

if(isset($_POST['submit_add'])){
  $tendm=$_POST['groname'];
  $query1=mysql_query("select * from progroup where gro_name like'$tendm'");
  if(mysql_num_rows($query1)>0){
    echo "<meta http-equiv=\"refresh\" content=\"0\">";
    echo "<script>alert('Ten danh muc da ton tai')</script>";
  }else{
    $sql="insert into progroup(gro_name) values('$tendm')";
    $query=mysql_query($sql);
    if($query){
      echo "<meta http-equiv=\"refresh\" content=\"0\">";
      echo "<script>alert('Thành công')</script>";
    }else{
      echo "<script>alert('Xin vui lòng tử lại')</script>";
    }
  }
}
$sql="select * from progroup";
$query=mysql_query($sql);
$num_row=mysql_num_rows($query);
?>

<div class="container">
  <div class="row">
    <div class="panel panel-primary filterable">
      <div class="panel-heading">
        <h3 class="panel-title">Quản lý danh mục</h3>
        <div class="pull-right">
          <button class="btn btn-default btn-xs btn-filter"><span class="glyphicon glyphicon-filter"></span> Filter</button>
          <button style="" class="btn btn-default btn-xs" data-title="Add" data-toggle="modal" data-target="#add" >Thêm danh mục (+)</button>
        </div>
      </div>
      <table id="mytable" class="table">
        <thead>
          <tr class="filters">
            <th><input type="text" class="form-control" placeholder="Mã danh mục" disabled></th>
            <th><input type="text" class="form-control" placeholder="Tên danh mục" disabled></th>
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
                <td><?php echo $row['gro_id']; ?></td>
                <td><?php echo $row['gro_name']; ?></td>
                <td align="center"><a class="btn btn-primary btn-xs" data-title="Edit" data-toggle="modal" data-target="#edit<?php echo $row['gro_id']; ?>" ><span class="glyphicon glyphicon-pencil"></span></a></td>
                <td align="center"><a class="btn btn-danger btn-xs" data-title="Delete" data-toggle="modal" data-target="#delete<?php echo $row['gro_id']; ?>" ><span class="glyphicon glyphicon-trash"></span></a></td>

                <div class="modal fade" tabindex="-1" role="dialog" aria-labelledby="edit" aria-hidden="true" id="edit<?php echo $row['gro_id']; ?>">
                  <div class="modal-dialog">
                    <div class="modal-content">
                      <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></button>
                        <h4 class="modal-title custom_align" id="Heading">Edit Your Detail</h4>
                      </div>
                      <form method="POST">
                        <div class="modal-body">
                          <div class="form-group">
                            <input class="form-control " name="groid" type="hidden" value="<?php echo $row['gro_id']; ?>">
                          </div>
                          <div class="form-group">

                            <input class="form-control " name="groname" type="text" value="<?php echo $row['gro_name']; ?>">
                          </div>
                        </div>
                        <div class="modal-footer ">
                          <button type="submit" name="submit_update" class="btn btn-warning btn-lg" style="width: 100%;"><span class="glyphicon glyphicon-ok-sign"></span> Update</button>
                        </div>
                      </form>
                    </div>
                    <!-- /.modal-content --> 
                  </div>
                  <!-- /.modal-dialog --> 
                </div>

                <div class="modal fade" tabindex="-1" role="dialog" aria-labelledby="delete" aria-hidden="true" id="delete<?php echo $row['gro_id']; ?>">
                  <div class="modal-dialog">
                    <div class="modal-content">
                      <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></button>
                        <h4 class="modal-title custom_align" id="Heading">Xóa danh mục</h4>
                      </div>
                      <form method="POST">
                        <div class="modal-body">
                          <div class="form-group">
                            <input class="form-control " name="groid" type="hidden" value="<?php echo $row['gro_id']; ?>">
                          </div>
                          <div class="alert alert-danger"><span class="glyphicon glyphicon-warning-sign"></span> Are you sure you want to delete <?php echo $row['gro_name']; ?>?</div>

                        </div>
                        <div class="modal-footer ">
                          <button type="submit" name="submit_xoadm" class="btn btn-success" ><span class="glyphicon glyphicon-ok-sign"></span> Yes</button>
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
<div class="modal fade" id="add" tabindex="-1" role="dialog" aria-labelledby="edit" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></button>
        <h4 class="modal-title custom_align" id="Heading">Thêm danh mục</h4>
      </div>
      <form method="POST">
        <div class="modal-body">

          <div class="form-group">
            Tên danh mục:<input class="form-control " style="float:right; width:470px; " name="groname" type="text">
          </div>
        </div>
        <div class="modal-footer ">
          <button type="submit" name="submit_add" class="btn btn-warning btn-lg" style="width: 100%;"><span class="glyphicon glyphicon-ok-sign"></span> Add</button>
        </div>
      </form>
    </div>
    <!-- /.modal-content --> 
  </div>
  <!-- /.modal-dialog --> 
</div>


