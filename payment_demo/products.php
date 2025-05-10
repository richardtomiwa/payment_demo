<?php
session_start();
$page_title="Products";
require("db_config/db_connect.php");
if(!isset($_GET["search"])){
$sql = "SELECT * FROM products" ;
$query = mysqli_query($conn, $sql);
$products = mysqli_fetch_all($query, MYSQLI_ASSOC);
}else{
    $sql = "SELECT * FROM products WHERE prod_name LIKE '%$_GET[search]%' OR prod_desc  LIKE '%$_GET[search]%' OR prod_content  LIKE '%$_GET[search]%' ";
$query = mysqli_query($conn, $sql);
$products = mysqli_fetch_all($query, MYSQLI_ASSOC);
};
include "templates/header.php"; 
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>
<section class="new">
    <h2 class="section-header">EXPLORE</h2>
        <ul class="products-container">

            <?php foreach ($products as $product) {?>
                <a href="product.php?id=<?php echo $product["id"] ?>" class="card-wrapper">
                           <li class="card">
                           <img src="assets/product-images/<?php echo $product["prod_image"] ?>" alt="" class="card-image" id="new-image" loading="lazy">
                           <h4 class="card-description"><?php echo $product["prod_name"] ?></h4>
                            <P>NGN <?php echo $product["prod_price"] ?></P>
                       </li>

                       
            </a>
         <?php   } ?>

          


        </ul>

    </section>
</body>
</html>


<?php include "templates/footer.php";  ?>