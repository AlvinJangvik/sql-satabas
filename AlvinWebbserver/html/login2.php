<?php
	/*$username = $_POST['username'];
	$password = $_POST['password'];
	
	echo $username;
	echo "<br>";
	echo $password;*/
	
	if(empty($_POST['username'])||empty($_POST['password']))
	{
		// ej ifyllda fält
		header("Location:login.php");
	}
	
	require "../includes/connect.php";
	
	$username = filter_input(INPUT_POST, 'username',FILTER_SANITIZE_STRING,FILTER_FLAG_STRIP_LOW);
	$password = filter_input(INPUT_POST, 'password',FILTER_SANITIZE_STRING,FILTER_FLAG_STRIP_LOW);
	
	$sql = "SELECT password, status FROM users WHERE user=?";
	$res = $dbh->prepare($sql);
	$res->bind_param("s",$username);
	$res->execute();
	
	$result=$res->get_result();
	$row=$result->fetch_assoc();
	
	if(!$row)
	{
		//echo "Avändaren finns inte"
		header("Location:login.php?status=1");
		
	}
	else
	{
		if($row['password']==$password)
		{
			// echo "Användaren är inloggad"
			session_start();
			$_SESSION['username']=$username;
			header("Location:admin.php");
		}
		else
		{
			//echo Felaktigt lösenord
			header("Location:login.php?status=2");
		}
	}
?>