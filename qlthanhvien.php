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
  if(($_POST['username'] && $_POST['fullname'] && $_POST['email'] && $_POST['address'] && $_POST['mobile'])){
    $idtv=$_POST['cusid'];
    $us=$_POST['username'];
    $fn=$_POST['fullname'];
    $ad=$_POST['address'];
    $em=$_POST['email'];
    $mb=$_POST['mobile'];
    $sql1="update member set username='$us',fullname='$fn',address='$ad',email='$em',mobile='$mb' where cus_id=$idtv";
    $query1=mysql_query($sql1);
    if($query1){
      echo "<meta http-equiv=\"refresh\" content=\"0\">";
      echo "<script>alert('Thành công')</script>";
    }else{
      echo "<script>alert('Xin vui lòng tử lại')</script>";
    }
  }else{
    echo "<meta http-equiv=\"refresh\" content=\"0\">";
    echo "<script>alert('Không được để trống nội dung nào')</script>";
  }
}

if(isset($_POST['submit_xoa'])){
  $idtv=$_POST['cusid'];
  $sql2="select * from member join feedback on member.cus_id=feedback.cus_id where member.cus_id=$idtv";
  $query2=mysql_query($sql2);
  $sql3="select * from member join orders on member.cus_id=orders.cus_id where member.cus_id=$idtv";
  $query3=mysql_query($sql3);
  if(mysql_num_rows($query2)>0 || mysql_num_rows($query3)>0){
    echo "<script>alert('Bạn không thể xóa tai khoản này')</script>";
  }else{
    $sql="delete from member where cus_id=$idtv";
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
  if(!($_POST['username'] && $_POST['password'] && $_POST['fullname'] && $_POST['email'] && $_POST['address'] && $_POST['mobile'])){
    echo "<meta http-equiv=\"refresh\" content=\"0\">";
    echo "<script>alert('Không được để trống nội dung nào')</script>";
  }else{
    $us=$_POST['username'];
    $pw=md5($_POST['password']);
    $fn=$_POST['fullname'];
    $em=$_POST['email'];
    $ad=$_POST['address'];
    $mb=$_POST['mobile'];

    $error=array();
    $data=array();

    $data['username']= isset($_POST['username']) ? $_POST['username'] : '';
    $data['password']= isset($_POST['password']) ? $_POST['password'] : '';
    $data['fullname']= isset($_POST['fullname']) ? $_POST['fullname'] : '';
    $data['email']= isset($_POST['email']) ? $_POST['email'] : '';
    $data['address']= isset($_POST['address']) ? $_POST['address'] : '';
    $data['mobile']= isset($_POST['mobile']) ? $_POST['mobile'] : '';

    if ($us == 'admin'){
      $bao_loi=('Tên đăng nhập không phù hợp');
    }
    if (mysql_num_rows(mysql_query("SELECT username FROM member WHERE username='$us'")) > 0){
      $bao_loi=('Tên đăng nhập này đã có người dùng.');
    }
    if(!preg_match("/^[A-Z]{1}[a-zA-Z0-9]{6,32}$/", $_POST['password'])){
      $bao_loi=('Mật khẩu bắt đầu bằng chữ in hoa và có từ 6 đến 32 kí tự.');
    }
    if (!eregi("^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,4})$", $em)){
      $bao_loi=('Email này không hợp lệ. Vui long nhập email khác.');
    }
    if (mysql_num_rows(mysql_query("SELECT email FROM member WHERE email='$em'")) > 0){
      $bao_loi=('Email này đã có người dùng. Vui lòng chọn Email khác.');
    }
    if (!ereg("^[0-9]", $mb)){
      $bao_loi=('Số điện thoại không hợp lệ. Vui lòng nhập lại.');
    }

    if($bao_loi){
      echo "<script>alert(\"$bao_loi\")</script>";
    }else{
      $sql="insert into member(username,password,fullname,email,address,mobile) values('$us','$pw','$fn','$em','$ad','$mb')";
      $query=mysql_query($sql);
      if($query){
        echo "<meta http-equiv=\"refresh\" content=\"0\">";
        echo "<script>alert('Thành công')</script>";
      }else{
        echo "<meta http-equiv=\"refresh\" content=\"0\">";
        echo "<script>alert('Xin vui lòng thử lại')</script>";
      }
    }
  }
}
$sql="select * from member";
$query=mysql_query($sql);
$num_row=mysql_num_rows($query);
?>

<div class="container">
  <div class="row">
    <div class="panel panel-primary filterable">
      <div class="panel-heading">
        <h3 class="panel-title">Quản lý thành viên</h3>
        <div class="pull-right">
          <button class="btn btn-default btn-xs btn-filter"><span class="glyphicon glyphicon-filter"></span> Filter</button>
          <button style="" class="btn btn-default btn-xs" data-title="Add" data-toggle="modal" data-target="#add" >Thêm thành viên (+)</button>
        </div>
      </div>
      <table id="mytable" class="table">
        <thead>
          <tr class="filters">
            <th width="6%"><input type="text" class="form-control" placeholder="ID" disabled></th>
            <th><input type="text" class="form-control" placeholder="Tên đăng nhập" disabled></th>
            <th><input type="text" class="form-control" placeholder="Tên đầy đủ" disabled></th>
            <th><input type="text" class="form-control" placeholder="Địa chỉ" disabled></th>
            <th><input type="text" class="form-control" placeholder="Email" disabled></th>
            <th><input type="text" class="form-control" placeholder="Mobile" disabled></th>
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
                <td><?php echo $row['cus_id']; ?></td>
                <td><?php echo $row['username']; ?></td>
                <td><?php echo $row['fullname']; ?></td>
                <td><?php echo $row['address']; ?></td>
                <td><?php echo $row['email']; ?></td>
                <td><?php echo $row['mobile']; ?></td>
                <td align="center"><a class="btn btn-primary btn-xs" data-title="Edit" data-toggle="modal" data-target="#edit<?php echo $row['cus_id']; ?>" ><span class="glyphicon glyphicon-pencil"></span></a></td>
                <td align="center"><a class="btn btn-danger btn-xs" data-title="Delete" data-toggle="modal" data-target="#delete<?php echo $row['cus_id']; ?>" ><span class="glyphicon glyphicon-trash"></span></a></td>

                <div class="modal fade" tabindex="-1" role="dialog" aria-labelledby="edit" aria-hidden="true" id="edit<?php echo $row['cus_id']; ?>">
                  <div class="modal-dialog">
                    <div class="modal-content">
                      <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></button>
                        <h4 class="modal-title custom_align" id="Heading">Edit Your Detail</h4>
                      </div>
                      <form method="POST">
                        <div class="modal-body">
                          <div class="form-group">
                            <input class="form-control " name="cusid" type="hidden" value="<?php echo $row['cus_id']; ?>">
                          </div>
                          <div class="form-group">
                            <label>Tên đăng nhập:</label><input class="form-control " readonly name="username" type="text" required="" value="<?php echo $row['username']; ?>" >
                          </div>
                          <div class="form-group">
                            <label>Tên đầy đủ:</label><input class="form-control " readonly name="fullname" type="text" required="" value="<?php echo $row['fullname']; ?>">
                          </div>
                          <div class="form-group">
                            <label>Địa chỉ:</label><input class="form-control " readonly name="address" type="text" required="" value="<?php echo $row['address']; ?>">
                          </div>
                          <div class="form-group">
                            <label>Email:</label><input class="form-control " readonly name="email" type="text" required="" value="<?php echo $row['email']; ?>">
                          </div>
                          <div class="form-group">
                            <label>Mobile:</label><input class="form-control " readonly name="mobile" type="text" required="" value="<?php echo $row['mobile']; ?>" >
                          </div>
                        </div>
                      </form>
                    </div>
                    <!-- /.modal-content --> 
                  </div>
                  <!-- /.modal-dialog --> 
                </div>

                <div class="modal fade" tabindex="-1" role="dialog" aria-labelledby="delete" aria-hidden="true" id="delete<?php echo $row['cus_id']; ?>">
                  <div class="modal-dialog">
                    <div class="modal-content">
                      <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></button>
                        <h4 class="modal-title custom_align" id="Heading">Xóa thành viên</h4>
                      </div>
                      <form method="POST">
                        <div class="modal-body">
                          <div class="form-group">
                            <input class="form-control " name="cusid" type="hidden" value="<?php echo $row['cus_id']; ?>">
                          </div>
                          <div class="alert alert-danger"><span class="glyphicon glyphicon-warning-sign"></span> Are you sure you want to delete <?php echo $row['username']; ?>?</div>

                        </div>
                        <div class="modal-footer ">
                          <button type="submit" name="submit_xoa" class="btn btn-success" ><span class="glyphicon glyphicon-ok-sign"></span> Yes</button>
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
        <h4 class="modal-title custom_align" id="Heading">Thêm thành viên</h4>
      </div>
      <form method="POST">
        <div class="modal-body">

          <div class="form-group">
            Username:<input class="form-control " style=" width:470px; " value="<?php echo isset($data['username']) ? $data['username'] : ''; ?>"  name="username" type="text" required="">
            Password:<input class="form-control " style=" width:470px; " name="password" type="password" required="">
            Fullname:<input class="form-control " style=" width:470px; " value="<?php echo isset($data['fullname']) ? $data['fullname'] : ''; ?>" name="fullname" type="text" required="">
            Email:<input class="form-control " style=" width:470px; " value="<?php echo isset($data['email']) ? $data['email'] : ''; ?>" name="email" type="email" required="">
            Address:<input class="form-control " style=" width:470px; " value="<?php echo isset($data['username']) ? $data['address'] : ''; ?>" name="address" type="text" required="">
            Mobile:<input class="form-control " style=" width:470px; " value="<?php echo isset($data['mobile']) ? $data['mobile'] : ''; ?>" name="mobile" type="text" required="">
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


