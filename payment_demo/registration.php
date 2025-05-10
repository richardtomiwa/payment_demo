<?php
session_start();
$page_title="StyleWears-signup";



require("db_config/db_connect.php");
require("db_config/oop.php");
if (isset($_POST["register"])) {
    $valemail = htmlspecialchars($_POST["email"]);
    $query = "SELECT * FROM users WHERE email='$valemail' ";
    $result = mysqli_query($conn, $query);
    $sqli = mysqli_fetch_assoc($result);

    $validation = new UserValidator($_POST);
    $errors = $validation->ValidateForm();

    if (!empty(array_values($errors))) {
    } else {
        $name = mysqli_real_escape_string($conn, $_POST["username"]);
        $password = mysqli_real_escape_string($conn, $_POST["password"]);
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $email = mysqli_real_escape_string($conn, $_POST["email"]);

        if ( !empty($sqli["email"])) {
            $errors["email"] = "Email already registered";
        } else {
            
            $sql = "INSERT INTO users (username, email, password) VALUES ('$name', '$email', '$hashedPassword')";
            if (mysqli_query($conn, $sql)) {
                ?>

        
                <script>
        alert("Registration Successful.");
        function navigateToPage() {
            window.location.href = 'login.php';
        }
        window.onload = function() {
            navigateToPage();
        }
    </script>
            <?php 
        } else {
           echo "<script> alert('Registration Failed. Try Again');</script>";
        }
        }
    }
}


?>

<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="robots" content="index,follow">
    <meta name="description" content="Sign up on Style Wears to explore the wide selection of products Available">
    <meta property="og:title" content="Style Wears login">
    <meta property="og:description" content="Sign Up on Style Wears to explore the wide selection of products Available">
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
  gap: 10px;
  min-height: 70vh;
  border-radius: 20px;
  margin-top:20px;
  padding:30px 0px;
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

div.error{
    color:red;
    width: 70%;
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
div.error{
    width: 90%;
}


}
</style>

</head>
<body>
<div class="form-container">
        <form  class="form" method="post" action="registration.php">
        <p class="logo-wrap"><img class="form-logo" src="assets/brand.png" alt=""></p>
        <div class="login">
        <h2>Sign Up</h2>
        <h4>Enter preferred sign up details to start your Exploration</h4>
  </div>
            <input type="text" name="username" placeholder="Enter Username" required>
            <div class="error" aria-live="polite" id="error-name"><?php echo $errors["name"] ?? "" ?></div>

            <input type="text" name="email" placeholder="Enter Your Email" required>
            <div class="error" aria-live="polite"><?php echo $errors["email"] ?? "" ?></div>

            <input type="password" name="password" placeholder="Enter Password" required>
            <div class="error" id="error-password" aria-live="polite"><?php echo $errors["password"] ?? "" ?></div>
            <input type="submit" name="register" value="Register">
            <p>Already have an account? <a href="login.php">Login</a></p>
        </form>
    </div>

</body>
</html>