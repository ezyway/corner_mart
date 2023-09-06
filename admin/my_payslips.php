<?php
    session_start();
    include("../connection.php");
    include("nav_bar.php");

    if(isset($_SESSION['login'])){

?>
<html data-bs-theme="dark" lang='en-US'>
	<head>
        <title> My Payslips </title>    

        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <!-- BS5 and JS Includes -->
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js" integrity="sha384-fbbOQedDUMZZ5KreZpsbe1LCZPVmfTnH7ois6mU1QK+m14rQ1l2bGBq41eYeM/fS" crossorigin="anonymous"></script>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
        
	</head>
<body>

    <!-- Display START ------------------------------------------------------------------------------------------------------------------- -->

    <div class="container mt-5 mb-5">
                        
                            
        <?php

            echo $email = $_SESSION['email'];

            $statement = $con_obj->conn->prepare("SELECT * FROM payslip WHERE email=?");
            $statement->bind_param("s", $email);
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