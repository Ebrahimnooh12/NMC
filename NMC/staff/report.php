<?php 
session_start();

if(!isset($_SESSION['activeadmin'])){
    header("location: ../index.php");
}


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <link rel="stylesheet" href="../style.css">
    <script src="https://kit.fontawesome.com/0547f82a88.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@2.8.0"></script>
    <title>NMC</title>
</head>

<script>
  
  window.myBarChart;
  window.myBarChart2;
  window.myBarChart3; 

  window.chartColors = {
      red: 'rgba(255, 99, 132,0.7)',
      orange: 'rgba(255, 159, 64,0.7)',
      yellow: 'rgba(255, 205, 86,0.7)',
      green: 'rgba(75, 192, 192,0.7)',
      blue: 'rgba(54, 162, 235,0.7)',
      purple: 'rgba(153, 102, 255,0.7)',
      grey: 'rgba(201, 203, 207,0.7)'
    };

function start(){
  var data;


  var ctx = document.getElementById('canvas').getContext('2d');  
  var ctx2 = document.getElementById('canvas2').getContext('2d');  
  var ctx3 = document.getElementById('canvas3').getContext('2d');  


  var Totalsales =  document.getElementById('sales');
  var TotalBooked =  document.getElementById('booked');
  var AVAsales =  document.getElementById('avaS');
  var year =  document.getElementById('year').value;
  var xhttp = new XMLHttpRequest();
  xhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
       data = JSON.parse(this.responseText);
       Totalsales.innerHTML = data.income+' BD';
       TotalBooked.innerHTML = data.test;
       AVAsales.innerHTML = data.ava+' BD';
       salesDATA = data.sales;
       testDATA = data.tests;       
       topDATA = data.cars;

       topLabel=[];
       topNum = [];
       for (let index = 0; index < topDATA.length; index++) {
                topLabel.push(topDATA[index].car);            
                topNum.push(parseInt(topDATA[index].num));            
       } 

      
       //sales per month
        window.myBarChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'],
            datasets: [{
                    label: 'Income in BD',
                    backgroundColor: window.chartColors.green,
                    barPercentage: 0.5,
                    barThickness: 6,
                    maxBarThickness: 8,
                    minBarLength: 2,
                    data: [ parseInt(salesDATA.January), parseInt(salesDATA.February), 
                            parseInt(salesDATA.March), parseInt(salesDATA.April),
                            parseInt(salesDATA.May), parseInt(salesDATA.June), 
                            parseInt(salesDATA.July),parseInt(salesDATA.August)
                            ,parseInt(salesDATA.September),parseInt(salesDATA.October),
                            parseInt(salesDATA.November),parseInt(salesDATA.December)]
                }]
            },
            options: {
            }
        
    });

    //test per month
    window.myBarChart2 = new Chart(ctx2, {
        type: 'bar',
        data: {
            labels: ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'],
            datasets: [{
                    label: 'Booked Car',
                    backgroundColor: window.chartColors.yellow,
                    barPercentage: 0.5,
                    barThickness: 6,
                    maxBarThickness: 8,
                    minBarLength: 2,
                    data: [ parseInt(testDATA.January), parseInt(testDATA.February), 
                            parseInt(testDATA.March), parseInt(testDATA.April),
                            parseInt(testDATA.May), parseInt(testDATA.June), 
                            parseInt(testDATA.July),parseInt(testDATA.August)
                            ,parseInt(testDATA.September),parseInt(testDATA.October),
                            parseInt(testDATA.November),parseInt(testDATA.December)]
                }]
            },
            options: {
            }
        
    });

    window.myBarChart3 = new Chart(ctx3, {
        type: 'bar',
        data: {
            labels: topLabel,
            datasets: [{
                    label: 'Booked',
                    backgroundColor: window.chartColors.red,
                    barPercentage: 0.5,
                    barThickness: 6,
                    maxBarThickness: 8,
                    minBarLength: 2,
                    data: topNum
            }]
        },
            options: {
            }
        
    });
    xhttp.abort();
    }
  };
  xhttp.open("GET", "../database/service.php?year="+year, true);
  xhttp.send();
}

