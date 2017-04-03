<?php
if(isset($_SESSION['Name1']) && $_SESSION['Pass1']){
    $user=$_SESSION['Name1'];
    $pass=$_SESSION['Pass1'];
    $sql="select * from member where username='$user'";
    $query=mysql_query($sql);
    $row=mysql_fetch_array($query);
    $id=$row['cus_id'];

    $error = array();
    $data=array();
    if(isset($_POST['account'])){
        $username=$_POST['username'];
        $fullname=$_POST['fullname'];
        $email=$_POST['email'];
        $address=$_POST['address'];
        $mobile=$_POST['mobile'];

        $data['username']= isset($_POST['username']) ? $_POST['username'] : '';
        $data['fullname']= isset($_POST['fullname']) ? $_POST['fullname'] : '';
        $data['email']= isset($_POST['email']) ? $_POST['email'] : '';
        $data['address']= isset($_POST['address']) ? $_POST['address'] : '';
        $data['mobile']= isset($_POST['mobile']) ? $_POST['mobile'] : '';

        if(empty($data['username'])){
            $error['username']='Không được để trống';
        }
        if(empty($data['fullname'])){
            $error['fullname']='Không được để trống';
        }
        if(empty($data['email'])){
            $error['email']='Không được để trống';
        }elseif (!preg_match("/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,4})$/", $email)) {
            $error['email']='Email chưa đúng định dạng';
        }
        if(empty($data['address'])){
            $error['address']='Không được để trống';
        }
        if(empty($data['mobile'])){
            $error['mobile']='Không được để trống';
        }

        if(!$error){
            $sql2="update member set username='$username',fullname='$fullname',email='$email',address='$address',mobile='$mobile' where cus_id='$id'";
            $query2=mysql_query($sql2);
            $_SESSION['Name1']=$username;
            echo "<meta http-equiv=\"refresh\" content=\"0\">";
            echo '<script>alert("Thành công")</script>';
        }
    }
}
?>
<form action="" method="POST">
    <legend>Thông tin cá nhân</legend>
    <div class="form-group">
        <label for="">Tên đăng nhập</label>
        <input type="text" class="form-control" id="username" name="username" value="<?php echo $row['username']; ?>" placeholder="Input field" >
        <?php echo isset($error['username']) ? $error['username'] : ''; ?>
    </div>
    <div class="form-group">
        <label for="">Mật khẩu</label>
        <input type="password" class="form-control" disabled="" value="<?php echo $row['password']; ?>" placeholder="Input field">
    </div>
    <div class="form-group">
        <label for="">Tên đầy đủ</label>
        <input type="text" class="form-control" id="fullname" name="fullname" value="<?php echo $row['fullname']; ?>" placeholder="Input field" required="">
        <?php echo isset($error['fullname']) ? $error['fullname'] : ''; ?>
    </div>
    <div class="form-group">
        <label for="">Email</label>
        <input type="email" class="form-control" id="email" name="email" value="<?php echo $row['email']; ?>" placeholder="Input field" required="">
        <?php echo isset($error['email']) ? $error['email'] : ''; ?>
    </div>
    <div class="form-group">
        <label for="">Địa chỉ</label>
        <input type="text" class="form-control" id="address" name="address" value="<?php echo $row['address']; ?>" placeholder="Input field" required="">
        <?php echo isset($error['address']) ? $error['address'] : ''; ?>
    </div>
    <div class="form-group">
        <label for="">Số điện thoại</label>
        <input type="text" class="form-control" id="mobile" name="mobile" value="<?php echo $row['mobile']; ?>" placeholder="Input field" required="">
        <?php echo isset($error['mobile']) ? $error['mobile'] : ''; ?>
    </div>
    <button type="submit" class="btn btn-primary" name="account">Cập nhật</button>
</form>