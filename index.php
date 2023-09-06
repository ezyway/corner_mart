<?php
    include("connection.php");
    session_start();


    if(isset($_POST["Submit"])){

        $date=$_POST["date"];
        $time=$_POST["time"];
        $ip=$_SERVER["REMOTE_ADDR"];
        $user_agent=$_SERVER['HTTP_USER_AGENT'];
        
        $prepared_statement = $con_obj->conn->prepare("INSERT INTO visitors(ip,date,time,user_agent) VALUES(?,?,?,?)");
        $prepared_statement->bind_param('ssss', $ip, $date, $time, $user_agent);
        // echo $prepared_statement;
        $result = $prepared_statement->execute();
        $prepared_statement->close();
        

        
        // Check if the data is recorded
        if($result){
            echo $_SESSION["index"] = true;
            $result = $con_obj->conn->query("SELECT id FROM visitors ORDER BY id DESC LIMIT 1");
            $data = $result->fetch_array();
            echo $_SESSION["visitorCount"] = $data[0];
            
            // Check if user came from another page
            if(isset($_GET["from"])){
                echo "<script>window.location='".$_GET['from']."'</script>";
            }
            else{
                echo "<script>window.location='index.html'</script>"; //Send user to login
            }
        }
        else{
            echo "<h1 align='center'>Error while recording.. Please contact the admin</h1>"; //If data was not recorded, then display this
        }
    }
?>
<html>
	<head>
		<script src='jquery-3.7.0.min.js'></script>
		<script>
			$(document).ready(function(){
				var dt=new Date();
				var month=["January","February","March","April","May","June","July","August","September","October","November","December"];
				var date=dt.getDate() +' - '+ month[dt.getMonth()] +' - '+ dt.getFullYear();
				
				var hours=dt.getHours() == 0 ? 12 : dt.getHours();
				var time=(dt.getHours() < 12 ? hours : dt.getHours()-12) +':'+ ('0' + dt.getMinutes()).slice(-2) +':'+ ('0' + dt.getSeconds()).slice(-2) +' '+(dt.getHours() < 12 ? "AM" : "PM");
				
				$(".date_textbox").val(date);
				$(".time_textbox").val(time);
				
				$("#submit").click();
			});
		</script>
	</head>
<body>
	<form action="#" method='POST'>
		<input type='text' name='date' class='date_textbox'>
		<input type='text' name='time' class='time_textbox'>
		<input type='submit' name='Submit' id='submit'>
	</form>
</body>
</html>