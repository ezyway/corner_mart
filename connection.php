<?php
    // Initial OOP Concept DB connection
	// class connect
	// {
	// 	public $host="localhost";
	// 	public $username="root";
	// 	public $password="";
	// 	public $database="intel";
	// 	public $con;
		
	// 	function __construct()
	// 	{
	// 		$this->con=mysqli_connect($this->host,$this->username,$this->password,$this->database) or die("<h1>Connection to the Database was Failed. Please contact the admin at Mobile No- +xx xxx xxx xxxx or at E-mail: xxxxxxxx@xxx.xx</h1>");
	// 	}
	// 	function query_idu($query)
	// 	{
	// 		$query_var=mysqli_query($this->con,$query);
	// 		return $query_var;
	// 	}

	// 	function query_s($query)
	// 	{
	// 		$query_var=mysqli_query($this->con,$query);
	// 		if(isset($query_var))
	// 			return $query_var;
	// 		else
	// 			return 0;
	// 	}
	// }
	// $con_obj=new connect();

    // Prepared Statement way of DB connection
    class connect
	{
		public $host="localhost";
		public $username="id21121897_admin";
		public $password="Website@1";
		public $database="id21121897_corner_mart";
		public $conn;
		
        // Initiate Connection with Database
		function __construct()
		{
            try{
                $this->conn = new mysqli($this->host,$this->username,$this->password,$this->database);
				if($this->conn->connect_error){
					echo "Connection to DataBase was not established. Please contact the admin at <a href='email'>admin@domain.tld</a>";
				}
				else{
					// echo "Success";
				}
            }
            catch (Exception $e){
                echo $e->getMessage();
            }
		}
	}
	$con_obj=new connect();
?>