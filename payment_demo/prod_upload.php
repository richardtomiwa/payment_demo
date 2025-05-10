<?php 

require("db_config/db_connect.php");
$errors=["prod-name"=>"", "prod-desc"=>"", "prod-price"=>"","prod-content"=>"","image"=>""];
if (isset($_POST["submit"])) {
    if (empty($_POST["prod-name"])) {
        $errors["prod-name"] = "name cannot be empty";
    } else {
        $errors["prod-name"]="";
    }

    if (empty($_POST["prod-desc"])) {
        $errors["prod-desc"] = "product description cannot be empty";
    } else {
        if( strlen($_POST["prod-desc"])>255) {
            $errors["prod-desc"] = "product description cannot be longer than 255 words";
        };
    }


    if ($_POST["prod-price"]<0.1 || !(int)$_POST["prod-price"]) {
        $errors["prod-price"] = "product price cannot be empty";
    } else {
        
    }

    if (!(int)$_POST["quantity"]) {
        $errors["prod-price"] = "product price must be a number";
    } else {
        
    }

    if (empty($_POST["prod-content"])) {
        $errors["prod-content"] = "product content cannot be empty";
    } else {

    }

    if (isset($_FILES["image"])){
        if($_FILES["image"]["error"]>0){
            $errors["image"]="image cannot be empty";
        }else{
            $filename=$_FILES["image"]["name"];
            $filesize=$_FILES["image"]["size"];
            $tmpname=$_FILES["image"]["tmp_name"];
            $validimgext=["jpg", "png", "jpeg"];
            $imgext=explode(".",$filename);
            $imgext=strtolower(end($imgext));
            if(!in_array($imgext,$validimgext)){
                $errors["image"]="select a valid image type";
            }else{
                if($filesize>500000){
                    $errors["image"]="file size too large";
                  
                }else{
                    if (!array_filter($errors)) {
                    $prod_name=htmlspecialchars($_POST["prod-name"]);
                    $prod_desc=htmlspecialchars($_POST["prod-desc"]);
                    $prod_price=htmlspecialchars($_POST["prod-price"]);
                    $prod_content=htmlspecialchars($_POST["prod-content"]);
                    $quantity=htmlspecialchars($_POST["quantity"]);
                    $newimgname=uniqid();
                    $newimgname .= "." . $imgext;
                    move_uploaded_file($tmpname, "assets/product-images/".$newimgname);
                    $query = " INSERT INTO products (prod_name, prod_desc, prod_price, prod_content, prod_image, prod_quantity) VALUES('$prod_name','$prod_desc', '$prod_price', '$prod_content', '$newimgname', '$quantity' )";
                    mysqli_query($conn, $query);
                    }
                }
            }

        }
    }else{

    }



    if (array_filter($errors)) {

    } else {
        //CONVERT POST DATA TO VARIABLES AND PROTECT YOUR DATABASE FOR SQL INJECTIONS
        //UPLOAD TO DATABASE

        //    redirect to login page 
        //    header("location: login.php");

    };

    // $valemail = htmlspecialchars($_POST["email"]);
    // $query = "SELECT * FROM users WHERE email='$valemail' ";
    // $result = mysqli_query($conn, $query);
    // $sqli = mysqli_fetch_assoc($result);

}



?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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
background:white;
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
    <form  class="form" method="POST" action=<?php echo $_SERVER["PHP_SELF"] ?> enctype="multipart/form-data">

        <p class="logo-wrap"><img class="form-logo" src="assets/brand.png" alt=""></p>
        <div class="login">
        <h2>Sign Up</h2>
        <h4>Enter preferred sign up details to start your Exploration</h4>
</div>

            <input name="prod-name" placeholder="Your product name" type="text" tabindex="2" value="">
            <div class="error" aria-live="polite"><?php echo $errors["prod-name"] ?? "" ?></div>


            <input name="prod-desc" placeholder="Product description"  id="product-desc" type="text"
                tabindex="3" value="">
                <div class="error" aria-live="polite"><?php echo $errors["prod-desc"] ?? "" ?></div>



   
            <input name="prod-price" placeholder="Product Price"  id="product-price" type="number"
                tabindex="3" value=""><br>
                <div class="error" aria-live="polite"><?php echo $errors["prod-price"] ?? "" ?></div>




            <input name="prod-content" placeholder="Product Tags"  id="tags" type="text"
                tabindex="3" value=""><br>
                <div class="error" aria-live="polite"><?php echo $errors["prod-content"] ?? "" ?></div>




            <input name="image" placeholder="Product Image"  id="image" type="file"
                tabindex="3" value="" accept="jpg,jpeg,png"><br>
                <div class="error" aria-live="polite"><?php echo $errors["image"] ?? "" ?></div>


            <input name="quantity" placeholder="quantity"  id="quantity" type="number"
                tabindex="3" value=""><br>
                <div class="error" aria-live="polite"><?php echo $errors["quantity"] ?? "" ?></div>




        <input type="submit" name="submit" value="Submit">

    </form>
</div>

</body>
</html>