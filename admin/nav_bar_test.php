<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- BS5 and JS Includes -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js" integrity="sha384-fbbOQedDUMZZ5KreZpsbe1LCZPVmfTnH7ois6mU1QK+m14rQ1l2bGBq41eYeM/fS" crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
        
    <title>Document</title>
</head>
<body>



<nav class="navbar navbar-expand-sm navbar-dark bg-dark">
    <div class="container-fluid">
        <a class="navbar-brand" href="home.php">Corner Mart <?php echo ($_SESSION['admin']) ? "<font style='color:red;'>Admin</font>" : "Employee" ?></a>
        
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mynavbar">
            <span class="navbar-toggler-icon"></span>
        </button>
        
        <div class="collapse navbar-collapse" id="mynavbar">
            <ul class="navbar-nav mx-auto">

                <?php
                
                    if(isset($_SESSION['admin']) && $_SESSION['admin']){
                        ?>
                            <li class="nav-item"><a class="nav-link" href="time_sheet_display.php">Time Punches</a></li>
                            <li class="nav-item"><a class="nav-link" href="payments.php">Payments</a></li>
                            <li class="nav-item"><a class="nav-link" href="payslips.php">Payslips</a></li>
                            <li class="nav-item"><a class="nav-link" href="manage_employees.php">Manage Employees</a></li>
                            <li class="nav-item"><a class="nav-link" href="download_data.php">Download Data</a></li>
                        <?php
                    }
                    else{
                        ?>
                            <li class="nav-item"><a class="nav-link" href="my_time_punch.php">Time Punch</a></li>
                            <li class="nav-item"><a class="nav-link" href="my_payslips.php">Payments</a></li>
                        <?php
                    }

                ?>
                
            </ul>
            
            <ul class="navbar-nav ml-auto">
                    <li class="nav-item"><a class="nav-link" href="javascript:void(0)"><?php echo "Welcome ".$_SESSION['fname']; ?></a></li>
            </ul>
        </div>
    </div>
</nav>


    
</body>
</html>