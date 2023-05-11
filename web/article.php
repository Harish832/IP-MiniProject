<?php
session_start();
$product="";
$product=$_GET["product"];

$conn = mysqli_connect("localhost","root","","game_shop");
if (!$conn) {
  die("Connection failed: " . mysqli_connect_error());
}
$sql = "SELECT price,stock,image_url FROM product WHERE pname='$product'";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {
  while($row = mysqli_fetch_assoc($result)) {
    $price=$row["price"];
    $stock=$row["stock"];
    $image_url=$row["image_url"];
    $_SESSION['price'] =$price;
    $_SESSION['stock'] =$stock;
    $_SESSION['product'] =$product;
    $_SESSION['image'] =$image_url;
  }
} else {
  echo "No games available.";
}

?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        
        <meta name="description" content="Your description">
        <meta name="author" content="Your name">

        <meta property="og:site_name" content="" />
        <meta property="og:site" content="" /> 
        <meta property="og:title" content=""/> 
        <meta property="og:description" content="" /> 
        <meta property="og:image" content="" /> 
        <meta property="og:url" content="" /> 
        <meta name="twitter:card" content="summary_large_image"> 
        <title>Article Details</title>
        
        <link href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,400;0,600;0,700;1,400&family=Poppins:wght@600&display=swap" rel="stylesheet">
        <link href="css/bootstrap.min.css" rel="stylesheet">
        <link href="css/fontawesome-all.min.css" rel="stylesheet">
        <link href="css/swiper.css" rel="stylesheet">
        <link href="css/styles.css" rel="stylesheet">
        
        <link rel="icon" href="images/favicon.png">
    </head>
    <body>
        
        <nav id="navbarExample" class="navbar navbar-expand-lg fixed-top navbar-dark" aria-label="Main navigation">
            <div class="container">

                <a class="navbar-brand logo-image" href="index.php"><img src="images/logo.svg" alt="alternative"></a> 
                <button class="navbar-toggler p-0 border-0" type="button" id="navbarSideCollapse" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="navbar-collapse offcanvas-collapse" id="navbarsExampleDefault">
                    <ul class="navbar-nav ms-auto navbar-nav-scroll">
                        <li class="nav-item">
                            <a class="nav-link" href="index.php">Home</a>
                        </li>
                    </ul>
                    <span class="nav-item social-icons">
                        <span class="fa-stack">
                            <a href="#your-link">
                                <i class="fas fa-circle fa-stack-2x"></i>
                                <i class="fab fa-facebook-f fa-stack-1x"></i>
                            </a>
                        </span>
                        <span class="fa-stack">
                            <a href="#your-link">
                                <i class="fas fa-circle fa-stack-2x"></i>
                                <i class="fab fa-twitter fa-stack-1x"></i>
                            </a>
                        </span>
                    </span>
                </div> 
            </div>
        </nav>
        <header class="ex-header">
            <div class="container">
                <div class="row">
                    <div class="col-xl-10 offset-xl-1">
                        <h1><?php echo $_SESSION['product'] ?></h1>
                        <div class="d-flex flex-row mt-5" style="height:40px;">    
                            <p>Stock Available:</p>
                            <input style="width:100px;margin-left:10px;height:30px;" type="text" value="<?php echo $_SESSION['stock'] ?>" class="form-control">
                            <p style="margin-left:30px;">Price per unit:</p>
                            <input style="width:100px;margin-left:10px;height:30px;" type="text" value="$<?php echo $_SESSION['price']?>" class="form-control">
                        </div>
                    </div> 
                </div>
            </div>
        </header> 

        <div class="ex-basic-1 pt-5 pb-5">
            <div class="container">
                <div class="row">
                    <div class="d-flex flex-row col-lg-12">
                        <img class="img-fluid mt-5 mb-3" src="<?php echo $_SESSION['image']?>" alt="alternative" style="width:700px;height:470px;">
                        <div class="mb-5 m-auto">
                            <br><br>
                            <form>
                            <div>
                                <p>Name:</p>
                                <input type="text" class="form-control" name="name" style="width:300px;">
                            </div>
                            <div class="mt-3">
                                <p>Email:</p>
                                <input type="email" class="form-control" name="email" style="width:300px;">
                            </div>
                            <div class="mt-3">
                                <p>Phone:</p>
                                <input type="text" class="form-control" name="phone">
                            </div>
                            <div class="mt-3">
                                <p>Add Item:</p>
                                <input type="number" min="0" max="<?php echo $stock ?>" class="form-control" name="item">
                            </div>
                            <div class="mt-5">
                                <input type="submit" class="btn-solid-reg" style="margin-left:80px;" name="submit">
                            </div>
                            </form>
                        </div>
                    </div>
                </div> 
            </div> 
        </div> 
        <div class="ex-basic-1 pt-4">
            <div class="container">
                <div class="row">
                    <div class="col-xl-10 offset-xl-1">
                       
                    </div> 
                </div> 
            </div> 
        </div> 

        <button onclick="topFunction()" id="myBtn">
            <img src="images/up-arrow.png" alt="alternative">
        </button>

        <script src="js/bootstrap.min.js"></script> 
        <script src="js/swiper.min.js"></script>
        <script src="js/purecounter.min.js"></script>
        <script src="js/replaceme.min.js"></script> 
        <script src="js/isotope.pkgd.min.js"></script>
        <script src="js/scripts.js"></script>
    </body>
</html>
<?php
if(isset($_GET["submit"])){
    $stock=$_SESSION['stock'];
    $price=$_SESSION['price'];
    $product1=$_SESSION['product'];
    $name=$_GET["name"];
    $email=$_GET["email"];
    $phone=$_GET["phone"];
    $item=$_GET["item"];
    if($stock!=0){
        $stock-=$item;
        $cost=$item*$price;
        $_SESSION['stock']=$stock;
        $sql1 = "INSERT INTO orders (product, c_name, c_email, c_phone,quantity,cost) VALUES ('$product1', '$name', '$email', '$phone','$item','$cost')";
        $sql2 = "UPDATE product SET stock='$stock' WHERE pname='$product1'";
        if (mysqli_query($conn, $sql1)) {
          echo "<script>alert(order placed successfully!)</script>";
        } else {
          echo "Error: " . $sql1 . "<br>" . mysqli_error($conn);
        }
        if (mysqli_query($conn, $sql2)) {
          echo"<script>
          alert('Redirecting to another page...');
          window.location.href = 'index.php';
        </script>";
        } else {
          echo "Error: " . $sql2 . "<br>" . mysqli_error($conn);
        }
    }
}
mysqli_close($conn);
?>
