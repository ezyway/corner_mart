<?php
    session_start();
    include("../connection.php");
    include("nav_bar.php");

    function calculateHours($start_str, $end_str){
        // Convert into obj
        $start = DateTime::createFromFormat('h:i A', $start_str);
        $end = DateTime::createFromFormat('h:i A', $end_str);

        if ($start !== false && $end !== false) {
            // Calculate the interval between the start time and the end time
            $interval = $end->diff($start);
            
            // Calculate the duration in hours
            $hours = $interval->h + ($interval->days * 24);
            
            return $hours;
        }
    }

    if(isset($_SESSION['login'])){

        //Clock In Handler Start  ------------------------------------------------------------------------------------------------------------------------
        
        if(isset($_POST['clockin_submit'])){
            $fname = $_SESSION['fname'];
            $email = $_SESSION['email'];
            $ip=$_SERVER["REMOTE_ADDR"];
            $usersagent=$_SERVER['HTTP_USER_AGENT'];
            $date = $_POST['date'];
            $start_time = $_POST["clockin_time"];

            if(isset($_POST['clockin_submit'])){
                $statement = $con_obj->conn->prepare("INSERT INTO time_sheet(fname, email, date, start_time, ip, useragent) VALUES(?, ?, ?, ?, ?, ?)");
                $statement->bind_param("ssssss", $fname, $email, $date, $start_time, $ip, $usersagent);
                $res_in = $statement->execute();
            }
        }

        //Clock In Handler End ---------------------------------------------------------------------------------------------------------------------------


        //Clock Out Handler Start ------------------------------------------------------------------------------------------------------------------------
        
        if(isset($_POST['clockout_submit'])){
            $fname = $_SESSION['fname'];
            $email = $_SESSION['email'];
            $date = $_POST['date'];
            $end_time = $_POST["clockout_time"];

            if(isset($_POST['clockout_submit'])){

                $statement = $con_obj->conn->prepare("SELECT id, start_time FROM time_sheet WHERE end_time='0' AND email=?");
                $statement->bind_param("s", $email);
                $statement->execute();
                $res = $statement->get_result();
                $data = $res->fetch_assoc();
                $id = $data['id'];
                $start_time = $data['start_time'];
                $duration = calculateHours($start_time, $end_time);


                $statement = $con_obj->conn->prepare("UPDATE time_sheet SET end_time=?, duration=? WHERE id=?");
                $statement->bind_param("sii", $end_time, $duration, $id);
                $res_out = $statement->execute();
            }
        }

        //Clock Out Handler End --------------------------------------------------------------------------------------------------------------------------

?>
<!DOCTYPE html>
<html data-bs-theme="dark" lang='en-US'>
	<head>
        <title> My Time Punch </title>

        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <!-- BS5 and JS Includes -->
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js" integrity="sha384-fbbOQedDUMZZ5KreZpsbe1LCZPVmfTnH7ois6mU1QK+m14rQ1l2bGBq41eYeM/fS" crossorigin="anonymous"></script>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
        
        <script src='../jquery-3.7.0.min.js'></script>
        <script>
            $(document).ready(function(){
                var dt=new Date();
                var month=["January","February","March","April","May","June","July","August","September","October","November","December"];
                var date=dt.getDate() +' - '+ month[dt.getMonth()] +' - '+ dt.getFullYear();
                
                var hours=dt.getHours() == 0 ? 12 : dt.getHours();
                var time=(dt.getHours() < 12 ? hours : dt.getHours()-12) +':'+ ('0' + dt.getMinutes()).slice(-2) +' '+(dt.getHours() < 12 ? "AM" : "PM");
                
                $(".date_textbox").val(date);
                $(".time_textbox").val(time);
                
                // $("#submit").click();
            });
        </script>

	</head>
<body>
    <div class="container mt-5">
        
        <?php 
        
        if(isset($res_in) && $res_in){
            ?>
                <div class="alert alert-success" role="alert">
                    Clock In time recorded at <?php echo $start_time; ?>
                </div>

                <script>
                    $(document).ready(function(){
                        $(".card").hide();
                    });
                </script>
            <?php
        }
        if(isset($res_out) && $res_out){
            ?>
                <div class="alert alert-success" role="alert">
                    Clock Out time recorded at <?php echo $end_time; ?>
                </div>

                <script>
                    $(document).ready(function(){
                        $(".card").hide();
                    });
                </script>
            <?php
        }
        
        ?>
    
        <form action="#" method="post">
            <div class="card">
                <div class="card-header"> Clock In </div>
                <div class="card-body"> 
                    <div class="input-group">
                        <span class="input-group-text">Current Time</span>
                        <input type="text" class="form-control time_textbox" name='clockin_time'>
                    </div>
                    <div class="input-group mt-3">
                        <span class="input-group-text">Date</span>
                        <input type="text" class="form-control date_textbox" name='date' readonly>
                    </div>
                </div>
                <div class="card-footer d-flex justify-content-end"><input type="submit" value="Clock In" name='clockin_submit' class='btn btn-primary'></div>
            </div>
        </form>
        
        
        <form action="#" method="post">
            <div class="card">
                <div class="card-header"> Clock Out </div>
                <div class="card-body"> 
                    <div class="input-group">
                        <span class="input-group-text">Current Time</span>
                        <input type="text" class="form-control time_textbox" name='clockout_time'>
                    </div>
                    <div class="input-group mt-3">
                        <span class="input-group-text">Date</span>
                        <input type="text" class="form-control date_textbox" name='date' readonly>
                    </div>
                </div>
                <div class="card-footer d-flex justify-content-end"><input type="submit" value="Clock Out" name='clockout_submit' class='btn btn-primary'></div>
            </div>
        </form>

    </div>
    
    
    <!-- Individual Time SHeet ------------------------------------------------------------------------------------------------------- -->
    <div class="container">

        <div class="table-responsive">

            <table class='table table-dark table-striped mt-5'>
                <tr>
                    <th colspan='6' class='text-center p-3'><h3> My Time Sheet </h3>
                </tr>
                <tr>
                    <th colspan='6' class='text-center'>
                </tr>
                <tr>
                    <th> Name
                    <th> Email
                    <th> Start Time
                    <th> End Time
                    <th> Duration
                    <th> Actions
                </tr>
                <?php

                    $statement = $con_obj->conn->prepare("SELECT * FROM time_sheet WHERE email=?");
                    $statement->bind_param("s",$_SESSION['email']);
                    $statement->execute();
                    $res = $statement->get_result();
                    while($d = $res->fetch_assoc()){
                        ?>
                            
                            <tr>
                                <td> <?php echo $d['fname']; ?>
                                <td> <?php echo $d['email']; ?>
                                <td> <?php echo $d['start_time']; ?>
                                <td> <?php echo $d['end_time']; ?>
                                <td> <?php echo $d['duration']; ?>
                                <td> <button class='btn btn-danger' disabled> Edit </button>
                            </tr>


                        <?php
                    }
                    

                ?>
            </table>
        </div>

    </div>
</body>
    
    
</html>
<?php 

    }
    else{
        echo "<script> window.location.href='login.php' </script>";
    }

?>