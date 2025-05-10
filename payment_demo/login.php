
<?php
session_start();

require("db_config/db_connect.php");
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require 'C:\xampp\htdocs\payment_demo\resources\vendor\phpmailer\phpmailer\src\Exception.php';
require 'C:\xampp\htdocs\payment_demo\resources\vendor\phpmailer\phpmailer\src\PHPMailer.php';
require 'C:\xampp\htdocs\payment_demo\resources\vendor\phpmailer\phpmailer\src\SMTP.php';

if (isset($_SESSION['user_id'])) {
    ?>
    <script>
         function navigateToPage() {
             window.location.href = 'index.php';
         }
         window.onload = function() {
             navigateToPage();
         }
 </script>
 <?php
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['login'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
    $_SESSION['email']=$email;

    $sql = "SELECT * FROM users WHERE email='$email' " ;
    $query = mysqli_query($conn, $sql);
    $data = mysqli_fetch_array($query);

    if ($data && password_verify($password, $data['password'])) {
        $otp = rand(100000, 999999);
        $otp_expiry = date("Y-m-d H:i:s", strtotime("+3 minute"));
        $subject= "Your OTP for Login";
        $message="Your OTP is: $otp";

        $mail = new PHPMailer(true);
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'richardfiverr5@gmail.com'; //host email 
        $mail->Password = 'xqim aqui edmf blgd'; // app password of your host email
        $mail->Port = 465;
        $mail->SMTPSecure = 'ssl';
        $mail->isHTML(true);
        $mail->setFrom('richardtomiwa5@gmail.com', 'style wears');//Sender's Email & Name
        $mail->addAddress("$email","$data[username]"); //Receiver's Email and Name
        $mail->Subject = ("$subject");
        $mail->Body = $message;
        $mail->send();

        $sql1 = "UPDATE users SET otp='$otp', otp_expiry='$otp_expiry' WHERE id=".$data['id'];
        $query1 = mysqli_query($conn, $sql1);

        $_SESSION['temp_user'] = ['id' => $data['id'], 'otp' => $otp];
        ?>
        <script>
             function navigateToPage() {
                 window.location.href = 'otp_verification.php';
             }
             window.onload = function() {
                 navigateToPage();
             }
     </script>
     <?php
        exit();
    } else {
        ?>
        <script>
           alert("Invalid Email or Password. Please try again.");
                function navigateToPage() {
                    window.location.href = 'login.php';
                }
                window.onload = function() {
                    navigateToPage();
                }
        </script>
        <?php 
    
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="robots" content="index,follow">
    <meta name="description" content="Log in to Style Wears to explore the wide selection of products Available">
    <meta property="og:title" content="Style Wears login">
    <meta property="og:description" content="Log in to Style Wears to explore the wide selection of products Available">
    <link rel="shortcut icon" href="assets/brand.png" type="image/x-icon">
    <meta property="og:image" content="assets/brand.png">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Funnel+Display:wght@300..800&family=Montserrat+Alternates:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Pirata+One&display=swap" rel="stylesheet">
    <style>

    *{
        box-sizing:border-box;
        padding:0px;
        margin:0px;
    }

    body{
        max-width:100vw;
        overflow-x:hidden;
    }
        .form-container{
  width: 100vw;
  min-height: 100vh;
  display: flex;
  justify-content: center;
  align-items: center;
  flex-direction:column;
}
.form>input{
  width: 70%;
  height: 50px;
  padding: 10px;
  outline: 0px;
  border: 1px solid grey;
  border-radius: 10px;
transition:0.2s;
font-family: 'Open Sans', 'Helvetica Neue', sans-serif;
}

#email{
  background-color: white;
}

input:focus{
  border-left: 5px solid #36454f;
  transition:0.2s;
}
p{
  font-size: 20px;
  font-weight: bold;
  color: white;
  font-family: 'Open Sans', 'Helvetica Neue', sans-serif;
}
.form{
  width: 50% ;
  background: black;
  display: flex;
  justify-content: center;
  align-items: center;
  flex-direction: column;
  gap: 20px;
  height: 70vh;
  border-radius: 20px;
}
.form>p{
  color: white;
}

p>a{
    font-family: 'Open Sans', 'Helvetica Neue', sans-serif;
  text-decoration: none;
  font-weight: bold;
  font-size: 21px;
  color: blue;
}
a:hover{
  cursor: pointer;
  color: #36454f;
}
input[type=submit]{
  width: 70%;
  height:40px;
  background-color: white;
  border: 0px;
  color: black;
  font-weight: bold;
  padding: 7px;
  border-radius: 10px;
}
input[type=submit]:hover{
  background-color: #36454f;
  cursor: pointer;
color:white;
}

div.login{
    color:white;
    width: 70%;
    display:flex;
    flex-direction:column;
    gap:20px;
}

div.login>h2{

    font-family:"Montserrat Alternates", sans-serif;
}

div.login>h4{
    font-family: 'Open Sans', 'Helvetica Neue', sans-serif;
}

p.logo-wrap{
    width:100px;
    height:100px;
    border-radius:50%;
    border:4px solid white;
    display:flex;
    justify-content:center;
    align-items:center;
    margin-bottom:50px;
}

.form-logo{
    width: 100%;
    border-radius:50%;
    border:2px solid black;
}


@media only screen and (max-width:768px) {
    body{
        background-color:black;
    }

    .form{
  width: 100% ;
}

.form>input{
  width: 90%;


}

div.login{
    width: 90%;
}
}


    </style>

</head>
<body>


    <div class="form-container">

        <form class="form" method="post" action="login.php">
            <p class="logo-wrap"><img class="form-logo" src="assets/brand.png" alt=""></p>
        <div class="login">
        <h2>Log in</h2>
        <h4>Enter your login details and we'll send you a login code</h4>
  </div>
            <input id="email" type="text" name="email" placeholder="Enter Your Email" required autocomplete="on">
            <input id="password" type="password" name="password" placeholder="Enter Your Password" required>
            <input id="submit" type="submit" name="login" value="LOGIN">
            <p>Don't have an account? <a href="registration.php">Sign Up</a>        </p>
        </form>
    </div>


</body>
</html>

