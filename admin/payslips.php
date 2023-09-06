<?php
    session_start();
    include("../connection.php");
    include("nav_bar.php");

    if(isset($_SESSION['login']) && isset($_SESSION['admin'])){

        if(isset($_POST['submit'])){
            // Generate a unique filename for the uploaded image
            $uniqueFilename = uniqid('image_') . '_' . time() . '.' . pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
            // Set the upload directory
            $uploadDirectory = '../assets/payslips/';
            // Check if the file was successfully uploaded
            move_uploaded_file($_FILES['image']['tmp_name'], $uploadDirectory . $uniqueFilename);

            $date = $_POST['date'];
            
            $temp = explode("|", $_POST['user_name']);
            $fname = $temp[0];
            $email = $temp[1];


            $statement = $con_obj->conn->prepare("INSERT INTO payslip(fname, email, filename, date) VALUES(?,?,?,?)");
            $statement->bind_param("ssss", $fname, $email, $uniqueFilename, $date);
            $res = $statement->execute();

        }

?>
<html data-bs-theme="dark" lang='en-US'>
	<head>
        <title> Payslips </title>    

        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <!-- BS5 and JS Includes -->
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js" integrity="sha384-fbbOQedDUMZZ5KreZpsbe1LCZPVmfTnH7ois6mU1QK+m14rQ1l2bGBq41eYeM/fS" crossorigin="anonymous"></script>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
        
	</head>
<body>
    
    <div class="container mt-5">
        <div class="card mx-auto" style="width:500px">
            <form action="#" method='post' enctype='multipart/form-data'>
                <div class="card-header text-center">Upload Payslip</div>
                <!-- <div class="card-body">
                    <img src="../assets/images/payslip.png" alt="Payslip Image Alt" width='470px'>
                </div> -->
                <div class="card-body">

<!-- Upload Form START ----------------------------------------------------------------------------------------------------------------- -->

                        <div class="form-floating">
                            <select class="form-select" id="users" name="user_name" data-bs-ignore>
                                <option value="" selected disabled>Select Employee</option>
                                    <?php 
                                        $statement = $con_obj->conn->prepare("SELECT fname, email FROM users");
                                        $statement->execute();
                                        $res = $statement->get_result();
                                        while($d = $res->fetch_assoc()){
                                            ?>
                                                <option value='<?php echo $d["fname"]."|".$d["email"]; ?>'> <?php echo $d["fname"]; ?> </option>
                                            <?php
                                        }

                                    ?>
                            </select>
                            <label for="users" class="form-label">Select Employee:</label>
                        </div>


                        <div class="mb-3 mt-3">
                            <label for="upload_img" class="form-label"> Upload Payslip </label>
                            <input class="form-control form-control" name='image' id="upload_img" type="file">
                        </div>

                        <div class="input-group mb-3 mt-3">
                            <span class="input-group-text">Date</span>
                            <input type="text" class="form-control" name='date' readonly value='<?php echo date("d - m - Y"); ?>'>
                        </div>


                        <div class="mt-3 text-center">
                            <input type="submit" value="Upload" name="submit" class='btn btn-success'>
                        </div>


<!-- Upload Form END ------------------------------------------------------------------------------------------------------------------- -->

                </div>
            </form>
        </div>
    </div>
    

<div class="alert alert-info mt-5 text-center"> Click on the image to expand </div>



<!-- Display START ------------------------------------------------------------------------------------------------------------------- -->

                    <div class="container mt-5 mb-5">
                        
                            
                        <?php
                            $statement = $con_obj->conn->prepare("SELECT * FROM payslip");
                            $statement->execute();
                            $res = $statement->get_result();

                            $cards_per_row = 3; // Set the number of cards per row
                            $card_counter = 0; // Initialize the card counter
                            
                            echo '<div class="row row-cols-1 row-cols-md-2 row-cols-lg-3">';
                            
                            while ($row = $res->fetch_assoc()) {
                                if ($card_counter % $cards_per_row === 0 && $card_counter !== 0) {
                                    echo '</div><div class="row row-cols-1 row-cols-md-2 row-cols-lg-3">'; // Close and open a new row
                                }
                                    ?>
                                        <div class="col mb-4">
                                            <div class="card">
                                                <div class="card-header"> <?php echo $row['id']." - ".$row['fname']; ?> </div>
                                                <div class="card-body"> <a href="../assets/payslips/<?php echo $row['filename']; ?>"><img src="../assets/payslips/<?php echo $row['filename']; ?>" alt="Image" class="img-fluid"></a> </div>
                                                <div class="card-footer">
                                                    <?php echo $row['date']; ?>
                                                    <!-- Delete Button -->
                                                </div>
                                            </div>
                                        </div>
                                    <?php
                                $card_counter++;
                            }
                            
                            echo '</div>'; // Close the final row
                            ?>

                        
                    </div>

<!-- Display END   ------------------------------------------------------------------------------------------------------------------- -->
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