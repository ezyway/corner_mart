<?php
    session_start();
    include("../connection.php");
    include("nav_bar.php");

    if($_SESSION['login'] && $_SESSION['admin']){

        // Delete Handler
        if(isset($_GET['del_id'])){
            $statement = $con_obj->conn->prepare("DELETE FROM users WHERE id=?");
            $statement->bind_param("i",$_GET['del_id']);
            $res = $statement->execute();

            if($res){
                $_SESSION['del_status'] = true;
                header("Location:manage_employees.php");
            }
            else{
                $_SESSION['del_status'] = false;
                header("Location:manage_employees.php");
            }
        }

?>
<html data-bs-theme="dark" lang='en-US'>
	<head>
        <title> Manage Employees </title>
        
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <!-- BS5 and JS Includes -->
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js" integrity="sha384-fbbOQedDUMZZ5KreZpsbe1LCZPVmfTnH7ois6mU1QK+m14rQ1l2bGBq41eYeM/fS" crossorigin="anonymous"></script>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
        
	</head>
<body>

    <div class="container">
        
        <?php 
            // Alert for actions
            if(isset($_SESSION['del_status'])){
                if($_SESSION['del_status']){
                    ?>
                        <div class="alert alert-success mt-4">
                            The user was deleted
                        </div>
                    <?php
                    // $_SESSION['del_status'] = false;
                }
            }
        
        ?>
        


        <div class="table-responsive">

            <table class='table table-dark table-striped mt-5'>
                <tr>
                    <th colspan='6' class='text-center p-3'><h3>Employee List</h3>
                </tr>
                <tr>
                    <th colspan='6' class='text-center'>
                </tr>
                <tr>
                    <th> Name
                    <th> Email
                    <th> Phone
                    <th> Store
                    <th> Last Seen
                    <th> Actions
                </tr>
                <?php

                    $statement = $con_obj->conn->prepare("SELECT * FROM users");
                    $statement->execute();
                    $res = $statement->get_result();
                    while($d = $res->fetch_assoc()){
                        ?>
                            
                            <tr>
                                <td> <?php echo $d['fname']." ".$d['lname']; ?>
                                <td> <?php echo $d['email']; ?>
                                <td> <?php echo $d['phone']; ?>
                                <td> <?php echo "Placeholder"; ?>
                                <td> <?php echo $d['last_login_date']."<br>".$d['last_login_time']; ?>
                                <td> <button class='btn btn-danger' onclick="window.location.href='manage_employees.php?del_id=<?php echo $d['id']; ?>'"> Delete Employee </button>
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