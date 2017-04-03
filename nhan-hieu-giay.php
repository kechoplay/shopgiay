<?php
$groupid=$_GET['group'];

$sql="SELECT * FROM product JOIN progroup ON product.gro_id = progroup.gro_id where product.gro_id=$groupid";
$query=mysql_query($sql);
if (mysql_num_rows($query)>0) {
    ?>
    <div id="products-wrapper">
        <h1>Sản phẩm</h1>
        <div class="products">
            <?php
            while ($fetch=mysql_fetch_array($query)) {
                ?>
                <div class="product">
                    <form method="post" action="cart_update.php">                
                        <div class="product-thumb"><a href="index.php?page=chitietsp&id=<?php echo $fetch['pro_id']; ?>"><img width="150px;" src="hinhanh/<?php echo $fetch['pro_image']; ?> "/></a></div>
                        <div class="product-content"><h3><?php echo $fetch['pro_name']; ?></h3></div>
                        <div class="product-desc"><?php echo $fetch['pro_description']; ?></div>
                        <div class="product-desc"><?php echo $fetch['gro_name']; ?></div>
                        <input type="hidden" name="product_code" value='<?php echo $fetch["pro_id"]; ?>' />
                        <div class="product-info">
                            Giá: <?php echo number_format($fetch['pro_price']); ?> |                 
                            <a href="addcart.php?id=<?php echo $fetch['pro_id']; ?>">Thêm vào giỏ hàng</a>                
                        </div>               
                    </form>
                </div>
                <?php
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
    <?php
}else{
    echo "Hiện tại chưa có dữ liệu trong mục này, nhấn vào <a href='index.php'>đây</a> để quay về trang chủ";

}
?>
