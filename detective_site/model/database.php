<?php 
    $connect2sql = array(
        'server' => 'mysql:host=localhost;dbname=id12961382_detective_site',
        'username' => 'id12961382_rtmaggs',
        'password' => '5Wf5GX^q2pvAKJxZjIwS'
    );

    $database = new PDO($connect2sql['server'], $connect2sql['username'], $connect2sql['password']);
    $database->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
	/*
	$host="localhost";
	$username="id12961382_rtmaggs";
	$password="5Wf5GX^q2pvAKJxZjIwS";
	$dbname="id12961392_detective_site";

	$conn=mysqli_connect($host,$username,$password,$dbname);
	if(mysqli_connect_errno())
		echo "Connection could not be established... ".mysqli_connect_error();
	else
		echo "Successfully connected...";
	*/
		
?>
