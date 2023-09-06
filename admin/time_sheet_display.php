<?php
    session_start();
    include("../connection.php");
    include("nav_bar.php");

    if(isset($_SESSION['admin']) && isset($_SESSION['login'])){


?>
<html data-bs-theme="dark" lang='en-US'>
	<head>
        <title> Time Sheet </title>    

        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <!-- BS5 and JS Includes -->
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js" integrity="sha384-fbbOQedDUMZZ5KreZpsbe1LCZPVmfTnH7ois6mU1QK+m14rQ1l2bGBq41eYeM/fS" crossorigin="anonymous"></script>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
        
        <style>
        </style>

	</head>
<body>
    <div class="container mt-5 text-center button-container">

        <!-- <form method="POST" action="#">
            <?php 
                $statement = $con_obj->conn->prepare("SELECT fname, email FROM users");
                $statement->execute();
                $res = $statement->get_result();
                while($d = $res->fetch_assoc()){
                    ?>
                        <button type='submit' name='employee_name' value='<?php echo $d["email"]; ?>' class='btn btn-info m-3'> <?php echo $d["fname"]; ?> </button>
                    <?php
                }

            ?>
        </form> -->

    </div>

    <div class="container">
        <?php 
            // Alert for actions
            if(isset($_SESSION['xxx'])){
                if($_SESSION['del_status']){
                    ?>
                        <div class="alert alert-success mt-4">
                            The user was deleted
                        </div>
                    <?php
                    $_SESSION['del_status'] = false;
                }
            }
        
        ?>
        


        <div class="table-responsive">

            <table class='table table-dark table-striped mt-5'>
                <tr>
                    <th colspan='6' class='text-center p-3'><h3> All Time Sheet </h3>
                </tr>
                <tr>
                    <th colspan='6' class='text-center'>
                </tr>
                <tr>
                    <th> Name
                    <th> Date
                    <th> Start Time
                    <th> End Time
                    <th> Duration
                    <th> Actions
                </tr>
                <?php

                    $statement = $con_obj->conn->prepare("SELECT * FROM time_sheet");
                    $statement->execute();
                    $res = $statement->get_result();
                    while($d = $res->fetch_assoc()){
                        ?>
                            
                            <tr>
                                <td> <?php echo $d['fname']; ?>
                                <td> <?php echo $d['date']; ?>
                                <td> <?php echo $d['start_time']; ?>
                                <td> <?php echo $d['end_time']; ?>
                                <td> <?php echo $d['duration']; ?>
                                <td> <button class='btn btn-danger'> Action BTN </button>
                            </tr>


                        <?php
                    }
                    

                ?>
            </table>
        </div>
    </div>

</body>
    <script>
        
    </script>
</html>
<?php 

    }
    else{
        echo "<script> window.location.href='login.php' </script>";
    }

?>