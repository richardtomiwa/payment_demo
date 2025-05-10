<?php
session_start();
$page_title="Cart";

echo session_id();
require("db_config/db_connect.php");
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require 'C:\xampp\htdocs\payment_demo\otp\vendor\phpmailer\phpmailer\src\Exception.php';
require 'C:\xampp\htdocs\payment_demo\otp\vendor\phpmailer\phpmailer\src\PHPMailer.php';
require 'C:\xampp\htdocs\payment_demo\otp\vendor\phpmailer\phpmailer\src\SMTP.php';
        // $id=(int)$_POST["product_id"];
        // $quantity=(int)$_POST["quantity"];
        // echo $id;
        // $cart[]=[$id=>$quantity];
        // $cartdata=implode(",",$cart);
        // echo $cartdata;
        // echo $_SESSION["user_id"];
        // $sql = "UPDATE users SET cart= '$cartdata' WHERE id='$_SESSION[user_id]' ";
        // $sql = "UPDATE products SET quantity= '$cartdata' WHERE id='$_SESSION[user_id]' ";

        // if($conn->query($sql)===TRUE){
        //     echo "updated";
        //     header("location:index.php");
        // }else{
        //     echo "errorrr";
        //         $conn->error;
        // }

        if(!isset($_SESSION["cart"])){

        }


    if(isset($_POST["product_id"], $_POST["quantity"]) && is_numeric($_POST["product_id"]) && is_numeric($_POST["quantity"])){
        $id=(int)$_POST["product_id"];
        $quantity=(int)$_POST["quantity"];
        $sql = "SELECT * FROM products WHERE id='$_POST[product_id]' ";
        $query = mysqli_query($conn, $sql);
        $product = mysqli_fetch_assoc($query);
        print_r($product);


        if(isset($_SESSION["user_id"])){
            $cart[]=[$id=>$quantity];
            $cartdata=implode("|",$cart);
            $sql2 = "UPDATE users SET cart= '$cartdata' WHERE id='$_SESSION[user_id]' ";
            if($conn->query($sql2)===TRUE){
                    echo "updated";
                }else{
                    echo "errorrr";
                        $conn->error;
                }
        }

        if($product && $quantity > 0){
            if(isset($_SESSION["cart"]) && is_array($_SESSION["cart"])){
                if(array_key_exists("$product[id]", $_SESSION["cart"])){
                    $_SESSION["cart"]["$product[id]"] += $quantity;
                    echo "added1";
                }else{
                    $_SESSION["cart"]["$product[id]"]=$quantity;
                    echo "added2";
                }
            }else{
                $_SESSION["cart"]=array("$product[id]"=> $quantity);
    
                echo $_SESSION["cart"]["$product[id]"]."</br>";
    
            }

            
        }


        header("location:updatecart.php");
        exit;
       
    }


    if(isset($_GET["remove"])&& is_numeric($_GET["remove"]) && isset($_SESSION["cart"]) && isset($_SESSION["cart"][$_GET["remove"]])){
        unset($_SESSION["cart"][$_GET["remove"]]);
    }



    if (isset($_POST['update']) && isset($_SESSION['cart'])) {
        // Loop through the post data so we can update the quantities for every product in cart
        foreach ($_POST as $k => $v) {
            if (strpos($k, 'quantity') !== false && is_numeric($v)) {
                $id = str_replace('quantity-', '', $k);
                $quantity = (int)$v;
                // Always do checks and validation
                if (is_numeric($id) && isset($_SESSION['cart'][$id]) && $quantity > 0) {
                    // Update new quantity
                    $_SESSION['cart'][$id] = $quantity;
                }
            }
        }
        // Prevent form resubmission...
        header('Location: updatecart.php');
        exit;
    }


    if (isset($_POST['placeorder']) && isset($_SESSION['cart']) && !empty($_SESSION['cart'])) {
        header('Location: index.php?page=placeorder');
        exit;
    }

    // Check the session variable for products in cart
$products_in_cart = isset($_SESSION['cart']) ? $_SESSION['cart'] : array();
$products = array();
$subtotal = 0.00;
// If there are products in cart
if ($products_in_cart) {
    // There are products in the cart so we need to select those products from the database
    // Products in cart array to question mark string array, we need the SQL statement to include IN (?,?,?,...etc)
    $array_to_question_marks = array_keys($products_in_cart);
    $sqlarray=implode("," , $array_to_question_marks);
    print_r( $array_to_question_marks);
    echo implode("," , $array_to_question_marks);

    $sql = "SELECT * FROM products WHERE id IN ($sqlarray )";
    $query = mysqli_query($conn, $sql);
    $products = mysqli_fetch_all($query, MYSQLI_ASSOC);


    // Calculate the subtotal
    foreach ($products as $product) {
        $subtotal += (float)$product['prod_price'] * (int)$products_in_cart[$product['id']];
    }
}




    include("templates/header.php");
        ?>
