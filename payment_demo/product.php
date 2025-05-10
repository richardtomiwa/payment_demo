<?php 
$lifetime=2628003;
session_set_cookie_params($lifetime);
session_start();
 ?>
<?php include "templates/header.php"; ?>

<?php
$page_title="StyleWears";
require("db_config/db_connect.php");
$id=$_GET["id"];
echo $id;
$sql = "SELECT * FROM products WHERE id = '$id'" ;
$query = mysqli_query($conn, $sql);
$product = mysqli_fetch_array($query);
$sizes=explode(",", $product["sizes"]);
print_r($sizes);
?>


<html lang="en">
<head>

</head>
<body>



        
                           <li class="single-product">
                           <img src="assets/product-images/<?php echo $product["prod_image"] ?>" alt="" class="card-image" id="new-image" loading="lazy">
                           <div class="prod">
                           <h4 class="card-description"><?php echo $product["prod_name"] ?></h4>
                            <P>NGN <?php echo $product["prod_price"] ?></P>

                        <form class="product-form" action="updatecart.php" method="post">
                            <input type="number" name="quantity" id="" value="1" min="1" max= <?php echo $product['prod_quantity'] ?>  > 
                            <input type="hidden" name="product_id" id="" value="<?php echo $_GET["id"]?>">
                            <button type="submit">Add to cart</button>
                        </div>
                        </form>


                       </li>

                       <h3>Product description and specifications</h3>
                       <h4 class="card-description"><?php echo $product["prod_desc"] ?></h4>


          







    <script src="header-script.js"></script>
</body>
</html>
<?php include "templates/footer.php"; ?>