function reset() {
  if(window.myBarChart != undefined) 
    window.myBarChart.destroy();
  if(window.myBarChart2 != undefined) 
    window.myBarChart2.destroy();
  if(window.myBarChart3 != undefined) 
    window.myBarChart3.destroy();
   start();   
}
</script>
<body class=" bg-light" onload="start()">
<!-- nav bar -->
    <nav class="navbar navbar-expand-lg navbar-light bg-light ">
        <div class="container shadow-sm p-3 mb-2 bg-white rounded">
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
                <a class="nav-link" href="dashboard.php?page=1&ipp=2">Car</a>
              </li>
              <li class="nav-item ">
                <!-- Toggle -->
                <a class="nav-link" href="employee.php?page=1&ipp=2">Employee</a>
              </li>
              <li class="nav-item ">
                <!-- Toggle -->
                <a class="nav-link" href="customer.php?page=1&ipp=2">Customer</a>
              </li>
              <li class="nav-item position-static">
                <!-- Toggle -->
                <a class="nav-link" href="testSchedule.php?page=1&ipp=2">Test Drive</a>
              </li>
              <li class="nav-item position-static">
                <!-- Toggle -->
                <a class="nav-link" href="sales.php?page=1&ipp=2">Sales</a>
              </li>
              <?php if(isset($_SESSION['activeadmin'])){ ?>
              <li class="nav-item position-static">
                <!-- Toggle -->
                <a class="nav-link active" href="report.php">Report</a>
              </li>
              <?php }?>
            </ul>
            <!-- Nav -->
            <ul class="navbar-nav flex-row">
              <li class="nav-item ml-lg-n4">
                <a class="nav-link" href="profile.php">
                    <i class="fas fa-user"></i>                
                </a>
              </li>
              <li class="nav-item ml-lg-n2 ml-3">
                <a class="nav-link" href="../database/logout.php">
                    Logout                
                </a>
              </li>
            </ul>
          </div>
        </div>
    </nav>
<div class="container">
    <div class="row row-cols-1 mb-5 pl-4 pr-4">
         <div class="col">
            <div class="card">
                <div class="card-body d-flex">
                    <h5 align='center' class="m-2">Year</h5>
                    <select name="year" id="year" class="form-control ">
                    </select>
                    <button class="btn btn-outline-primary ml-2" onclick="reset()"><i class="fas fa-sync-alt"></i></button>
                </div>
            </div>
         </div>       
    </div>
    <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 m-3">
        <div class="col mb-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Total Income</h5>
                    <hr>
                    <p id="sales" class="card-text font-weight-bold">0</p>
                </div>
            </div>
        </div> 
        <div class="col mb-4">   
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">No. Booked Test Drive</h5>
                    <hr>
                    <p  id="booked" class="card-text font-weight-bold">0</p>
                </div>
            </div> 
        </div>
        <div class="col mb-4">    
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">AVA Income</h5>
                    <hr>
                    <p id='avaS' class="card-text font-weight-bold">0</p>
                </div>
            </div>               
        </div>
    </div>
    <div class="row row-cols-1 mb-5 pl-4 pr-4">
         <div class="col">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Sales</h5>
                    <hr>
                    <canvas id="canvas" ></canvas>
                </div>
            </div>
         </div>       
    </div>
    <div class="row row-cols-1 mb-5 pl-4 pr-4">
         <div class="col">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Booked Test Drive</h5>
                    <hr>
                    <canvas id="canvas2" ></canvas>
                </div>
            </div>
         </div>       
    </div>
    <div class="row row-cols-1 mb-5 pl-4 pr-4">
         <div class="col">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Top Booked Cars</h5>
                    <hr>
                    <canvas id="canvas3" ></canvas>
                </div>
            </div>
         </div>       
    </div>
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
  var today = new Date();
  var inpYear = document.getElementById("year");

  var yyyy = today.getFullYear();;
  html = '';

  for (var i = 0; i < 50; i++, yyyy--) {
      html = html + '<option value='+yyyy+'>' + yyyy + '</option>';
  }

  inpYear.innerHTML=html;

</script>
</html>