<!DOCTYPE html>
<html lang="en">
    <style>
        .content-wrapper{
            display:flex;
            flex-direction:column;
            width: 100%;
            justify-content:center;
            align-items:center;
        }

        table{
            border-collapse:collapse;
            width:90%
        }
        form{
            width:100%;
            display:flex;
            justify-content:center;
            flex-direction:column;
            align-items:center;
        }

        thead{
            font-size:20px;
            padding:15px;
            height:40px;
            width: 100%;

        }

        th{
            padding:10px;
            width: 100%;
        }

        td{
            padding:10px;
            height:200px;
            
        }

        tr{
            border-bottom:1px solid grey;
        }

        tr{
            width:100%;
        }

        img{
            width:200px;
            height:200px;
            border-radius:12px;
        }
        a{
            color:black;
            text-decoration:none;

        }

        a:hover{
            text-decoration:none;
            color:black;
        }


    </style>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<div class="cart content-wrapper">
    <h1>Shopping Cart</h1>
    <form action="updatecart.php" method="post">
        <table>
            <thead>
                <tr>
                    <th colspan="2">Product</th>
                    <th>Price</th>
                    <th>Quantity</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($products)): ?>
                <tr>
                    <td colspan="5" style="text-align:center;">You have no products added in your Shopping Cart</td>
                </tr>
                <?php else: ?>
                <?php foreach ($products as $product): ?>
                <tr>
                    <td class="img">
                        <a href="product.php?id=<?=$product['id'] ?>">
                            <img colspan="2" src="assets/product-images/<?=$product['prod_image']?>" width="50" height="50" alt="<?=$product['prod_name']?>">
                        </a>
                    </td>
                    <td>
                    <a href="product.php?id=<?=$product['id']?>"><?=$product['prod_name']?></a>
                        <br>
                        <a href="updatecart.php?remove=<?=$product['id']?>" class="remove">Remove</a>
                    </td>
                    <td class="price">&dollar;<?=$product['prod_price']?></td>
                    <td class="quantity">
                        <input type="number" name="quantity-<?=$product['id']?>" value="<?=$products_in_cart[$product['id']]?>" min="1" max="<?=$product['prod_quantity']?>" placeholder="Quantity" required>
                    </td>
                    <td class="price">&dollar;<?=$product['prod_price'] * $products_in_cart[$product['id']]?></td>
                </tr>
                <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
        <div class="subtotal">
            <span class="text">Subtotal</span>
            <span class="price">&dollar;<?=$subtotal?></span>
        </div>
        <input type="submit" value="Update" name="update">
    </form>
</div>

<?php if(isset($_SESSION["user_id"]) && !empty($products)){?>
    <form id="paymentForm">

            <input type="submit"  onclick="payWithPaystack()" value="Place Order" name="placeorder">
</form>

 
<?php
    $sqli = "SELECT * FROM users WHERE id= $_SESSION[user_id] ";
    $query1 = mysqli_query($conn, $sqli);
    $user = mysqli_fetch_assoc($query1);

  include 'configs.php';
  $email = $user["email"];
  $amount = $subtotal;
  $currency = "NGN";

?>
<?php   if(isset($_SESSION["cart"])){ ?>
  <script type="text/javascript">
    const paymentForm = document.getElementById('paymentForm');
    paymentForm.addEventListener("submit", payWithPaystack, false);

    function payWithPaystack(e) {
      e.preventDefault();
      let handler = PaystackPop.setup({
        key: '<?php echo $PublicKey; ?>', // Replace with your public key
        email: '<?php echo $email; ?>',
        amount: <?php echo $amount; ?> * 100,
        currency: '<?php echo $currency; ?>', // Use GHS for Ghana Cedis or USD for US Dollars or KES for Kenya Shillings
        metadata: {
          custom_fields: [
            {
            display_name:"Mobile Number",
            variable_name:"mobile_number",
            value:"+2349138163420"
            }
          ]
        },
      
        // label: "Optional string that replaces customer email"
        onClose: function() {
          alert('Transaction was not completed, window closed.');
        },
        callback: function(response) {
          let message = 'Payment complete! Reference: ' + response.reference;
          alert(message);
          window.location.href = "https://localhost/payment_demo/verify_transaction.php?reference=" + response.reference;
   

        }
      });

      handler.openIframe();
    }
  </script>
<?php } ?>
  <script src="https://js.paystack.co/v1/inline.js"></script>
  <?php } else if(empty($products)){?>

    <div class="buttons">
            <a href="index.php">Add products to cart</a>
        </div>

    <?php }else{ ?>
        <div class="buttons">
            <input type="submit" value="Update" name="update">
            <a href="login.php">Login to place order</a>
        </div>
 <?php } ?>
</body>
</html>

<?php include("templates/footer.php"); ?>