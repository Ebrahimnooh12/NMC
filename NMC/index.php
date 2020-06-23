<?php 
session_start();

extract($_POST);

try{
  
  require("database/connection.php");

  $catSQL = "select make from car  where status='1' group by make";
  $cat = $db->query($catSQL);


  }
catch(PDOException $e)
  {
  echo "Connection failed: " . $e->getMessage();
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
    <script src="https://kit.fontawesome.com/0547f82a88.js" crossorigin="anonymous"></script>
    
    <title>NMC</title>
</head>
<body class=" bg-light">
<!-- nav bar -->
    <nav class="navbar navbar-expand-lg navbar-light bg-light ">
        <div class="container shadow-sm p-3 mb-5 bg-white rounded">
          <!-- Brand -->
          <a class="navbar-brand" href="./index.php">
            NMC.
          </a>
          <!-- Toggler -->
          <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>
          <!-- Collapse -->
          <div class="collapse navbar-collapse" id="navbarCollapse">
            <!-- Nav -->
            <ul class="navbar-nav mx-auto">
              <li class="nav-item ">
                <!-- Toggle -->
                <a class="nav-link active" href="index.php">Home</a>
              </li>
              <li class="nav-item position-static">
                <!-- Toggle -->
                <a class="nav-link" href="CarGrid.php">Cars</a>
              </li>
              <?php if(isset($_SESSION['activeuser'])){ ?>
              <li class="nav-item">
                <!-- Toggle -->
                <a class="nav-link" href="myHistory.php">My History</a>
              </li>
              <?php }?>
            </ul>
            <!-- Nav -->
            <ul class="navbar-nav flex-row">
              <?php if(!isset($_SESSION["activeuser"])){ ?>              
              <li class="nav-item ml-lg-n2  mr-sm-3">
                <a class="nav-link" href="login.php">
                    Login              
                </a>
              </li>
              <li class="nav-item ml-lg-n2">
                <a class="nav-link" href="register.php">
                    Register             
                </a>
              </li>
              <?php }  else {?>
              <li class="nav-item ml-lg-n4">
                <a class="nav-link" href="profile.php">
                    <i class="fas fa-user"></i>                
                </a>
              </li>
              <li class="nav-item ml-lg-n2 ml-3">
                <a class="nav-link" href="database/logout.php">
                    Logout                
                </a>
              </li>
              <?php }?> 
            </ul>
          </div>
        </div>
    </nav>
<!-- header section     -->
    <section class="py-13 bg-cover" style="background-image: url(img/car.jpg)">
        <div class="container">
          <div class=" text-center">
              <!-- Heading -->
              <h3 class="font mb-3">
                The way it should be
              </h3>
              <!-- Button -->
              <a class="btn btn-warning btn-lg btn-header" href="CarGrid.php">
                Find You Car
              </a>
          </div>
        </div>
    </section>
<!-- search from -->
<div class="container align-item-center">    
    <form action="CarGrid.php" method="post">
        <div class="align-item-center  p-4 form-row">
            <div class="col-auto  col-md-3 col-lg-5 my-1 d-flex">
                <h5 class='pt-2 mr-2'>Make</h5>
                <select class="custom-select mr-sm-2" id="make" name="make">
                    <?php foreach($cat as $make) {?>
                    <option value="<?php echo $make['make']?>"><?php echo $make['make']?></option>
                    <?php }?>
                </select>
            </div>
            <div class="col-auto col-md-3 col-lg-5 my-1 text-center d-flex">
                <h5 class='pt-2 mr-2'>Year</h5>      
                <select class="custom-select mr-sm-2" name="year" id="year"></select>
            </div>
            <button name="filter" type="submit" class="btn btn-warning my-1 ml-lg-5  btn-search"><i class="fas fa-search mr-1"></i>Seach</button>
        </div>
    </form>
</div>
</body>
<footer class="bg-dark">
    <div class="py-12 border-bottom border-gray-700 pt-5 pb-5">
        <div class="container">
        <div class="row">
            <div class="col-12 col-md-3">
            <!-- Heading -->
            <h4 class="mb-6 text-light">NMC.</h4>
            <!-- Social -->
            <ul class="list-unstyled list-inline mb-7 mb-md-0">
                <li class="list-inline-item">
                <a href="#!" class="text-light">
                    <i class="fab fa-facebook-f"></i>
                </a>
                </li>
                <li class="list-inline-item">
                <a href="#!" class="text-light">
                    <i class="fab fa-youtube"></i>
                </a>
                </li>
                <li class="list-inline-item">
                <a href="#!" class="text-light">
                    <i class="fab fa-twitter"></i>
                </a>
                </li>
                <li class="list-inline-item">
                <a href="#!" class="text-light">
                    <i class="fab fa-instagram"></i>
                </a>
                </li>
                <li class="list-inline-item">
                <a href="#!" class="text-light">
                    <i class="fab fa-medium"></i>
                </a>
                </li>
            </ul>
            </div>
            <div class="col-6 col-sm">
            <!-- Heading -->
            <h6 class="heading-xxs mb-4 text-light">
                Contact
            </h6>
            <!-- Links -->
            <ul class="list-unstyled mb-0 text-light">
                <li>17345636</li>
                <li><a class="text-light" href="#">nmchelp@shopper.com</a></li>
            </ul>
            </div>
        </div>
        </div>
    </div>
    <div class="py-1">
        <div class="container">
        <div class="row">
            <div class="col">
            <!-- Copyright -->
            <p class="mb-3 mb-md-0 font-size-xxs text-light">
                © 2019 All rights reserved. Designed by 490 Group.
            </p>
        </div>
        </div>
    </div>
</footer>
<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>

<script>
var today = new Date(),
    yyyy = today.getFullYear(),
    inpYear = document.getElementById("year")
    html = '';

for (var i = 0; i < 50; i++, yyyy--) {
    html = html + '<option>' + yyyy + '</option>';
};   
inpYear.innerHTML=html;
</script>
</html>