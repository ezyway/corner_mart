<?php
    session_start();
    include("../connection.php");



    // Submit Handler
    if(isset($_POST['submit'])){
        $fname = $_POST["fname"];
        $lname = $_POST["lname"];
        $email = $_POST["email"];
        $phone = $_POST["phone"];
        $pass = password_hash($_POST["pass"], PASSWORD_DEFAULT);
        $dob = $_POST["dob"];
        $useragent = $_POST["useragent"];
        $isadmin = 0;
        
        
        // Checking for empty values
        // $all_values = array($fname, $lname, $email, $phone, $pass, $dob, $useragent, $date, $time);
        // for($i = 0; $i <= count($all_values); $i++){
        //     if(empty($all_values[$i])){
        //         header("Location:register.php?status=missing_values");
        //     }
        // }

        $statement = $con_obj->conn->prepare("INSERT INTO users(fname, lname, email, phone, pass, dob, useragent, admin) VALUES(?,?,?,?,?,?,?,?)");   
        $statement->bind_param("ssssssss", $fname, $lname, $email, $phone, $pass, $dob, $useragent, $isadmin);
        $res = $statement->execute();

        if($res){
            header("Location:login.php");
        }
        else{
            echo "Problem";
        }

    }
?>
<html data-bs-theme="dark" lang='en-US'>
	<head>
        <title> Register </title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <!-- BS5 and JS Includes -->
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js" integrity="sha384-fbbOQedDUMZZ5KreZpsbe1LCZPVmfTnH7ois6mU1QK+m14rQ1l2bGBq41eYeM/fS" crossorigin="anonymous"></script>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
        
	</head>
<body>
    <div class="container mt-5">
        <?php
            if(isset($_GET['status'])){
                ?>
                    <div class="alert alert-danger">
                        Please input all the data.
                    </div>
                <?php
            }
        ?>
    </div>
    <div class="container">
        <form action="#" method='POST'>

            <div class="row mt-5">
                <div class="col-md-6 col-sm-12">
                    <div class="input-group">
                        <span class="input-group-text">First Name</span>
                        <input type="text" class="form-control" name='fname'>
                    </div>
                </div>

                <div class="col-md-6 col-sm-12">
                    <div class="input-group">
                        <span class="input-group-text">Last Name</span>
                        <input type="text" class="form-control" name='lname'>
                    </div>
                </div>
            </div>


            <div class="row mt-3">
                <div class="col-md-6 col-sm-12">
                    <div class="input-group">
                        <span class="input-group-text">E-mail</span>
                        <input type="email" class="form-control" name='email'>
                    </div>
                </div>

                <div class="col-md-6 col-sm-12">
                    <div class="input-group">
                        <span class="input-group-text">Phone-Number:</span>
                        <input type="tel" class="form-control" name='phone'>
                    </div>
                </div>
            </div>


            <div class="row mt-3">
                <div class="col-md-6 col-sm-12">
                    <div class="input-group">
                        <span class="input-group-text">Password</span>
                        <input type="password" class="form-control" name='pass' id='pass'>
                    </div>
                </div>

                <div class="col-md-6 col-sm-12">
                    <div class="input-group">
                        <span class="input-group-text">Confirm Password:</span>
                        <input type="password" class="form-control" name='cpass' id='cpass'>
                    </div>
                </div>
            </div>


            <div class="row mt-3">
                <div class="col-md-6 col-sm-12">
                    <div class="input-group">
                        <span class="input-group-text">Date of Birth</span>
                        <input type="date" class="form-control" name='dob'>
                    </div>
                </div>

                <div class="col-md-6 col-sm-12">
                    <div class="input-group">
                        <span class="input-group-text">IP Address</span>
                        <input type="tel" class="form-control" name='ip' value='<?php echo $_SERVER["REMOTE_ADDR"]; ?>' readonly>
                    </div>
                </div>
            </div>


            <div class="row mt-3">
                <div class="col-sm-12">
                    <div class="input-group">
                        <span class="input-group-text">User Agent</span>
                        <input type="text" class="form-control" name='useragent' value='<?php echo $_SERVER["HTTP_USER_AGENT"]; ?>' readonly>
                    </div>
                </div>
            </div>


            <div class="row mt-3">
                <div class="col-md-4 col-sm-12">
                    <div class="input-group">
                        <span class="input-group-text">Date</span>
                        <input type="text" class="form-control" name='cur_date' readonly>
                    </div>
                </div>

                <div class="col-md-4 col-sm-12">
                    <div class="input-group">
                        <span class="input-group-text">Time</span>
                        <input type="tel" class="form-control" name='cur_time' readonly>
                    </div>
                </div>

                <div class="col-md-4 col-sm-12">
                    <div class="input-group">
                        <span class="input-group-text">User Type</span>
                        <input type="tel" class="form-control" value='Normal User' readonly>
                    </div>
                </div>
            </div>


            <div class="row mt-5">
                <div class="col-4"></div>
                <input type="submit" value="Register" name="submit" class="btn btn-lg btn-primary col-4">
                <div class="col-4"></div>
            </div>


        </form>
    </div>
    
</body>
    <script>
        
    </script>
</html>