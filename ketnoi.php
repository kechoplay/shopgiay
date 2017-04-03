<?php
    $ketnoi['Server']['name'] = 'localhost';
    $ketnoi['Database']['dbname'] = 'shopgiay';
    $ketnoi['Database']['username'] = 'root'; 
    $ketnoi['Database']['password'] = '';
    $conn=mysql_connect(
        "{$ketnoi['Server']['name']}",
        "{$ketnoi['Database']['username']}",
        "{$ketnoi['Database']['password']}")
    or
        die("Không thể kết nối database");
    mysql_select_db(
        "{$ketnoi['Database']['dbname']}") 
    or
        die("Không thể chọn database");
?>