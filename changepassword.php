<!-- <script type="text/javascript">
    function validateForm()
    {
        var op = document.getElementById('oldpass').value;
        var np = document.getElementById('newpass').value;
        var rnp = document.getElementById('re-newpass').value;
        
        if (op == ''){
            alert('Bạn chưa nhập nhập mật khẩu cũ');
        }
        else if (np=='') {
            alert('Bạn chưa nhập nhập mật khẩu mới');
        }
        else if (rnp=='') {
            alert('Bạn chưa nhập nhập lại mật khẩu mới');
        }
        else if(np!=rnp){
            alert('Mật khẩu không giống nhau');
        }
        
        return false;
    }
</script> -->
<?php
if(isset($_SESSION['Name1']) && $_SESSION['Pass1']){
    $name=$_SESSION['Name1'];    
    $pass=$_SESSION['Pass1'];
    $thucthi=mysql_query("select * from member where username='$name'");
    $row=mysql_fetch_array($thucthi);
    $id=$row['cus_id'];

    $error=array();
    $data=array();
    if(isset($_POST['changepass'])){
        $opw=md5(addslashes($_POST['oldpass']));
        $npw=md5(addslashes($_POST['newpass']));
        $rpw=md5(addslashes($_POST['re-newpass']));

        $data['oldpass']=isset($_POST['oldpass']) ? $_POST['oldpass'] : '';
        $data['newpass']=isset($_POST['newpass']) ? $_POST['newpass'] : '';
        $data['re-newpass']=isset($_POST['re-newpass']) ? $_POST['re-newpass'] : '';

        if(empty($data['oldpass'])){
            $error['oldpass']='Bạn chưa nhập mật khẩu cũ';
        }elseif($opw!=$pass){
            $error['oldpass']='Mật khẩu cũ không trùng khớp';
        }
        if(empty($data['newpass'])){
            $error['newpass']='Bạn chưa nhập mật khẩu mới';
        }elseif (!preg_match("/^[A-Z]{1}[a-zA-Z0-9]{6,32}$/", $_POST['newpass'])){
            $error['newpass']='Mật khẩu bắt đầu bằng chữ in hoa và có từ 6 đến 32 kí tự';
        }
        if(empty($data['re-newpass'])){
            $error['re-newpass']='Bạn chưa nhập lại mật khẩu mới';
        }
        if($npw!=$rpw){
            $error['re-newpass']='Mật khẩu mới không trùng nhau';
        }
        if(!$error){
            $sql="update member set password='$npw' where cus_id='$id' ";
            $query=mysql_query($sql);
            $_SESSION['Pass1']=$npw;
            echo "<meta http-equiv=\"refresh\" content=\"0\">";
            echo '<script>alert("Thành công")</script>';

        }else{
            
        }
    }
}
?>

<form action="" id="formResetPass" method="POST" name="form" onsubmit="return validateForm()">
    <legend>Đổi mật khẩu</legend>

    <div class="form-group">
        <label for="">Mật khẩu cũ</label>
        <input type="password" class="form-control" id="oldpass" name="oldpass" placeholder="Input field">
        <?php echo isset($error['oldpass']) ? $error['oldpass'] : ''; ?>
    </div>
    <div class="form-group">
        <label for="">Mật khẩu mới</label>
        <input type="password" class="form-control" id="newpass" name="newpass" placeholder="Input field">
        <?php echo isset($error['newpass']) ? $error['newpass'] : ''; ?>
    </div>
    <div class="form-group">
        <label for="">Nhập lại mật khẩu mới</label>
        <input type="password" class="form-control" id="re-newpass" name="re-newpass" placeholder="Input field">
        <?php echo isset($error['re-newpass']) ? $error['re-newpass'] : ''; ?>
    </div>
    <button type="submit" class="btn btn-primary" name="changepass">Thay đổi</button>
</form>