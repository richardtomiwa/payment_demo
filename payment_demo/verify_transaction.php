<?php
session_start();
include 'configs.php';
require("db_config/db_connect.php");
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require 'C:\xampp\htdocs\payment_demo\otp\vendor\phpmailer\phpmailer\src\Exception.php';
require 'C:\xampp\htdocs\payment_demo\otp\vendor\phpmailer\phpmailer\src\PHPMailer.php';
require 'C:\xampp\htdocs\payment_demo\otp\vendor\phpmailer\phpmailer\src\SMTP.php';
if (isset($_GET['reference'])) {
  $referenceId = $_GET['reference'];
  if ($referenceId == '') {
    header("Location: updatecart.php");
  } else {
    $curl = curl_init();
    curl_setopt_array($curl, array(
      CURLOPT_URL => "https://api.paystack.co/transaction/verify/$referenceId",
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => "",
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 30,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => "GET",
      CURLOPT_HTTPHEADER => array(
        "Authorization: Bearer $SecretKey",
        "Cache-Control: no-cache",
      ),
    ));

    $response = curl_exec($curl);
    $err = curl_error($curl);

    curl_close($curl);

    if ($err) {
      echo "cURL Error #:" . $err;
    } else {
      $data = json_decode($response);
      if ($data->status == true) {
      echo $transaction_message = $data->message;
      echo "<br>";
      echo  $paid_reference = $data->data->reference;
      echo "<br>";
      echo  $message = $data->data->message;
      echo "<br>";
      echo  $gateway_response = $data->data->gateway_response;
      echo "<br>";
      echo  $receipt_number = $data->data->receipt_number;
      echo "<br>";


$sqli = "SELECT * FROM users WHERE id='$_SESSION[user_id]'" ;
$result = mysqli_query($conn, $sqli);
$user = mysqli_fetch_assoc($result);
$name = "$user[username]";
$email="$user[email]";

    $array_to_question_marks = array_keys($_SESSION["cart"]);
    $sqlarray=implode("," , $array_to_question_marks);

        $sql = "SELECT * FROM products WHERE id IN ($sqlarray )";
    $query = mysqli_query($conn, $sql);
    $products = mysqli_fetch_all($query, MYSQLI_ASSOC);



        $subject= "Order details";
        $message="

          <html>
          <head>
          </head>
          <body>
          <table>
                <thead>
                <th>name</th>
                <th>price</th>
                <th>quantity</th>
                <th>amount</th>
                </thead>
                    <tbody>";

                 foreach ($products as $product){
                  $message .= "<tr>
                        <td>" . $product['prod_name'] . "</td>
                    <td>NGN" . $product['prod_price'] . "</td>
                    <td>" . $_SESSION["cart"]["$product[id]"] . "</td>
                    <td>NGN" . $product['prod_price'] * $_SESSION['cart'][$product['id']] . "</td>
                </tr>";
                 }"
                 <h1>transaction-reference:" . $referenceId . "</h1>
                $message .= </tbody>
              </table>
            </body>
        </html>";

        $mail = new PHPMailer(true);
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'richardfiverr5@gmail.com'; //host email 
        $mail->Password = 'xqim aqui edmf blgd'; // app password of your host email
        $mail->Port = 465;
        $mail->SMTPSecure = 'ssl';
        $mail->isHTML(true);
        $mail->setFrom('richardfiverr5@gmail.com', 'style wears');//Sender's Email & Name
        $mail->addAddress($email,$name);
         $mail->addAddress("richardtomiwa5@gmail.com","style wears");  //Receiver's Email and Name
        $mail->Subject = ($subject);
        $mail->Body = $message;
        $mail->send();



      unset(  $_SESSION["cart"]);



    ;

            header("Location: updatecart.php");
      } else {
        // echo $response;
        echo $transaction_message = $data->message;
        
      }
      
    }
  }
} else {
  header("Location: index.php");
}
?>