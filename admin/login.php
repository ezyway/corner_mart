<?php
    session_start();
    include("../connection.php");

    // Login Handler
    if(isset($_POST["submit"])){
        // echo "submit handled";

        $email = $_POST["email"];
        $pass = $_POST["pass"];

        $statement = $con_obj->conn->prepare("SELECT * FROM users WHERE email=?");
        $statement->bind_param("s", $email);
        $statement->execute();
        $result = $statement->get_result();
        $data = $result->fetch_assoc();

        
        if($result){        // query exec check
            if($result->num_rows > 0){        // record check for email
                if(password_verify($pass, $data['pass'])){      // Password check from the DB hash
                    // Login Session
                    $_SESSION["login"] = true;
                    $_SESSION["fname"] = $data['fname'];
                    $_SESSION["email"] = $data['email'];
                    // $data = $data->fetch_assoc();

                    if($data['admin']){
                        // admin Session set
                        $_SESSION['admin'] = true;
                    }
                    else{
                        $_SESSION['admin'] = false;
                    }
                    header("Location:home.php");        // Redirection after conformation
                }
                else{
                    header("Location:login.php?status=wrong");      // Redirection on fail
                }
            }
        }
        else{
            echo "DB failed";       // Failed DB connection message
        }
        
    }
?>
<html data-bs-theme="dark" lang='en-US'>
	<head>
        
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <!-- BS5 and JS Includes -->
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js" integrity="sha384-fbbOQedDUMZZ5KreZpsbe1LCZPVmfTnH7ois6mU1QK+m14rQ1l2bGBq41eYeM/fS" crossorigin="anonymous"></script>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
        
	</head>
<body>

    <div class="d-flex justify-content-center">

        <div class="card mt-5" style="width:350px">

            <?php
                // Alert for wrong password
                if(isset($_GET['status'])){
                    ?>
                        <div class="alert alert-danger">
                            Invalid Credentials
                        </div>
                    <?php
                }
                else{
                    ?> <h4 class="card-header text-center">Login</h4> <?php
                }
            ?>

            
            <div class="card-body">
                <img class="card-img-top" src="../assets/images/login.png" alt="Login Image">
                
                <p class="card-text">

<!-- Login Form START ----------------------------------------------------------------------------------------------------------------- -->
                    <form action="#" method="POST">
                        
                        <div class="input-group">
                            <span class="input-group-text">E-mail: </span>
                            <input type="text" class="form-control" placeholder="E-mail" name="email">
                        </div>

                        <div class="input-group mt-2">
                            <span class="input-group-text">Password: </span>
                            <input type="password" class="form-control" placeholder="Password" name="pass">
                        </div>

                        <div class="mt-3 text-center">
                            <input type="submit" value="Login" name="submit" class='btn btn-success'>
                        </div>
                        

                    </form>
<!-- Login Form END ------------------------------------------------------------------------------------------------------------------- -->
                </p>
            </div>
        </div>
    </div>

</body>
</html>