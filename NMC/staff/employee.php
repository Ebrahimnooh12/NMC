<?php 
session_start();

if(isset($_SESSION['activestaff']) || isset($_SESSION['activeadmin'])){
    
    require("../database/connection.php");
    require("../database/paginator.class.php");

    if(isset($_GET["search"]) && $_GET["input"]!='') {
      $x=  $_GET["input"];
      $condition  =  " and ( id like '%$x%'
                       or username like '%$x%'
                       or first like '%$x%'
                       or last like '%$x%'
                       )";
    
      $pages = new Paginator;        
      $pages->default_ipp = 10;
      $sql_forms = $db->query("SELECT * FROM staff WHERE 1".$condition);
      $pages->items_total = $sql_forms->rowCount();
      $pages->mid_range = 9;
      $pages->paginate();  
      
      $result =   $db->query("SELECT * FROM staff WHERE 1".$condition." ORDER BY id ASC ".$pages->limit."");
                   
    }

    else {
    $pages = new Paginator;        
    $pages->default_ipp = 10;
    $sql_forms = $db->query("SELECT * FROM staff WHERE 1");
    $pages->items_total = $sql_forms->rowCount();
    $pages->mid_range = 9;
    $pages->paginate();  
    
    $result =   $db->query("SELECT * FROM staff WHERE 1 ORDER BY id ASC ".$pages->limit."");
    
    }
}

else {
    header("location: index.php");
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
    
    <title>NMC</title>
</head>
<body class=" bg-light">
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
                <a class="nav-link active" href="employee.php?page=1&ipp=2">Employee</a>
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
                <a class="nav-link" href="report.php">Report</a>
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
<div class="mr-sm-5 ml-sm-5">
    <div class="row">
      <div class="col-lg-10 col-xl-9 mx-auto">
        <div class="card card-signin flex-row my-5">
          <div class="card-body">
            <div class="d-flex justify-content-between">
            <form action="employee.php" method="get">
                <input type="hidden" name="ipp" value='2'>
  	            <input type="hidden" name="page" value='1'>        
                <div class="d-flex">
                  <label for="search"></label>
                  <input name='input' type="text" class="form-control">
                  <button type="submit" name="search" class="btn btn-primary ml-2 font-weight-bold">Search</button>  
                </div>        
            </form>
            <div>
                <button class="btn btn-outline-primary ml-2 " onclick="print()"><i class="fas fa-print"></i></button>     
                <?php if(isset($_SESSION["activeadmin"])){ ?>
                <button class="btn btn-outline-primary ml-2 " onclick="window.document.location.href='addStaff.php'"><i class="fas fa-plus-square"></i></button>  
                <?php }?>   
            </div>
            </div>         
            <div class="clearfix mb-3"></div>		
            <div class="row marginTop">
                <div class="col-sm-12 paddingLeft pagerfwt">
                    <?php if($pages->items_total > 0) { ?>
                        <?php echo $pages->display_pages();?>
                        <?php echo $pages->display_items_per_page();?>
                        <?php echo $pages->display_jump_menu(); ?>
                    <?php }?>
                </div>
                <div class="clearfix"></div>
            </div>

            <div class="clearfix"></div>
            
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>User Name</th>
                        <th>Name</th>
                        <th align='center'>Detailes</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $x=[];
                    if($pages->items_total>0){
                        foreach($result as $row){ $x[]= $row;
                    ?>
                    <tr>
                        <td><?php echo $row['id']; ?></td>
                        <td><?php echo $row['username']; ?></td>
                        <td><?php echo $row['first'].' '.$row['last']; ?></td>
                        <td align='center'><button class="btn btn-primary" onclick="window.document.location.href='singleStaff.php?staffID=<?php echo $row['id'];?>'"><i class="fas fa-info"></i></button></td>
                    </tr>
                    <?php 
                        }
                    }else{?>
                    <tr>
                        <td colspan="6" align="center"><strong>No Record(s) Found!</strong></td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
            
            <div class="clearfix"></div>
            
            <div class="row marginTop">
                <div class="col-sm-12 paddingLeft pagerfwt">
                    <?php if($pages->items_total > 0) { ?>
                        <?php echo $pages->display_pages();?>
                        <?php echo $pages->display_items_per_page();?>
                        <?php echo $pages->display_jump_menu(); ?>
                    <?php }?>
                </div>
                <div class="clearfix"></div>
            </div>
            <div class="clearfix"></div>
          </div>
        </div>
      </div>
    </div>
  </div>

<script>  
function print(){
    var mywindow = window.open('', 'Print', 'height=1500,width=1500');
    var car = <?php echo json_encode($x); ?>;
    mywindow.document.write('<html><head><title>National Motor Company - Bahrain</title></br><h3 align=\'center\'>Employees Report</h3><hr>');
    mywindow.document.write('</head><body><table style="width:100%"><tr><th>ID</th><th>Username</th><th>Name</th><th>Tel</th></tr>');
    
    for (let index = 0; index < car.length; index++) {
        mywindow.document.write('<tr>');
        mywindow.document.write('<td align=\'center\'>'+car[index][0]+'</td>');
        mywindow.document.write('<td align=\'center\'>'+car[index][1]+'</td>');
        mywindow.document.write('<td align=\'center\'>'+car[index][2]+' '+car[index][3]+'</td>');
        mywindow.document.write('<td align=\'center\'>'+car[index][4]+'</td>');
        mywindow.document.write('</tr>');
    }                      

    mywindow.document.write('</tabel>');
    mywindow.document.write('</body>');
    mywindow.document.write('</html>');
    mywindow.document.close();
    mywindow.focus()
    mywindow.print();
    mywindow.close();
    return true;
}
</script>

  <!-- Modal -->
  <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Confirmation</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body text-success font-weight-bold">
        Delete Successfully !
      </div>
      <div class="modal-footer" align='center'>
        <button type="button" class="btn btn-outline-primary" data-dismiss="modal">Ok</button>
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

<?php if(isset($_GET['flag']) && $_GET['flag']=='d'){?>
<script type="text/javascript">
    $(window).on('load',function(){
        $('#exampleModal').modal('show');
    });
</script>
<?php }?>

</html>