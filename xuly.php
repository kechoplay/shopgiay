<?php
    ob_start();
    if (isset($_POST['submit_dangki'])){
    	if ($_POST['user_dangki'] && $_POST['pass_dangki'] && $_POST['repass_dangki'] && $_POST['fullname_dangki'] && $_POST['email_dangki'] && $_POST['mobile_dangki'] && $_POST['address_dangki']){
    		
			include('ketnoi.php');
   			
			$username = addslashes($_POST['user_dangki']);
    		$password = md5(addslashes($_POST['pass_dangki']));
			$re_password = md5(addslashes( $_POST['repass_dangki']));
			$fullname = addslashes($_POST['fullname_dangki']);
   			$email = addslashes($_POST['email_dangki']);
    		$mobile = addslashes($_POST['mobile_dangki']);
    		$address = addslashes($_POST['address_dangki']);
    
    		if ($username == 'admin'){
				echo "Tên đăng nhập không phù hợp. <a href='javascript: history.go(-1)'>Trở lại</a>";
				exit;
			}
			if (mysql_num_rows(mysql_query("SELECT username FROM member WHERE username='$username'")) > 0){
        		echo "Tên đăng nhập này đã có người dùng. Vui lòng chọn tên đăng nhập khác. <a href='javascript: history.go(-1)'>Trở lại</a>";
       			 exit;
    		}
            if(!preg_match("/^[A-Z]{1}[a-zA-Z0-9]{6,32}$/", $_POST['pass_dangki'])){
                echo "Mật khẩu bắt đầu bằng chữ in hoa và có từ 6 đến 32 kí tự. <a href='javascript: history.go(-1)'>Trở lại</a>";
                exit;
            }
			if ( $password != $re_password ){
				echo "Mật khẩu không giống nhau, bạn hãy nhập lại mật khẩu. <a href='javascript:history.go(-1)'>Trở lại</a>";
				exit;
			}
    		if (!eregi("^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,4})$", $email)){
        		echo "Email này không hợp lệ. Vui long nhập email khác. <a href='javascript: history.go(-1)'>Trở lại</a>";
        		exit;
    		}
    		if (mysql_num_rows(mysql_query("SELECT email FROM member WHERE email='$email'")) > 0){
       			echo "Email này đã có người dùng. Vui lòng chọn Email khác. <a href='javascript: history.go(-1)'>Trở lại</a>";
       	 		exit;
    		}
    		if (!ereg("^[0-9]", $mobile)){
            	echo "Số điện thoại không hợp lệ. Vui lòng nhập lại. <a href='javascript: history.go(-1)'>Trở lại</a>";
            	exit;
        	}
          
    		$addmember = mysql_query("
        		INSERT INTO member (
            		username,
            		password,
            		fullname,
					email,
            		mobile,
           	 		address
        		)VALUE (
            		'{$username}',
            		'{$password}',
            		'{$fullname}',
					'{$email}',
            		'{$mobile}',
            		'{$address}'
        		)
    		");
                          
    		if ($addmember){
        		echo "<script>alert ('\"Quá trình đăng ký thành công\"')</script>";
                echo "<meta http-equiv=\"refresh\" content=\"2;url=dang-nhap.php\">";
   			}else{
        		echo "<script>alert ('\"Đăng ký thất bại xin vui lòng thử lại\"')</script>";
                echo "<meta http-equiv=\"refresh\" content=\"2;url=dang-ky.php\">";
            }
		}else{
            echo "<script>alert ('\"Hãy điền đầy đủ thông tin\"')</script>";
        }
	}
?>