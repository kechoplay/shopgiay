<?php
include('ketnoi.php');
if(!isset($_GET['trang'])){
    $trang=1;
}
else{
    $trang=$_GET['trang'];
}
$max_result=5;
$index_row=$trang*$max_result-$max_result;

$sql="SELECT * FROM product INNER JOIN progroup ON product.gro_id = progroup.gro_id ";
$query=mysql_query($sql);
$num_row=mysql_num_rows($query);
?>

<div id="products-wrapper">
    <h1 id="prod">Sản phẩm</h1>
    <div class="products">
        <?php
        $results = mysql_query("SELECT * FROM product JOIN progroup ON product.gro_id = progroup.gro_id limit $index_row,$max_result");
        if (mysql_num_rows($results)>0) { 

            while($row = mysql_fetch_array($results))
            {
                ?>
                <div class="product">
                    <form method="post" action="cart_update.php">                
                        <div class="product-thumb"><a href="index.php?page=chitietsp&id=<?php echo $row['pro_id']; ?>"><img style="height:auto;" width="150px;" src="hinhanh/<?php echo $row['pro_image']; ?> "/></a></div>
                        <div class="product-content"><h3><?php echo $row['pro_name']; ?></h3></div>
                        <div class="product-desc"><?php echo $row['pro_description']; ?></div>
                        <div class="product-desc"><?php echo $row['gro_name']; ?></div>
                        <input type="hidden" name="product_code" value='<?php echo $row["pro_id"]; ?>' />
                        <div class="product-info">
                            Giá: <?php echo number_format($row['pro_price']); ?> |                 
                            <a href="addcart.php?id=<?php echo $row['pro_id']; ?>">Thêm vào giỏ hàng</a>                
                        </div>               
                    </form>
                </div>
                <?php
            }
        }
        ?>
    </div>
    <div class="shopping-cart">
        <h2>Your Shopping Cart</h2>
        <?php
        $ok=1;
        if(isset($_SESSION['cart']))
        {
            foreach($_SESSION['cart'] as $k=>$v)
            {
                if(isset($k))
                {
                    $ok=2;
                }
            }
        }

        if ($ok != 2)
        {
            echo '<p>Ban khong co mon hang nao trong gio hang</p>';
        } else {
            $items = $_SESSION['cart'];
            echo '<p id="cart-info">Ban dang co <a href="index.php?page=cart">'.count($items).' mon hang trong gio hang</a></p>';
        }
        ?>
    </div>

</div>

<div id="trang">
    <hr>
    <?php
    $total_row=mysql_num_rows(mysql_query("select * from product"));
    $total_trang=ceil($total_row/$max_result);
    $list_trang='';
    for($i=1; $i<=$total_trang; $i++){
        if($trang == $i){
            $list_trang .= "<b>$i </b>";
        }
        else{
            $list_trang .= "<a href=".$_SERVER['PHP_SELF']."?trang=$i>".$i." </a>";
        }
    }
    echo "<p id='num'>$list_trang</p>";
    ?>
</div>
